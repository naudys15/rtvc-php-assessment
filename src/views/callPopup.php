<div id="callBox" class="hidden z-10 transition absolute w-full h-full flex items-center justify-center">
    <div class="pop-up flex justify-between w-96 bg-white rounded overflow-hidden">
        <div class="pl-6 border-green-600 px-2 py-2 flex items-center">
            <div class="w-16 h-16 mx-1 rounded-full border overflow-hidden">
                <img id="profileImage" class="w-full h-auto" src="">
            </div>
            <div class="flex flex-col">

                <div id="username" class="mx-2 font-500">
                username
                </div>
                <div class="animate-pulse mx-2 text-xs font-200 relative flex">
                    <span class="flex">Video calling</span> 
                    <span class="ml-2 text-lg text-green-600 top-0 flex">
                        <i class=" fas fa-video"></i>
                    </span>
                </div>
            </div>
        </div>
        <div class="flex items-center justify-center mx-4">
            <ul class="flex pr-2">
                <li>
                    <button type="button" id="declineBtn" onclick="handleDeclineBtn()" class="hover:text-red-700 transition text-red-600 px-4 py-1 text-xl "><i class="fas fa-times"></i></button>
                </li>
                <li>
                    <button type="button" id="answerBtn" onclick="handleAnswerBtn()" class="hover:text-green-700 transition text-green-600 px-4 py-1 text-xl "><i class="fas fa-phone"></i></button>
                </li>
            </ul>
        </div>
    </div>
</div>