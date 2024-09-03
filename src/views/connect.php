<?php 
    include_once dirname(__DIR__) . "/init.php";

    include_once dirname(__DIR__) . "/views/checkToken.php";

    [
        'user' => $user,
        'profileData' => $profileData
    ] = $valObj->validateUsernameConnect($token, $_GET["username"] ?? '');
?>
<!-- AlertPopup -->
<?php
    include_once dirname(__DIR__) . "/views/alertPopup.php";
?>  
<!-- CallPopup -->
<?php
    include_once dirname(__DIR__) . "/views/callPopup.php";
?>
<!--EditMessagePopup-->
<?php
    include_once dirname(__DIR__) . "/views/editMessage.php";
?>

<!--WRAPPER-->
<div class="wrapper h-screen items-center justify-center flex">

    <div class="inner flex bg-white w-4/5 border" style="height:70%; margin-bottom:10%;">
        <!--LEFT_SIDE-->
        <?php
            include_once dirname(__DIR__) . "/views/chatList.php";
        ?>
        <!--LEFT_SIDE_END-->  
        <!--RIGHT_SIDE-->
        <?php
            include_once dirname(__DIR__) . "/views/selectedChat.php";
        ?>
        <!--RIGHT_SIDE_END-->
    </div><!--INNER_ENDS-->
</div><!--WRAPPER ENDS-->