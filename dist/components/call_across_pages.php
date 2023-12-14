<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $token = $_SESSION['auth_user']['token'];
?>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
<style>
    #placeForCall{
        position:fixed;
        top:20vh;
        left:50%;
        transform: translateX(-50%);
        z-index:10000;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 2vh;
        padding: 3rem;
        & > form{
            min-width: fit-content;
            min-height: fit-content;
            background-color: #fdc161;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            padding: 3rem;
            border-radius: 1rem;
            gap: 2vh;
            & > img {
                border-radius: 50%;
                height: 5rem;
                width: 5rem;
            }
            & > .button_container{
                display: flex;
                justify-content: space-around;
                align-items: center;
                gap: 2vw;
                width: 100%;
                & > button{
                border-radius: 50%;
                padding: 1rem;
                display:flex;
                justify-content: center;
                align-items: center;
                cursor: pointer;
                align-self: center;
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
        output += ' <img src="../image/logo.png" alt="logo">';
        output += ' <p>Incoming Call from admin</p>';
        output += ' <input type="hidden" name = "channel" value="' + data.channel + '">';
        output += ' <div class = "button_container">';
        output += '     <button type="submit" class="join_call_button" id="join_call_button"><span class="material-symbols-outlined">call</span></button>';
        output += '     <button type="button" class="decline_call_button" id="decline_call_button"><span class="material-symbols-outlined">call_end</span></button>';
        output += ' </div>';
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
    //decline call
    document.addEventListener('click', function(event) {
        if (event.target.matches('.decline_call_button')) {
            event.stopPropagation(); // Stop the event propagation

            var parentElement = event.target.parentElement;
            var grandElement = parentElement.parentElement;
            removeElement(grandElement);
        }
    });

    function removeElement(element) {
        if (element && element.parentNode) {
            element.parentNode.removeChild(element);
        }
    }
</script>