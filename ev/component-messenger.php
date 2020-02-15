<?php
include_once('config/database.php');

function fb_facebook_messenger() {
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

    $primary_color = '#42c37a';

    $facebook_page = $connection ? $connection['facebook_page'] : '';

    $messenger_language 	= $settings ? $settings['messenger_language'] : 'en_US';
    $messenger_mobile 		= $settings ? $settings['messenger_mobile'] : 0;
    $messenger_position 	= $settings ? $settings['messenger_position'] : 'right';
    $messenger_hello 		= $settings ? $settings['messenger_hello'] : '';

    // ======== CSS ========
    // Position
    $css = NULL;
    switch ($messenger_position) {
        case 'left':
            $css .= '.fb_dialog, .fb-customerchat * > iframe { left:18pt !important;right: auto; }';
            break;
        case 'center':
            $css .= '.fb_dialog, .fb-customerchat * > iframe { margin: auto;left: 0;right: 0; }';
            break;
    }

    // Hide on mobile
    if ($messenger_mobile) {
        $css .= '@media(max-width:576px) { .fb_dialog { display: none !important; } }';
    }

    if ($css != NULL) {
        echo '<style>' . $css . '</style>';
    }
    // =====================
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
            js.src = "https://connect.facebook.net/<?php echo htmlspecialchars($messenger_language); ?>/sdk/xfbml.customerchat.js";
            fjs.parentNode.insertBefore(js, fjs);}(document, "script", "facebook-jssdk"));
    </script>
    <div class="fb-customerchat" logged_in_greeting="<?php echo htmlspecialchars($messenger_hello); ?>" logged_out_greeting="<?php echo htmlspecialchars($messenger_hello); ?>" attribution=setup_tool page_id="<?php echo htmlspecialchars($facebook_page); ?>" theme_color="<?php echo htmlspecialchars($primary_color); ?>"></div>
<?php
}
