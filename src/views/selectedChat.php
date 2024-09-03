<div class="flex-2 flex rounded-xl w-full h-full ">
    <!--PROFILE_SECTION-->
    <div id="profile" class="flex flex-1 justify-center items-center">
        <div class="flex flex-col flex-1 h-full overflow-hidden overflow-y-auto items-center justify-center">
            <div class="w-60 h-60 right-img rounded-full overflow-hidden">
                <img class="h-auto w-full" src="<?=$profileData->profile_image;?>">
            </div>
            <div class="right-heading">
                <h2 class="text-center"><?=$profileData->name?></h2>
                <p>Do you want to make a Call?</p>
                <button type="button" id="callBtn" data-user="<?=$profileData->id?>" onclick="handleCallBtn()" class="active:-top-2 relative transition border border-gray-400 shadow-md my-4 bg-green-400 hover:bg-green-500 p-4 px-5 rounded-full text-white text-xl"><i class="fas fa-video"></i></button>
            </div>
        </div>
    </div>
    <!--PROFILE_SECTION_END--> 
    <?php
        include_once dirname(__DIR__) . "/views/videoSection.php";
    ?>
    <div id="chatSection" class="hidden w-full h-full">
        <?php
            include_once dirname(__DIR__) . "/views/chatSection.php";
        ?>
    </div>
</div>