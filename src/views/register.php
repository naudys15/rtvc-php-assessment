<div id="registerBox" class="hidden z-10 transition absolute w-full h-full flex items-center justify-center">
    <div class="pop-up table justify-between w-96 bg-white rounded overflow-hidden">
        <div class="pl-6 border-green-600 px-2 py-2 flex items-center w-full text-lg justify-center text-black-500">
            Register for free
        </div>
        <div class="pl-6 border-green-600 px-2 py-2 flex items-center w-full">
            <div class="w-40">
                <label for="nameRegister" class="text-md"> Name: </label>
            </div>
            <div class="w-full mr-2">
                <input class="flex border border-gray-400 shadow-md my-4 p-4 mr-4 px-5 rounded-md w-full" type="text" name="nameRegister" id="nameRegister" placeholder="Name">
            </div>
        </div>
        <div class="pl-6 border-green-600 px-2 py-1 flex items-center w-full">
            <div class="w-40">
            </div>
            <div class="w-full mr-2">
                <div id="nameRegisterError" class="text-sm inputRegisterError pl-6 border-green-600 px-2 py-2 flex items-center w-full text-red-400"></div>
            </div>
        </div>

        <div class="pl-6 border-green-600 px-2 py-2 flex items-center w-full">
            <div class="w-40">
                <label for="usernameRegister" class="text-md"> Username: </label>
            </div>
            <div class="w-full mr-2">
                <input class="flex border border-gray-400 shadow-md my-4 p-4 mr-4 px-5 rounded-md w-full" type="text" name="usernameRegister" id="usernameRegister" placeholder="Username">
            </div>
        </div>
        <div class="pl-6 border-green-600 px-2 py-1 flex items-center w-full">
            <div class="w-40">
            </div>
            <div class="w-full mr-2">
                <div id="usernameRegisterError" class="text-sm inputRegisterError pl-6 border-green-600 px-2 py-2 flex items-center w-full text-red-400"></div>
            </div>
        </div>

        <div class="pl-6 border-green-600 px-2 py-2 flex items-center w-full">
            <div class="w-40">
                <label for="emailRegister" class="text-md"> Email: </label>
            </div>
            <div class="w-full mr-2">
                <input class="flex border border-gray-400 shadow-md my-4 p-4 mr-4 px-5 rounded-md w-full" type="text" name="emailRegister" id="emailRegister" placeholder="Email">
            </div>
        </div>
        <div class="pl-6 border-green-600 px-2 py-1 flex items-center w-full">
            <div class="w-40">
            </div>
            <div class="w-full mr-2">
                <div id="emailRegisterError" class="text-sm inputRegisterError pl-6 border-green-600 px-2 py-2 flex items-center w-full text-red-400"></div>
            </div>
        </div>

        <div class="pl-6 border-green-600 px-2 py-2 flex items-center w-full">
            <div class="w-40">
                <label for="passwordRegister" class="text-md"> Password: </label>
            </div>
            <div class="w-full mr-2">
                <input class="flex border border-gray-400 shadow-md my-4 p-4 mr-4 px-5 rounded-md w-full" type="password" name="passwordRegister" id="passwordRegister" placeholder="Password">
            </div>
        </div>
        <div class="pl-6 border-green-600 px-2 py-1 flex items-center w-full">
            <div class="w-40">
            </div>
            <div class="w-full mr-2">
                <div id="passwordRegisterError" class="text-sm inputRegisterError pl-6 border-green-600 px-2 py-2 flex items-center w-full text-red-400"></div>
            </div>
        </div>

        <div class="flex items-center justify-center mx-4 pb-4">
            <ul class="flex pr-2">
                <li>
                    <button type="button" id="cancelRegisterBtn" onclick="handleCancelRegister()" class="hover:text-red-700 transition text-red-600 px-4 py-1 text-xl "><i class="fas fa-times"></i></button>
                </li>
                <li>
                    <button type="button" id="submitRegisterBtn" onclick="handleRegister()" class="hover:text-green-700 transition text-green-600 px-4 py-1 text-xl "><i class="fas fa-check"></i></button>
                </li>
            </ul>
        </div>
    </div>
</div>