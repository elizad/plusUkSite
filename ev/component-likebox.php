<?php
include_once('config/database.php');

function fb_facebook_likebox() {
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Facebook connection
    $sql = 'SELECT * FROM connection where id = 1';
    $q = $pdo->prepare($sql);
    $q->execute();
    $connection = $q->fetch(PDO::FETCH_ASSOC);

    // Settings
    $sql = 'SELECT * FROM settings where id = 1';
    $q = $pdo->prepare($sql);
    $q->execute();
    $settings = $q->fetch(PDO::FETCH_ASSOC);

    Database::disconnect();

    $primary_color = '#ff5000';

    $app_id         = $connection ? $connection['app_id'] : '';
    $facebook_page  = $connection ? $connection['facebook_page'] : '';

    $likebox_language       = $settings ? $settings['likebox_language'] : 'en_US';
    $likebox_mobile 		= $settings ? $settings['likebox_mobile'] : 0;
    $likebox_width 	        = $settings ? $settings['likebox_width'] : 300;
    $likebox_height         = $settings ? $settings['likebox_height'] : 400;
    $likebox_tab_timeline 	= $settings ? $settings['likebox_tab_timeline'] : 0;
    $likebox_tab_events 	= $settings ? $settings['likebox_tab_events'] : 0;
    $likebox_tab_messages 	= $settings ? $settings['likebox_tab_messages'] : 0;
    $likebox_position 		= $settings ? $settings['likebox_position'] : 'right';

    // ====== CSS ======
    // Position
    $css = NULL;

    $css .= '.fb-facebook-likebox .likebox-content { width: ' . $likebox_width . 'px; height: ' . $likebox_height . 'px; }';
    $css .= '.fb-facebook-likebox .likebox-content .loading { padding-top: ' . (($likebox_height - 100)/2) . 'px; }';

    switch ($likebox_position) {
        case 'right':
            $css .= '.fb-facebook-likebox { right: -' . $likebox_width . 'px; padding-left: 48px; }';
            $css .= '.fb-facebook-likebox .likebox-button { left: 0; }';
            break;
        case 'left':
            $css .= '.fb-facebook-likebox { left: -' . $likebox_width . 'px; padding-right: 48px; }';
            $css .= '.fb-facebook-likebox .likebox-button { right: 0; }';
            break;
        case 'popup':
            $css .= '.fb-facebook-popup .popup-wrap .likebox-content { width: ' . ($likebox_width + 20) . 'px; height: ' . ($likebox_height + 20) . 'px; }';
            $css .= '.likebox-content .loading { padding-top: ' . (($likebox_height - 100)/2) . 'px; }';
            break;
    }

    // Hide on mobile
    if ($likebox_mobile) {
        $css .= '@media(max-width:576px) { .fb-facebook-likebox { display: none !important; } }';
    }

    if ($css != NULL) {
        echo '<style>' . $css . '</style>';
    }
    // ==================

    // Data tab
    $data_tabs = '';
    $tabs = array();
    if ($likebox_tab_timeline) { $tabs[] = 'timeline'; }
    if ($likebox_tab_events) { $tabs[] = 'events'; }
    if ($likebox_tab_messages) { $tabs[] = 'messages'; }
    if (count($tabs) > 0) {
        $data_tabs = 'data-tabs="' . implode(',', $tabs) . '"';
    }
    ?>

    <div id="fb-root"></div>
    <script>
        window.fbAsyncInit = function(){
            FB.init({xfbml:true,version:"v3.2"});
        };
        (function(d,s,id) {
            var js,fjs = d.getElementsByTagName(s)[0];
            if(d.getElementById(id)) return;
            js = d.createElement(s);
            js.id = id;
            js.src = "https://connect.facebook.net/<?php echo htmlspecialchars($likebox_language); ?>/all.js#xfbml=1&appId=<?php echo htmlspecialchars($app_id); ?>";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, "script", "facebook-jssdk"));
    </script>

    <?php if ($likebox_position == 'popup') { ?>
        <div class="fb-facebook-popup">
            <div class="popup-wrap" id="fb-facebook-popup">
                <div class="likebox-content">
                    <a class="close" href="#">×</a>
                    <div class="loading"><img src="assets/images/loading.gif"></div>
                    <div class="fb-page" data-href="https://www.facebook.com/<?php echo htmlspecialchars($facebook_page); ?>" data-width="<?php echo htmlspecialchars($likebox_width); ?>" data-height="<?php echo htmlspecialchars($likebox_height); ?>" <?php echo ($data_tabs) ? $data_tabs : ''; ?> ></div>
                </div>
            </div>
        </div>
    <?php } else { ?>
        <div class="fb-facebook-likebox">
            <?php echo ($likebox_position == 'right') ? '<div class="likebox-button right"></div>' : ''; ?>
            <div class="likebox-content">
                <div class="loading"><img src="assets/images/loading.gif"></div>
                <div class="fb-page" data-href="https://www.facebook.com/<?php echo htmlspecialchars($facebook_page); ?>" data-width="<?php echo htmlspecialchars($likebox_width); ?>" data-height="<?php echo htmlspecialchars($likebox_height); ?>" <?php echo ($data_tabs) ? $data_tabs : ''; ?> ></div>
                <input type="hidden" class="fb-facebook-param-likebox-width" name="likebox_width" value="<?php echo htmlspecialchars($likebox_width); ?>">
            </div>
            <?php echo ($likebox_position == 'left') ? '<div class="likebox-button left"></div>' : ''; ?>
        </div>
    <?php } ?>
<?php
}
