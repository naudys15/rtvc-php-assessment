<div id="editMessageBox" class="hidden z-10 transition absolute w-full h-full flex items-center justify-center">
    <div class="pop-up flex justify-between w-96 bg-white rounded overflow-hidden">
        <div class="pl-6 border-green-600 px-2 py-2 flex items-center w-full">
            <input class="flex border border-gray-400 shadow-md my-4 p-4 mr-4 px-5 rounded-md w-full" type="text" name="editChatText" id="editChatText" placeholder="Type anything you want...">
        </div>
        <div class="flex items-center justify-center mx-4">
            <ul class="flex pr-2">
                <li>
                    <button type="button" id="cancelEditMessageBtn" onclick="handleCancelEditMessage()" class="hover:text-red-700 transition text-red-600 px-4 py-1 text-xl "><i class="fas fa-times"></i></button>
                </li>
                <li>
                    <button type="button" id="submitEditMessageBtn" onclick="handleEditMessage()" class="hover:text-green-700 transition text-green-600 px-4 py-1 text-xl "><i class="fas fa-edit"></i></button>
                </li>
            </ul>
        </div>
    </div>
</div>