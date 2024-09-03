// Media info
const mediaConst = {
    video: true,
    audio: true,
}

// Info about stun and turn servers
let stunServer = document.currentScript.getAttribute('stun');
let turnServers = document.currentScript.getAttribute('turn');
if (turnServers) {
    turnServers = JSON.parse(turnServers);
}
const config = {
    iceServers: [
        {
            urls: stunServer
        },
        ...turnServers
    ]
}

// What to receive from other client
const options = {
    offerToReceiveVideo: 1,
    offerToReceiveAudio: 1
}