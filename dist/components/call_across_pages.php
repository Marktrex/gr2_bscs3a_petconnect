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

        & > form{
            height: 10vh;
            width: 10vw;
            background-color: #fdc161;
            & > img {
                border-radius: 50%;
                border: 2px solid white;
            }

            & > button{
                border-radius: 50%;
                padding: 1rem;
                margin-right: 2rem;
            }
            > .join_call_button{
                background-color: #4caf50;
                border: none;
                color: white;
            }
            > .decline_call_button{
                background-color: #f44336;
                border: none;
                color: white;
            }
        }
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
        output += '<img src="../image/logo.png" alt="logo" width="50" height="50">';
        output += '<p>Incoming Call from admin</p>';
        output += '<input type="hidden" name = "channel" value="' + data.channel + '">';
        output += '<button type="submit" class="join_call_button" id="join_call_button">Join Call</button>';
        output += '<button type="button" class="decline_call_button" id="decline_call_button">Decline Call</button>';
        output += '</form>';
    }
    document.getElementById('placeForCall').innerHTML += output;
    
    });
    //accept call
    document.addEventListener('submit', function(event) {
    if (event.target.matches('.join_call_form')) {
        event.preventDefault();

        var form = event.target;
        var channel = form.querySelector('input[type="hidden"]').value;
        
        var formData = new FormData();
        formData.append('action', 'join_call');
        formData.append('channel', channel);
        console.log(formData);
        fetch('..\\function\\call_chat\\action.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            removeElement(form); // Remove the form
            window.open('../user/VideoCall.php', '_blank');
        })
        .catch((error) => {
            console.error('Error:', error);
        });
    }
    });
    //decline call
    document.addEventListener('click', function(event) {
        if (event.target.matches('.decline_call_button')) {
            var parentElement = event.target.parentElement;
            removeElement(parentElement);
        }
    });

    function removeElement(element) {
        if (element && element.parentNode) {
            element.parentNode.removeChild(element);
        }
    }
</script>