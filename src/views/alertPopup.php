<div id="alertBox" class="hidden z-10 transition absolute w-full h-full flex items-center justify-center">
    <div class="pop-up flex justify-between w-96 bg-white rounded overflow-hidden">
        <div id="alertProfileBox" class="pl-6 border-green-600 px-2 py-2 flex items-center">
            <div class="w-16 h-16 mx-1 rounded-full border overflow-hidden">
                <img id="alertImage" class="w-full h-auto" src="">
            </div>
            <div class="flex flex-col">
                <div id="alertName" class="mx-2 font-500">
                </div>
                <div class="animate-pulse mx-2 text-xs font-200 relative flex">
                    <span id="alertMessage" class="flex"></span> 
                </div>
            </div>
        </div>
        <div id="alertMessageBox" class="hidden pl-6 border-green-600 px-2 py-2 flex items-center w-full">
            <div class="flex flex-col w-full">
                <div class="animate-pulse mx-2 text-xl font-200 relative flex">
                    <span id="alertMsg" class="flex"></span> 
                </div>
            </div>
        </div>
        <div id="closeAlert" class="right-3 top-3 relative">
            <button type="button" id="closeAlertBtn" onclick="handleCloseAlertBtn()" class="hover:text-red-700 transition text-red-600 px-4 py-1 text-xl ">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
</div>