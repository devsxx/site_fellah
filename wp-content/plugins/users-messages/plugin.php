<?php

/*
Plugin Name: User's Messages (Communication)
Plugin URI: http://codecreatives.com
Description: User's Messages (Communication)
Version: 1.0
Author: Ali Nawaz
Author URI:  https://www.upwork.com/freelancers/~01eb95eeb2d4a2fbcd
*/

if ( ! class_exists( 'WP_List_Table' ) ) {
	require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

class Messages_List extends WP_List_Table {

	/** Class constructor */
	public function __construct() {
		// default sorting option
		if ( empty( $_REQUEST['orderby'] ) ) {
			$_REQUEST['orderby'] = 'created_at';
			$_REQUEST['order']   = 'desc';
		}

		parent::__construct( [
			'singular' => __( 'Message', 'sp' ), //singular name of the listed records
			'plural'   => __( 'Messages', 'sp' ), //plural name of the listed records
			'ajax'     => false //does this table support ajax?
		] );

	}


	/**
	 * Retrieve customers data from the database
	 *
	 * @param int $per_page
	 * @param int $page_number
	 *
	 * @return mixed
	 */
	public static function get_messages( $per_page = 5, $page_number = 1 ) {

		global $wpdb;

		$messagesTable = $wpdb->prefix . 'messages';
		$usersTable    = $wpdb->prefix . 'users';

		$sql = "SELECT $messagesTable.message_id,
		fromUser.display_name AS from_user,
		toUser.display_name AS to_user,
		$messagesTable.subject,
		$messagesTable.message,
		$messagesTable.created_at
		FROM $messagesTable
		LEFT JOIN $usersTable fromUser ON fromUser.ID = $messagesTable.from_id
		LEFT JOIN $usersTable toUser ON toUser.ID = $messagesTable.to_id";

		$user1 = isset($_GET['user1']) && $_GET['user1'] > 0 ? $_GET['user1'] : '';
		$user2 = isset($_GET['user2']) && $_GET['user2'] > 0 ? $_GET['user2'] : '';

		if ($user1 > 0 && $user2 > 0) {
			$sql .= " WHERE ($messagesTable.from_id = $user1 AND $messagesTable.to_id = $user2) OR ($messagesTable.from_id = $user2 AND $messagesTable.to_id = $user1)";
		}
		elseif ($user1 > 0) {
			$sql .= " WHERE ($messagesTable.from_id = $user1) OR ($messagesTable.to_id = $user1)";
		}
		elseif ($user2 > 0) {
			$sql .= " WHERE ($messagesTable.from_id = $user2) OR ($messagesTable.to_id = $user2)";
		}

		$sql .= " GROUP BY $messagesTable.message_id";

		if ( ! empty( $_REQUEST['orderby'] ) ) {
			$sql .= ' ORDER BY ' . esc_sql( $_REQUEST['orderby'] );
			$sql .= ! empty( $_REQUEST['order'] ) ? ' ' . esc_sql( $_REQUEST['order'] ) : ' ASC';
		}

		$sql .= " LIMIT $per_page";
		$sql .= ' OFFSET ' . ( $page_number - 1 ) * $per_page;

		$result = $wpdb->get_results( $sql, 'ARRAY_A' );

		return $result;
	}


	/**
	 * Delete a customer record.
	 *
	 * @param int $id customer ID
	 */
	public static function delete_customer( $id ) {
		global $wpdb;

		$wpdb->delete(
			"{$wpdb->prefix}messages",
			[ 'ID' => $id ],
			[ '%d' ]
		);
	}


	/**
	 * Returns the count of records in the database.
	 *
	 * @return null|string
	 */
	public static function record_count() {
		global $wpdb;

		$messagesTable = $wpdb->prefix . 'messages';

		$sql = "SELECT COUNT(*) FROM $messagesTable";

		$user1 = isset($_GET['user1']) && $_GET['user1'] > 0 ? $_GET['user1'] : '';
		$user2 = isset($_GET['user2']) && $_GET['user2'] > 0 ? $_GET['user2'] : '';

		if ($user1 > 0 && $user2 > 0) {
			$sql .= " WHERE ($messagesTable.from_id = $user1 AND $messagesTable.to_id = $user2) OR ($messagesTable.from_id = $user2 AND $messagesTable.to_id = $user1)";
		}
		elseif ($user1 > 0) {
			$sql .= " WHERE ($messagesTable.from_id = $user1) OR ($messagesTable.to_id = $user1)";
		}
		elseif ($user2 > 0) {
			$sql .= " WHERE ($messagesTable.from_id = $user2) OR ($messagesTable.to_id = $user2)";
		}

		return $wpdb->get_var( $sql );
	}


	/** Text displayed when no customer data is available */
	public function no_items() {
		_e( 'No messages avaliable.', 'sp' );
	}


	/**
	 * Render a column when no column specific method exist.
	 *
	 * @param array $item
	 * @param string $column_name
	 *
	 * @return mixed
	 */
	public function column_default( $item, $column_name ) {
		switch ( $column_name ) {
			case 'created_at':
				return date('d/m/Y h:i A', strtotime($item[ $column_name ]));
			default:
				// return print_r( $item, true ); //Show the whole array for troubleshooting purposes
				return $item[ $column_name ];
		}
	}

	/**
	 * Render the bulk edit checkbox
	 *
	 * @param array $item
	 *
	 * @return string
	 */
	function column_cb( $item ) {
		return sprintf(
			'<input type="checkbox" name="bulk-delete[]" value="%s" />', $item['message_id']
		);
	}


	/**
	 * Method for name column
	 *
	 * @param array $item an array of DB data
	 *
	 * @return string
	 */
	function column_name( $item ) {

		$delete_nonce = wp_create_nonce( 'sp_delete_customer' );

		$title = '<strong>' . $item['name'] . '</strong>';

		$actions = [
			'delete' => sprintf( '<a href="?page=%s&action=%s&customer=%s&_wpnonce=%s">Delete</a>', esc_attr( $_REQUEST['page'] ), 'delete', absint( $item['message_id'] ), $delete_nonce )
		];

		return $title . $this->row_actions( $actions );
	}


	/**
	 *  Associative array of columns
	 *
	 * @return array
	 */
	function get_columns() {
		$columns = [
			// 'cb'         => '<input type="checkbox" />',
			'from_user'  => __( 'From (Sender)', 'sp' ),
			'to_user'    => __( 'To (Receiver)', 'sp' ),
			'subject'    => __( 'Subject', 'sp' ),
			'message'    => __( 'Message', 'sp' ),
			'created_at' => __( 'Sent At', 'sp' )
		];

		return $columns;
	}


	/**
	 * Columns to make sortable.
	 *
	 * @return array
	 */
	public function get_sortable_columns() {
		$sortable_columns = array(
			'from_user'  => array( 'from_user', true ),
			'to_user'    => array( 'to_user', false ),
			'subject'    => array( 'subject', false ),
			'message'    => array( 'message', false ),
			'created_at' => array( 'created_at', false )
		);

		return $sortable_columns;
	}

	/**
	 * Returns an associative array containing the bulk action
	 *
	 * @return array
	 */
	public function get_bulk_actions() {
		$actions = [
			'bulk-delete' => 'Delete'
		];

		// return $actions;
	}


	/**
	 * Handles data query and filter, sorting, and pagination.
	 */
	public function prepare_items() {

		$this->_column_headers = $this->get_column_info();

		/** Process bulk action */
		$this->process_bulk_action();

		$per_page     = $this->get_items_per_page( 'messages_per_page', 50 );
		$current_page = $this->get_pagenum();
		$total_items  = self::record_count();

		$this->set_pagination_args( [
			'total_items' => $total_items, //WE have to calculate the total number of items
			'per_page'    => $per_page //WE have to determine how many items to show on a page
		] );

		$this->items = self::get_messages( $per_page, $current_page );
	}

	public function process_bulk_action() {

		//Detect when a bulk action is being triggered...
		if ( 'delete' === $this->current_action() ) {

			// In our file that handles the request, verify the nonce.
			$nonce = esc_attr( $_REQUEST['_wpnonce'] );

			if ( ! wp_verify_nonce( $nonce, 'sp_delete_customer' ) ) {
				die( 'Go get a life script kiddies' );
			}
			else {
				self::delete_customer( absint( $_GET['customer'] ) );

		                // esc_url_raw() is used to prevent converting ampersand in url to "#038;"
		                // add_query_arg() return the current url
		                wp_redirect( esc_url_raw(add_query_arg()) );
				exit;
			}

		}

		// If the delete bulk action is triggered
		if ( ( isset( $_POST['action'] ) && $_POST['action'] == 'bulk-delete' )
		     || ( isset( $_POST['action2'] ) && $_POST['action2'] == 'bulk-delete' )
		) {

			$delete_ids = esc_sql( $_POST['bulk-delete'] );

			// loop over the array of record IDs and delete them
			foreach ( $delete_ids as $id ) {
				self::delete_customer( $id );

			}

			// esc_url_raw() is used to prevent converting ampersand in url to "#038;"
		        // add_query_arg() return the current url
		        wp_redirect( esc_url_raw(add_query_arg()) );
			exit;
		}
	}

	public function extra_tablenav( $which ) {
	    global $wpdb, $testiURL, $tablename, $tablet;
		$usersTable = $wpdb->prefix . 'users';
	    // $move_on_url = '&cat-filter=';
	    if ( $which == "top" ){
	        ?>
	        <div class="alignleft actions bulkactions">
		        <?php
		        	$users = $wpdb->get_results("SELECT $usersTable.ID, $usersTable.display_name, $usersTable.user_login FROM $usersTable ORDER BY display_name ASC, user_login ASC", ARRAY_A);
		        	if ($users) {
		        ?>
        			<div class="alignleft actions"><b>User 1:</b></div>
		            <select name="user1" id="user1">
		                <option value="">All Users</option>
		                <?php foreach( $users as $user ) { ?>
		                	<option value="<?php echo $user['ID']; ?>" <?php echo isset($_GET['user1']) && $_GET['user1'] == $user['ID'] ? ' selected = "selected"' : ''; ?>><?php echo $user['display_name']; ?> (<?php echo $user['user_login']; ?>)</option>
		                <?php } ?>
		            </select>
        			<div class="alignleft actions"><b>User 2:</b></div>
		            <select name="user2" id="user2">
		                <option value="">All Users</option>
		                <?php foreach( $users as $user ) { ?>
		                	<option value="<?php echo $user['ID']; ?>" <?php echo isset($_GET['user2']) && $_GET['user2'] == $user['ID'] ? ' selected = "selected"' : ''; ?>><?php echo $user['display_name']; ?> (<?php echo $user['user_login']; ?>)</option>
		                <?php } ?>
		            </select>
		        <?php } ?>
		        <script>
		        	function filterMessages() {
		        		var url = window.location.href;
		        		var urlParts = url.split('?');
		        		var user1 = document.getElementById('user1').value;
		        		var user2 = document.getElementById('user2').value;
		        		var finalUrl = urlParts[0] + '?page=wp_list_messages';
		        		if (parseInt(user1) > 0) {
		        			finalUrl += '&user1=' + user1;
		        		}
		        		if (parseInt(user2) > 0) {
		        			finalUrl += '&user2=' + user2;
		        		}
		        		window.location.href = finalUrl;
		        	}
		        	function resetMessages() {
		        		var url = window.location.href;
		        		var urlParts = url.split('?');
		        		var finalUrl = urlParts[0] + '?page=wp_list_messages';
		        		window.location.href = finalUrl;
		        	}
		        </script>
		        <input type="button" name="filter_messages" value="Filter" onclick="return filterMessages();" />
		        <input type="button" name="reset_messages" value="Reset" onclick="return resetMessages();" />
	        </div>
	        <?php
	    }
	    if ( $which == "bottom" ){
	        //The code that goes after the table is there
	    }
	}

}


class SP_Plugin {

	// class instance
	static $instance;

	// customer WP_List_Table object
	public $messages_obj;

	// class constructor
	public function __construct() {
		add_filter( 'set-screen-option', [ __CLASS__, 'set_screen' ], 10, 3 );
		add_action( 'admin_menu', [ $this, 'plugin_menu' ] );
	}


	public static function set_screen( $status, $option, $value ) {
		return $value;
	}

	public function plugin_menu() {

		$hook = add_menu_page(
			'User\'s Messages',
			'User\'s Messages',
			'manage_options',
			'wp_list_messages',
			[ $this, 'plugin_settings_page' ],
			'dashicons-format-chat'
		);

		add_action( "load-$hook", [ $this, 'screen_option' ] );

	}


	/**
	 * Plugin settings page
	 */
	public function plugin_settings_page() {
		?>
		<div class="wrap">
			<h2>User's Messages (Communication)</h2>

			<div id="poststuff">
				<div id="post-body" class="metabox-holder columns-2__">
					<div id="post-body-content">
						<div class="meta-box-sortables ui-sortable">
							<form method="post">
								<?php
								$this->messages_obj->prepare_items();
								$this->messages_obj->display(); ?>
							</form>
						</div>
					</div>
				</div>
				<br class="clear">
			</div>
		</div>
	<?php
	}

	/**
	 * Screen options
	 */
	public function screen_option() {

		$option = 'per_page';
		$args   = [
			'label'   => 'Messages',
			'default' => 50,
			'option'  => 'messages_per_page'
		];

		add_screen_option( $option, $args );

		$this->messages_obj = new Messages_List();
	}


	/** Singleton instance */
	public static function get_instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

}


add_action( 'plugins_loaded', function () {
	SP_Plugin::get_instance();
} );
