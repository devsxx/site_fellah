
<div class="facebook_box">
      <div id="fb-root"></div>
      <script>(function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.src = 'https://connect.facebook.net/fr_FR/sdk.js#xfbml=1&version=v2.12&appId=1630338777079719&autoLogAppEvents=1';
      fjs.parentNode.insertBefore(js, fjs);
      }(document, 'script', 'facebook-jssdk'));</script>

      <div  class="fb-page" data-href="https://www.facebook.com/FellahAnnonces/" 
            data-width="350" data-height="190" data-small-header="true" 
            data-adapt-container-width="true" data-hide-cover="false"
            data-show-facepile="true">
            <blockquote cite="https://www.facebook.com/FellahAnnonces/" class="fb-xfbml-parse-ignore">
                  <a href="https://www.facebook.com/FellahAnnonces/">Fellah.ma</a>
            </blockquote>
      </div>
      <br>
</div>

<div class="categoris">
      <div class="sidebare_titre">
            <i class="far fa-folder"></i>
            <?php _e('Categories','fellah'); ?>
      </div>
      <div class="categoris_container">
            <ul>
            <?php
            wp_list_categories(
                  array( 
                        'title_li' => '',
                        'hide_empty' => 1,
                        'depth' => 2,
                        'exclude' => 1
                  )
            ); ?>
            </ul>
      </div>
 
      <div class="search_container"> 
            <div class="sidebare_titre">
                  <i class="fas fa-search"></i>
                  <?php _e('Search an article','fellah'); ?>
            </div>
            <?php  get_search_form( true ) ?>
      </div>
</div>