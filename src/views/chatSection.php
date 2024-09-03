<?php 
    include_once dirname(__DIR__) . "/init.php";

    include_once dirname(__DIR__) . "/views/checkToken.php";

    $user = $userObj->getUserBySession($token);
    $profileData = $userObj->getUserByUsername($_GET["username"] ?? '');
    $messages = $messageObj->getMessages($user->username, $_GET["username"] ?? '');
?>
<!--CHAT_SECTION-->
<div id="chat" class="overflow-hidden flex items-center w-full h-full"> 
    <div id="chatHeight" class="flex relative flex-col h-full w-full">
        <div id="chatContainer" class="py-3 px-3 h-4/5 justify-center overflow-auto">
            <?php
                foreach ($messages as $message) {
                    if ($message->sender == $user->username) {
            ?>
                        <div id="message-<?=$message->id?>" class="flex items-center justify-end">
                            <div class="border-gray-400 shadow-md mr-3 text-right">
                                <div class="text-lg" id="messageText-<?=$message->id?>"><?=$message->message?></div>
                                <span class="text-xs"><?=(new DateTime($message->created_at))->format("j/n/Y h:i:s A")?></span>
                                <a class="text-xs cursor-pointer" onclick="displayEditMessage('<?=$message->id?>')"><i class="fas fa-edit text-green-600 hover:text-green-700"></i> </a>
                                <a class="text-xs cursor-pointer" onclick="handleDeleteMessage('<?=$message->id?>')"><i class="fas fa-times text-red-600 hover:text-red-700"></i> </a>
                            </div>
                            </br></br>
                        </div>
            <?php
                    } else if ($message->receiver == $user->username) { 
            ?> 
                        <div id="message-<?=$message->id?>" class="flex items-center justify-start">
                            <div class="border-gray-400 shadow-md ml-3 text-left">
                                <div class="text-lg" id="messageText-<?=$message->id?>"><?=$message->message?></div>
                                <span class="text-xs"><?=(new DateTime($message->created_at))->format("j/n/Y h:i:s A")?></span>
                            </div>
                            </br></br>
                        </div>
            <?php
                    }
                }
            ?>
        </div>
        <div class="flex py-3 px-3 h-1/5 justify-center">
            <input class="flex w-4/5 border border-gray-400 shadow-md my-4 p-4 mr-4 px-5 rounded-md" type="text" name="chatText" id="chatText" placeholder="Type anything you want..." onkeypress="if (event.keyCode == 13) handleCreateMessage()">
            <button data-user="<?=$profileData->id?>" type="button" id="chatBtn" onclick="handleCreateMessage()" class="flex w-1/5 transition border border-gray-400 shadow-md my-4 bg-green-400 hover:bg-green-500 p-4 px-5 rounded-md text-white text-xl items-center justify-center" >
                <i class="fas fa-paper-plane"></i> 
            </button>
        </div>
    </div> 
</div>
<!--CHAT_SECTION_END-->