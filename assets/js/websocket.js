let conn;
function setWebsocketConn() {
	let tokenWs = getToken();
	if (!conn && tokenWs) {
		conn = new WebSocket("ws://" + window.location.hostname + ":8085/?token=" + tokenWs);
	}

	if (conn) {
		conn.onopen = e => {
			console.log("Connected to websocket with id " + tokenWs);
		}
		
		conn.onmessage = async e =>{
			let message      = JSON.parse(e.data);
			let by           = message.by;
			let data         = message.data;
			let type         = message.type;
			let profileImage = message.profileImage;
			let username     = message.username;
			$("#username").text(username);
			$("#profileImage").attr("src", profileImage);
		
			switch (type) {
				case "rtvc-client-candidate":
					if (pc.localDescription) {
						await pc.addIceCandidate(new RTCIceCandidate(data));
					}
					break;
				case "rtvc-is-client-ready":
					if (!pc) {
						await getConn();
					}
		
					if (pc.iceConnectionState === "connected") {
						webSocketSend("rtvc-client-already-oncall", null, by);
					} else {
						displayCall(username, profileImage);
					}
					break;
				case "rtvc-client-answer":
					if (pc.localDescription) {
						await pc.setRemoteDescription(data);
						$("#callTimer").timer({format: "%M:%S"})
						await verifyRtcConnection(username, profileImage);
					}
					break;
				case "rtvc-client-offer":
					createAnswer(getSendTo(), data, {
						username: username,
						profileImage: profileImage
					});
					$("#callTimer").timer({format: "%M:%S"})
					break;
				case "rtvc-client-is-ready":
					createOffer(getSendTo());
					break;
				case "rtvc-client-already-oncall":
					displayAlert(username, profileImage, "User is on another call", 'profile', 'hangup');
					break;
				case "rtvc-client-rejected":
					displayAlert(username, profileImage, "User is busy", 'profile', 'hangup');
					break;
				case "rtvc-client-hangup":
					displayAlert(username, profileImage, "Disconnected the call", 'profile', 'hangup');
					break;
				case "chat-message-created":
					await addNewMessageToList(data, 'receiver');
					break;
				case "chat-message-edited":
					$('#messageText-' + (data.id)).html(data.message);
					handleCancelEditMessage();
					break;
				case "chat-message-deleted":
					$('#message-' + (data.id)).remove();
					break;
			}
		}
	}
}

async function webSocketClose() {
	if (conn) {
		await conn.close();
		conn = null;
		console.log("Websocket closed");
	}
}

function webSocketSend(type, data, sendTo) {
	if (conn) {
		conn.send(JSON.stringify({
			sendTo: sendTo,
			type: type,
			data: data
		}));
	}
}

