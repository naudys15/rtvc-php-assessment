let pc;
let localStream;

function getConn() {
    if (!pc) {
        pc = new RTCPeerConnection(config);
    }
}

const browserSupportsMedia = () => {
    return navigator.mediaDevices.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia || navigator.mzGetUserMedia
}

// Ask for media input
async function getCam() {
    let mediaStream;
    try {
        if (!pc) {
           await getConn();
        }
		if (navigator.mediaDevices) {
			mediaStream = await navigator.mediaDevices.getUserMedia(mediaConst);
			(document.querySelector("#localVideo")).srcObject = mediaStream;
			localStream = mediaStream;
			localStream.getTracks().forEach((track) => pc.addTrack(track, localStream));
		}
    } catch (error) {
        console.log("Error: ", error);
    }
}

async function createOffer(sendTo) {
	await sendIceCandidate(sendTo);
	await pc.createOffer(options);
	await pc.setLocalDescription(pc.localDescription);
	webSocketSend("rtvc-client-offer", pc.localDescription, sendTo);
}

async function createAnswer(sendTo, data, additionalData = {}) {
	if (!pc) {
		await getConn();
	}

	if (!localStream) {
		await getCam();
	}

	await sendIceCandidate(sendTo);
	await pc.setRemoteDescription(data);
	await pc.createAnswer();
	await pc.setLocalDescription(pc.localDescription);
	await verifyRtcConnection(additionalData?.username, additionalData?.profileImage);
	webSocketSend("rtvc-client-answer", pc.localDescription, sendTo);
}

function sendIceCandidate(sendTo) {
	pc.onicecandidate = e =>{
		if (e.candidate !== null) {
			webSocketSend("rtvc-client-candidate", e.candidate, sendTo);
		}
	}

    pc.ontrack = e =>{
		if (e.candidate !== null) {
            $("#video").removeClass("hidden");
            $("#profile").addClass("hidden");
            (document.querySelector("#remoteVideo")).srcObject = e.streams[0];
		}
	}
}

function hangup(notify = false) {
	if (notify) {
		webSocketSend("rtvc-client-hangup", null, getSendTo());
	}
	if (pc) {
		pc.close();
	}
	pc = null;

	if (localStream) {
		stopBothVideoAndAudio(localStream);
	}
	localStream = null;
	submitHome();
}

function stopBothVideoAndAudio(stream) {
    stream.getTracks().forEach((track) => {
        if (track.readyState == 'live') {
            track.stop();
        }
    });
}

function handleMicrophoneBtn() {
	localStream.getTracks().forEach((track) => {
		if (track.kind === "audio") {
			if (track.enabled) {
				$("#microphoneBtn").html('<i class="fas fa-microphone fa-lg"></i>');
				$("#microphoneBtn").removeClass("text-sm");
				$("#microphoneBtn").removeClass("bg-red-600");
				$("#microphoneBtn").removeClass("hover:bg-red-700");
				$("#microphoneBtn").addClass("text-md");
				$("#microphoneBtn").addClass("bg-green-600");
				$("#microphoneBtn").addClass("hover:bg-green-700");
			} else {
				$("#microphoneBtn").html('<i class="fas fa-microphone-slash"></i>');
				$("#microphoneBtn").removeClass("text-md");
				$("#microphoneBtn").removeClass("bg-green-600");
				$("#microphoneBtn").removeClass("hover:bg-green-700");
				$("#microphoneBtn").addClass("text-sm");
				$("#microphoneBtn").addClass("bg-red-600");
				$("#microphoneBtn").addClass("hover:bg-red-700");
			}
			track.enabled = !track.enabled;
		}
    });
}

function handleVideoBtn() {
	localStream.getTracks().forEach((track) => {
		if (track.kind === "video") {
			if (track.enabled) {
				$("#videoBtn").html('<i class="fas fa-video"></i>');
				$("#videoBtn").removeClass("bg-red-600");
				$("#videoBtn").removeClass("hover:bg-red-700");
				$("#videoBtn").addClass("bg-green-600");
				$("#videoBtn").addClass("hover:bg-green-700");
			} else {
				$("#videoBtn").html('<i class="fas fa-video-slash"></i>');
				$("#videoBtn").removeClass("bg-green-600");
				$("#videoBtn").removeClass("hover:bg-green-700");
				$("#videoBtn").addClass("bg-red-600");
				$("#videoBtn").addClass("hover:bg-red-700");
			}
			track.enabled = !track.enabled;
		}
    });
}

async function verifyRtcConnection(username = "", profileImage = "") {
	try {
		if (!pc) {
			await getConn();
		}
	
		let findStat = (m, type) => [...m.values()].find(s => s.type == type && !s.isRemote);
		
		let hasConnected = new Promise(resolve => pc.oniceconnectionstatechange =
		  e => pc.iceConnectionState == "connected" && resolve()
		);
		
		let hasDropped = hasConnected.then(() => new Promise(resolve => {
			try {
				let lastPackets = 0;
				let countdown = 0;
				let timeout = 10;
				let iv = setInterval(() => {
					if (pc) {
						pc.getStats().then(stats => {
							let findStats = findStat(stats, "inbound-rtp");
							if (findStats) {
								let packets = findStats.packetsReceived;
								countdown = (packets - lastPackets) ? timeout : countdown - 1;
								if (!countdown) resolve(clearInterval(iv)); 
								lastPackets = packets;
							}
						})
					}
				}, 1000);
			} catch (e) {
				clearInterval(iv);
			}
		}));
		
		hasDropped.then(() => {
			$("#video").srcObject = null;
			displayAlert(username, profileImage, "Connection lost with the client", 'profile', 'hangup');
		}).catch();
	} catch (e) {

	}
}
