<?php
    include_once dirname(__DIR__) . "/init.php";
?>

<!-- AlertPopup -->
<?php
    include_once dirname(__DIR__) . "/views/alertPopup.php";
?> 
<!--RegisterPopup-->
<?php
    include_once dirname(__DIR__) . "/views/register.php";
?>

<!--WRAPPER-->
<div class=" wrapper h-screen items-center justify-center flex">
    <div class="inner rounded flex bg-white w-4/5 border" style="height:70%; margin-bottom:10%;">
        <!--LEFT_SIDE-->
        <div class="w-2/5 border-r">
            <div class="select-none flex h-full items-center justify-center">
                <img class="select-none w-4/5" src="assets/images/login-left-bg.png">
            </div>
        </div>
        <!--LEFT_SIDE_END-->  

        <!--RIGHT_SIDE-->
        <div class="flex-2 flex rounded-xl w-full h-full">
            <!--PROFILE_SECTION-->
            <div class=" flex flex-1 justify-center items-center">
                <div class="flex flex-col flex-1 h-full overflow-hidden overflow-y-auto items-center justify-start">
                
                    <div class="mt-10 w-60 h-60 right-img rounded-full overflow-hidden">
                        <img class="h-auto w-full" src="assets/images/user.png">
                    </div>
                
                    <div class="right-heading w-full flex flex-col items-center">
                        <div>
                            <h2 class="text-center" style="padding-top:0px;">Welcome!</h2>
                            <p>Sign-in into your account.</p>
                        </div>
                        <form method="post" class="w-full">
                            <div class="w-full flex flex-col items-center">
                                <div class="flex w-2/4 flex-col my-2 items-center">
                                    <input class="w-4/5 my-2 border border-gray-200 rounded px-4 py-2" type="email" name="email" placeholder="Email">

                                    <input class="w-4/5 my-2 border border-gray-200 rounded px-4 py-2" type="password" name="password" placeholder="Password">
                                    <div id="loginError" class="select-none error text-red-500 text-xs p-2 px-2 w-auto self-start ml-20"></div>
                                </div>
                                <div>
                                    <button type="button" class="active:-top-2 relative transition border border-gray-400 shadow-md my-4 bg-green-400 hover:bg-green-500 p-2 px-20 rounded-full text-white text-xl" onclick="submitLogin()">Login</button>
                                </div>
                                <div>
                                    <a class="text-xs cursor-pointer hover:text-green-700" onclick="displayRegister()">Don't have an account? Register</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!--PROFILE_SECTION_END-->
        </div>
        <!--RIGHT_SIDE_END-->
    </div>
    <!--INNER_ENDS-->
</div>
<!--WRAPPER ENDS-->