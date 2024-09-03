"use strict";

let sendTo;

function getSendTo() {
    return $("#callBtn").data("user");
}

function handleCallBtn() {
    setTimeout(function () {
        getCam();
        webSocketSend("rtvc-is-client-ready", null, getSendTo());
    }, 50);
}

function handleHangupCallBtn() {
    setTimeout(function () {
        hangup(true);
    }, 50);
}

function handleCloseAlertBtn() {
    setTimeout(function () {
        $("#alertBox").addClass("hidden");
        $("#alertMessageBox").addClass("hidden");
        $("#alertProfileBox").removeClass("hidden");
        $(".wrapper").removeClass("glass");
    }, 50);

    let callback = localStorage.getItem('closeAlertCallback') || '';
    if (callback) {
        localStorage.removeItem('closeAlertCallback');
        window[callback]();
    }
}

function handleDeclineBtn() {
    setTimeout(function () {
        $("#callBox").addClass("hidden");
        $(".wrapper").removeClass("glass");
        webSocketSend("rtvc-client-rejected", null, getSendTo());
    }, 50);
}

function handleAnswerBtn() {
    setTimeout(function () {
        $("#callBox").addClass("hidden");
        $(".wrapper").removeClass("glass");
        webSocketSend("rtvc-client-is-ready", null, getSendTo());
    }, 50);
}

function handleVideoOrChatBtn() {
    let display = localStorage.getItem('displayVideoSection') || 0;
    if (display == 0) {
        setTimeout(function () {
            $('#videoOrChatBtn').html("<i class='fas fa-comment-alt'></i>");
            localStorage.setItem('displayVideoSection', 1);
            $("#profile").removeClass("hidden");
            $("#video").addClass("hidden");
            $("#chatSection").addClass("hidden");
        }, 50);
    } else {
        setTimeout(function () {
            $('#videoOrChatBtn').html("<i class='fas fa-video'></i> ");
            localStorage.setItem('displayVideoSection', 0);
            $("#profile").addClass("hidden");
            $("#video").addClass("hidden");
            $("#chatSection").removeClass("hidden");
            $('#chatContainer').scrollTop($("#chatContainer")[0].scrollHeight);
        }, 50);
    }
}

async function displayCall(username = "", profileImage = "") {
    if (!localStorage.getItem("connectUsername") || (localStorage.getItem("connectUsername") != username)) {
        await submitConnect(username, profileImage, true);
    } else {
        setTimeout(function () {
            cleanupPopupsBeforeCall();
            $("#callBox").removeClass("hidden");
            $(".wrapper").addClass("glass");
        }, 50);
    }
}

function displayAlert(username, profileImage, message, type, callback) {
    setTimeout(function () {
        if (type == "profile") {
            $("#alertBox").find("#alertName").text(username);
            $("#alertBox").find("#alertImage").attr("src", profileImage);
            $("#alertBox").find("#alertMessage").text(message);
        
            $("#alertBox").removeClass("hidden");
            $(".wrapper").addClass("glass");
            $("#video").addClass("hidden");
            $("#profile").removeClass("hidden");
        } else if (type == "message") {
            $("#alertBox").find("#alertMsg").text(message);

            $(".wrapper").addClass("glass");
            $("#alertBox").removeClass("hidden");
            $("#alertMessageBox").removeClass("hidden");
            $("#alertProfileBox").addClass("hidden");
        }
        if (callback) {
            localStorage.setItem('closeAlertCallback', callback);
        }
    }, 50);
}

function displayEditMessage(id) {
    localStorage.setItem('editMessageId', id);
    $('#editChatText').val($('#messageText-' + (id)).html());
    $('#editMessageBox').removeClass('hidden');
    $('.wrapper').addClass('glass');
}

function displayRegister() {
    $('#registerBox').removeClass('hidden');
    $('.wrapper').addClass('glass');
}

function cleanupPopupsBeforeCall() {
    $("#chatSection").addClass("hidden");
    $('#profile').removeClass("hidden");
}

function getToken() {
    return localStorage.getItem("token") || ''; 
}

async function handleCreateMessage() {
    await submitCreateMessage();
}

function handleEditMessage() {
    let token = getToken();
    let id = localStorage.getItem('editMessageId');
    let message = $('#editChatText').val();
    let data = {
        'token': token,
        'id': id,
        'message': message
    };
    submitEditMessage(id);
    webSocketSend("chat-message-edited", data, $("#chatBtn").data("user"));
    localStorage.removeItem('editMessageId');
}

function handleDeleteMessage(id) {
    let token = getToken();
    let data = {
        'token': token,
        'id': id
    };
    submitDeleteMessage(id);
    webSocketSend("chat-message-deleted", data, $("#chatBtn").data("user"));
}

function handleCancelEditMessage() {
    $('.wrapper').removeClass('glass');
    $('#editMessageBox').addClass('hidden');
}

function handleCancelRegister() {
    $('.wrapper').removeClass('glass');
    $('#registerBox').addClass('hidden');
}

function handleRegister() {
    let name = $('#nameRegister').val();
    let username = $('#usernameRegister').val();
    let email = $('#emailRegister').val();
    let password = $('#passwordRegister').val();

    if (!name || !username || !email || !password) {
        return;
    }

    $.ajax({
        data:  {
            'name': name,
            'username': username,
            'email': email,
            'password': password
        },
        url:   'src/actions/validateRegister.php',
        type:  'post',
        success:  function (response) {
            $('.inputRegisterError').html('');
            if (response.error_count > 0) {
                for (let key in response.error_details) {
                    $('#' + key + 'RegisterError').html(response.error_details[key]);
                }
            } else {
                submitRegister();
            }
        }
    });
}

function addNewMessageToList(data, type) {
    let messagesList = $('#chatContainer');
    let newMessage = '';
    if (type === 'sender') {
        newMessage = `
            <div id="message-${data.id}" class="flex items-center justify-end">
                <div class="border-gray-400 shadow-md mr-3 text-right">
                    <div class="text-lg" id="messageText-${data.id}">${data.message}</div>
                    <span class="text-xs">${(new Date(data.created_at)).toLocaleString()}</span>
                    <a class="text-xs cursor-pointer" onclick="displayEditMessage('${data.id}')"><i class="fas fa-edit text-green-600 hover:text-green-700"></i> </a>
                    <a class="text-xs cursor-pointer" onclick="handleDeleteMessage('${data.id}')"><i class="fas fa-times text-red-600 hover:text-red-700"></i> </a>
                </div>
                </br></br>
            </div>
        `;
    } else if (type === 'receiver') {
        newMessage = `
            <div id="message-${data.id}" class="flex items-center justify-start">
                <div class="border-gray-400 shadow-md ml-3 text-left">
                    <div class="text-lg" id="messageText-${data.id}">${data.message}</div>
                    <span class="text-xs">${(new Date(data.created_at)).toLocaleString()}</span>
                </div>
                </br></br>
            </div>
        `;
    }
    $('#chatText').val("");
    messagesList.append(newMessage);
    messagesList.scrollTop(messagesList[0].scrollHeight);
    return;
}

function submitRegister() {
    let name = $('#nameRegister').val();
    let username = $('#usernameRegister').val();
    let email = $('#emailRegister').val();
    let password = $('#passwordRegister').val();

    if (!name || !username || !email || !password) {
        return;
    }

    $.ajax({
        data:  {
            'name': name,
            'username': username,
            'email': email,
            'password': password
        },
        url:   'src/actions/handleRegister.php',
        type:  'post',
        success:  function (response) {
            displayAlert(null, null, "User registered successfully", "message", null);
            $('#registerBox').addClass('hidden');
        }
    });
}

function submitHome() {
    let url = "src/views/index.php";
    if (getToken()) {
        url = url + '?token=' + getToken();
    }
    $.ajax({
        url:   'src/views/index.php?token=' + getToken(),
        type:  'get',
        success:  function (response) {
            setWebsocketConn();
            localStorage.removeItem('connectUsername');
            $('#bodyApp').html(response);
        }
    });
}

function submitLogin() {
    let email = $('input[name=email]').val() || '';
    let password = $('input[name=password]').val() || '';

    if (!email || !password) {
        return;
    }

    $.ajax({
        data:  {
            'email': email,
            'password': password
        },
        url:   'src/actions/handleLogin.php',
        type:  'post',
        success:  function (response) {
            if (response.token) {
                localStorage.setItem('token', response.token);
                submitHome();
            } else {
                $("#loginError").html(response.error);
            }
        }
    });
}

function submitLogout() {
    $.ajax({
        url:   'src/actions/handleLogout.php',
        type:  'get',
        success:  function (response) {
            localStorage.removeItem('token');
            webSocketClose();
            submitHome();
        }
    });
}

function submitConnect(username, profileImage, beforeCallPopup = false) {
    if (!username) {
        return;
    }

    $.ajax({
        data:  {
            'username': username
        },
        url:   'src/views/connect.php?token=' + getToken(),
        type:  'get',
        success:  function (response) {
            localStorage.setItem("connectUsername", username);
            $('#bodyApp').html(response);
            localStorage.setItem('displayVideoSection', 1);
            $('.selectChatList').removeClass("bg-green-100");
            $('#chat-' + username).addClass("bg-green-100");  
            if (beforeCallPopup) {
                setTimeout(function () {
                    $("#callBox").removeClass("hidden");
                    $(".wrapper").addClass("glass");
                    if (username) {
                        $("#username").text(username);
                    }
                    if (profileImage) {
                        $("#profileImage").attr("src", profileImage);
                    }
                }, 50);
            }
        }
    });
}

function submitCreateMessage() {
    let username = localStorage.getItem('connectUsername') || '';
    let token = getToken();
    let message = $('#chatText').val();

    if (!username || !token || !message) {
        return;
    }

    $.ajax({
        data:  {
            'token': token,
            'username': username,
            'message': message
        },
        url:   'src/actions/createMessage.php',
        type:  'post',
        success:  async function (response) {
            webSocketSend("chat-message-created", response.message, $("#chatBtn").data("user"));
            await addNewMessageToList(response.message, 'sender');
        }
    });
}

function submitEditMessage(id) {
    let token = getToken();
    let message = $('#editChatText').val();

    if (!id || !token || !message) {
        return;
    }

    $.ajax({
        data:  {
            'token': token,
            'id': id,
            'message': message
        },
        url:   'src/actions/editMessage.php',
        type:  'put',
        success:  function (response) {
            $('#messageText-' + (id)).html(message);
            $('.wrapper').removeClass('glass');
            $('#editMessageBox').addClass('hidden');
        }
    });
}

function submitDeleteMessage(id) {
    let token = getToken();

    if (!token || !id) {
        return;
    }

    $.ajax({
        data:  {},
        url:   'src/actions/deleteMessage.php?token=' + token + '&id=' + id,
        type:  'delete',
        success:  function (response) {
        }
    });
    $('#message-' + (id)).remove();
}

async function getMessages() {
    let username = localStorage.getItem('connectUsername') || '';
    let token = getToken();

    if (!username || !token) {
        return;
    }

    $.ajax({
        data:  {
            'token': token,
            'username': username
        },
        url:   'src/views/chatSection.php',
        type:  'get',
        success:  function (response) {
            $("#chatSection").html(response);
            $('#chatContainer').scrollTop($("#chatContainer")[0].scrollHeight);
        }
    });
}

$(document).ready(async function() {
    if (getToken()) {
        submitHome();
    }
});