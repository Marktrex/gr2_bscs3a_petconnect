<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $token = $_SESSION['auth_user']['token'];
?>

<style>
    #placeForCall{
        position:fixed;
        top:20vh;
        left:50%;
        transform: translateX(-50%);
        z-index:10000;
    }
</style>

<div id= "placeForCall">
</div>

<script>
    const socket = new WebSocket('ws://localhost:8080?token=<?php echo $token; ?>');

    socket.addEventListener("open", (event) => {
        console.log("Connection established!");
    });

    // Listen for messages
    socket.addEventListener("message", (event) => {
    const data = JSON.parse(event.data);
    console.log(data);
    let output="";
    if(data.type == 'call') {
        output = '<form class="join_call_form" id="join_call_form_"' + data.channel + '" method="POST" >';
        output += '<input type="hidden" name = "channel" value="' + data.channel + '">';
        output += '<button type="submit"  id="join_call_button">Join Call</button>';
        output += '<button type="button"  id="decline_call_button">Decline Call</button>';
        output += '</form>';
    }
    document.getElementById('placeForCall').innerHTML += output;
    
    });
    document.addEventListener('submit', function(event) {
    if (event.target.matches('.join_call_form')) {
        event.preventDefault();

        var form = event.target;
        var channel = form.querySelector('input[type="hidden"]').value;

        var formData = new FormData();
        formData.append('action', 'join_call');
        formData.append('channel', channel);

        fetch('../../action.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            window.open('../user/VideoCall.php', '_blank');
        })
        .catch((error) => {
            console.error('Error:', error);
        });
    }
    });
</script>