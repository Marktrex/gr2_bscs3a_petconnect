<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Call</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='..\css\VideoCall\VideoCall.css'>
</head>
<body>

    <button id="join-btn" style = "display:none">Join Stream</button>
    <div id="stream-wrapper">
        <div id="video-streams">
            
        </div>

        <div id="stream-controls">
            <button id="leave-btn">Leave Stream</button>
            <button id="mic-btn">Mic On</button>
            <button id="camera-btn">Camera on</button>
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
</script>
<script src="..\script\AgoraRTC_N-4.19.3.js"></script>
<script src='..\script\Call.js'></script>
</html>