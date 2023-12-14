
<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Call</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='..\css\VideoCall\VideoCall.css'>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
</head>
<body>

    <button id="join-btn" style = "display:none">Join Stream</button>
    <div id="stream-wrapper">
        <div id="video-streams">
            
        </div>
        <div id="stream-controls">
            <button id="camera-btn"><span class="material-symbols-outlined">videocam</span></button>
            <button id="mic-btn"><span class="material-symbols-outlined">mic</span></button>
            <button id="leave-btn"><span class="material-symbols-outlined">call_end</span></button>
        </div>
    </div>
    
</body>
<script>
    const join = document.getElementById('join-btn');
    document.addEventListener('DOMContentLoaded', () => {
        join.click();
    });
    const leave = document.getElementById('leave-btn');
    leave.addEventListener('click', () => {
        window.close();
    });

    const cameraBtn = document.getElementById('camera-btn');
    cameraBtn.addEventListener('click', () => {
        const span = cameraBtn.querySelector('span');
        span.textContent = span.textContent === 'videocam' ? 'videocam_off' : 'videocam';
    });

    const micBtn = document.getElementById('mic-btn');
    micBtn.addEventListener('click', () => {
        const span = micBtn.querySelector('span');
        span.textContent = span.textContent === 'mic' ? 'mic_off' : 'mic';
    });

</script>
<script src="..\script\AgoraRTC_N-4.19.3.js"></script>
<script src='..\script\Call.js'></script>

<?php require_once "../components/light-switch.php"?>
</html>