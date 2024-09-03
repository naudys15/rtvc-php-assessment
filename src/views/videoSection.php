<!--VIDEO_CALL-->
<div id="video" class="hidden overflow-hidden flex items-center">
    <div class="flex relative flex-col h-full">
        <div class="order-2 h-full">
            <video id="remoteVideo" class="h-full object-cover" style="width:1280px;" autoplay playinline>
            </video>
            <video id="localVideo" class="vid-2 z-1 right-0 bottom-1 absolute" autoplay playinline>
            </video>
        </div>
        <div class="order-1 mt-4 absolute self-center">
            <div class="time rounded-xl text-white font-bold py-1 px-4"><span id="callTimer"></span></div>
        </div>
        <div class="order-3 shadow-md flex justify-center btn-call-end items-end w-full h-full absolute ">
            <button type="button" id="hangupBtn" onclick="handleHangupCallBtn()" class="relative -top-8 shadow-lg drop-shadow bg-red-600 rounded-full hover:bg-red-700 text-white text-2xl px-4 py-4 text-2xl mr-4">
                <i class="fas fa-phone"></i> 
            </button>
            <button type="button" id="microphoneBtn" onclick="handleMicrophoneBtn()" class="relative -top-8 shadow-lg drop-shadow bg-red-600 rounded-full hover:bg-red-700 text-white text-sm px-4 py-4 text-sm mr-4">
                <i class="fas fa-microphone-slash"></i> 
            </button>
            <button type="button" id="videoBtn" onclick="handleVideoBtn()" class="relative -top-8 shadow-lg drop-shadow bg-red-600 rounded-full hover:bg-red-700 text-white text-sm px-4 py-4 text-sm">
                <i class="fas fa-video-slash"></i> 
            </button>
        </div>
    </div> 
</div>
<!--VIDEO_CALL_END-->