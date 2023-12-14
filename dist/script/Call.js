
const client = AgoraRTC.createClient({mode:'rtc', codec:'vp8'})

let localTracks = []
let remoteUsers = {}

let isSender;

let joinAndDisplayLocalStream = async () => {

    client.on('user-published', handleUserJoined);
    
    client.on('user-left', handleUserLeft);

    //get channel and serveruid
    let channel, uid;

    try {
        ({ channel, uid } = await getChannelAndUid());
    } catch (error) {
        console.error('Error:', error);
        return false;
    }
    let belongsToCall;
    try {
        belongsToCall = await checkUserInCall(uid, channel);
    } catch (error) {
        console.error('Error:', error);
        return false;
    }
    if (belongsToCall.toLowerCase() === "You do not have access to this call".toLowerCase() || 
        belongsToCall.toLowerCase() === "Sender has already joined".toLowerCase() || 
        belongsToCall.toLowerCase() === "Receiver has already joined".toLowerCase()) 
    {

        alert(belongsToCall);
        return false;
    }

    let firstWord = belongsToCall.split(' ')[0];

    if (firstWord.toLowerCase() === "sender") {
        isSender = true;
    } else if (firstWord.toLowerCase() === "receiver") {
        isSender = false;
    }
    //if it is, generate the token
    let token, appId;

    try {
        ({token, appId} = await generateToken(channel, uid));
    } catch (error) {
        console.error('Error:', error);
        return false;
    }
    //and then do the process of joining
    let UID = await client.join(appId, channel, token, uid);

    let audioTrack = await AgoraRTC.createMicrophoneAudioTrack();

    let videoTrack;
    let devices = await AgoraRTC.getDevices();
    let videoDevices = devices.filter(device => device.kind === 'videoinput');

    if (videoDevices.length > 0) {
        videoTrack = await AgoraRTC.createCameraVideoTrack();
    }

    localTracks = [audioTrack, videoTrack].filter(track => track !== undefined);

    if (videoTrack) {
        let player = `<div class="video-container" id="user-container-${UID}">
                            <div class="video-player" id="user-${UID}"></div>
                      </div>`;
        document.getElementById('video-streams').insertAdjacentHTML('beforeend', player);

        videoTrack.play(`user-${UID}`);
    }

    await client.publish(localTracks);
    return true;
}

let joinStream = async () => {
    let hasJoined = await joinAndDisplayLocalStream();
    if (!hasJoined) {
        return;
    }
    
    document.getElementById('join-btn').style.display = 'none';
    document.getElementById('stream-controls').style.display = 'flex';

     //get the uid
    let channel, uid;

    try {
        ({ channel, uid } = await getChannelAndUid());
    } catch (error) {
        console.error('Error:', error);
        return false;
    }
    
    updateJoinStatus(uid, true, channel);
}
let handleUserJoined = async (user, mediaType) => {
    let currentUsers = Object.keys(remoteUsers).length;


    remoteUsers[user.uid] = user;
    await client.subscribe(user, mediaType);

    if (mediaType === 'video'){
        let player = document.getElementById(`user-container-${user.uid}`);
        if (player != null){
            player.remove();
        }

        player = `<div class="video-container" id="user-container-${user.uid}">
                        <div class="video-player" id="user-${user.uid}"></div> 
                    </div>`;
        document.getElementById('video-streams').insertAdjacentHTML('beforeend', player);

        user.videoTrack.play(`user-${user.uid}`);
    }

    if (mediaType === 'audio'){
        user.audioTrack.play();
    }
}

let handleUserLeft = async (user) => {
    delete remoteUsers[user.uid]
    document.getElementById(`user-container-${user.uid}`).remove()
}

let leaveAndRemoveLocalStream = async () => {
    for(let i = 0; localTracks.length > i; i++){
        localTracks[i].stop()
        localTracks[i].close()
    }

    await client.leave()
    document.getElementById('join-btn').style.display = 'block'
    document.getElementById('stream-controls').style.display = 'none'
    document.getElementById('video-streams').innerHTML = '';
    
    //get the uid
    let channel, uid;

    try {
        ({ channel, uid } = await getChannelAndUid());
    } catch (error) {
        console.error('Error:', error);
        return false;
    }
    updateJoinStatus(uid, false, channel);
}

let toggleMic = async (e) => {
    if (localTracks[0].muted){
        await localTracks[0].setMuted(false)
    }else{
        await localTracks[0].setMuted(true)
    }
}

let toggleCamera = async (e) => {
    if(localTracks[1].muted){
        await localTracks[1].setMuted(false)
    }else{
        await localTracks[1].setMuted(true)
    }
}

// function to get channel and uid
async function getChannelAndUid() {
    // Make an AJAX request to get_call_function.php
    let response = await fetch('../function/call_chat/get_call_function.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
    });

    if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`);
    }

    // Parse the JSON response
    let data = await response.json();

    // The get_call_function.php script should return the channel and uid
    let { channel, uid } = data;
    return { channel, uid };
}
// check if the user belongs to the call
let checkUserInCall = async (userId, channel) => {
    // Make an AJAX request to check_user_in_call.php
    let formData = new FormData();
    formData.append('userId', userId);
    formData.append('channel', channel); 

    let response = await fetch('../function/call_chat/check_user_in_call.php', {
        method: 'POST',
        body:formData
    });

    if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`);
    }

    // Parse the JSON response
    let data = await response.json();

    // The check_user_in_call.php script should return whether the user belongs to the call
    let { belongsToCall } = data;

    return belongsToCall;
}
//generate the token
let generateToken = async (channel, uid) => {
    // Make an AJAX request to generateTokenCall.php
    let formData = new FormData();
    formData.append('userId', uid);
    formData.append('channel', channel); 
    let response = await fetch('../function/call_chat/generateTokenCall.php', {
        method: 'POST',
        body: formData,
    });

    if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`);
    }

    // Parse the JSON response
    let data = await response.json();

    // The generateTokenCall.php script should return the token and appId
    let { token, appId } = data;

    return { token, appId };
}

//update join status
async function updateJoinStatus(userId, hasJoined, channel) {
    let formData = new FormData();
    formData.append('user_id', userId);
    formData.append('has_joined', hasJoined ? 1 : 0);
    formData.append('channel', channel);
    formData.append('is_sender', isSender);

    const response = await fetch('../function/call_chat/update_join_status.php', {
        method: 'POST',
        body: formData
    });

    if (!response.ok) {
        console.error('Error:', response.status);
        return;
    }

    console.log('Update successful');
}

document.getElementById('join-btn').addEventListener('click', joinStream)
document.getElementById('leave-btn').addEventListener('click', leaveAndRemoveLocalStream)
document.getElementById('mic-btn').addEventListener('click', toggleMic)
document.getElementById('camera-btn').addEventListener('click', toggleCamera)