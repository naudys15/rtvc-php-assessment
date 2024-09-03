<div class="w-2/5 border-r">
    <div class="h-full overflow-hidden">
        <div class="flex justify-between items-center border-b">
            <div class="mx-2 flex items-center justify-center">
                <div class="flex-shrink-0 mx-2 my-4 rounded-full overflow-hidden h-12 w-12  cursor-pointer">
                    <img  class="w-full h-auto rounded-full select-none" src="<?=$user->profile_image?>">
                </div>
                <div>
                    <span class="font-medium select-none"><?=$user->name?></span>
                </div>
            </div>
            <div class="flex items-center mx-4">
                <button type="button" id="videoOrChatBtn" onclick="handleVideoOrChatBtn()" class="transition hover:text-green-200 mx-3 text-green-500 cursor-pointer" alt="Video or chat?">
                    <i class="fas fa-comment-alt"></i>
                </button>
                <button type="button" onclick="submitLogout()" class="transition hover:text-red-200 mx-3 text-red-500 cursor-pointer" alt="Logout">
                    <i class="fas fa-sign-out-alt"></i>
                </button>
            </div>
        </div>
        <!--<div class="px-6 py-5 select-none">
            <input class="p-2 w-full rounded border" type="text" name="usersearch" placeholder="Search users">
        </div>-->
        <div class="select-none overflow-hidden overflow-y-auto h-full">
            <h2 class="font-bold text-lg my-4  px-6 select-none">Users</h2>
            <ul class="select-none" id="chatList">
                <?php
                    $users = $userObj->getUsers($token);
                    foreach ($users as $usr) {
                ?>
                    <li id="chat-<?=$usr->username?>" class="selectChatList select-none transition hover:bg-green-200 p-4 cursor-pointer select-none">
                        <a onclick="submitConnect('<?=$usr->username?>')">
                            <div class="user-box flex items-center flex-wrap">
                                <div class="flex-shrink-0 user-img w-14 h-14 rounded-full border overflow-hidden">
                                    <img class="w-full h-full" src="<?=$usr->profile_image?>">
                                </div>
                                <div class="user-name ml-2">
                                    <div><span class="flex font-medium"><?=$usr->name?></span></div>
                                </div>
                            </div>
                        </a>
                    </li>
                <?php
                    }
                ?>
            </ul>
        </div>
    </div>
</div>