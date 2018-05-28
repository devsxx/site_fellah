<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       comenscene.com
 * @since      1.0.0
 *
 * @package    Fellah_Data_Importer
 * @subpackage Fellah_Data_Importer/admin/partials
 */
?>
<?php 

// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    if (isset($_FILES['fileToUpload']) && ($_FILES['fileToUpload']['error'] == UPLOAD_ERR_OK)) {
        $xml = simplexml_load_file($_FILES['fileToUpload']['tmp_name']);     
        foreach ($xml->channel->item as $item) {
            $creator = $item->children('dc', TRUE);
            echo '<h2>' . $item->title . '</h2>';
            echo '<p>Created: ' . $item->pubDate . '</p>';
            echo '<p>Author: ' . $creator . '</p>';
            echo '<p>' . $item->description . '</p>';
            echo '<p><a href="' . $item->link . '">Read more: ' . $item->title . '</a></p>';
        }              
    }
}

?>
<h1>Importer les annonces</h1>
<form action="" method="post" enctype="multipart/form-data">
    Select image to upload:
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Importer" name="submit">
</form>