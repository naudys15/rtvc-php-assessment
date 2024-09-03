<?php
    include_once __DIR__ . "/src/init.php";
?>
<html>
    <head>
        <title>Live Video Chat Using PHP</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <!-- Tailwind -->
        <link rel="stylesheet" type="text/css" href="assets/css/tailwind.min.css">
        <!-- Font-awesome -->
        <link rel="stylesheet" type="text/css" href="assets/css/font-awesome.min.css"/>
        <!-- CSS -->
        <link rel="stylesheet" type="text/css" href="assets/css/style.css">
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link type="text/css" href="assets/css/roboto.css">
        <!-- Jquery -->
        <script type="text/javascript" src="assets/js/jquery-3.6.0.min.js"></script>
        <!-- Jquery timer -->
        <script type="text/javascript" src="assets/js/timer.jquery.js"></script>
    </head>
    <body>
        <!-- JavaScript Files -->
        <script type="text/javascript" src="assets/js/main.js"></script>
        <script type="text/javascript" src="assets/js/webrtc-config.js" stun="<?=$_ENV['STUN_SERVER']?>" turn='<?=$_ENV['TURN_SERVERS']?>'></script>
        <script type="text/javascript" src="assets/js/webrtc.js"></script>
        <script type="text/javascript" src="assets/js/websocket.js"></script>
        <script src="assets/js/adapter-latest.js"></script>
        <!-- Body app -->
        <div id="bodyApp">
            <?php
                include __DIR__ . "/src/views/index.php";
            ?>
        </div>
    </body>
</html>