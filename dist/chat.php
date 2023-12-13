<?php 

use MyApp\Controller\Chat\ChatUser;

//privatechat.php

session_start();
if(!isset($_SESSION['auth_user']))
{
	header('location:authentication/loginpage.php');
}

require_once __DIR__ . '/../vendor/autoload.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.2.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="css\chat\content-message.css">
	<link rel="stylesheet" href="css\chat\conversation.css">
	<link rel="stylesheet" href="css\chat\responsive-chatbox.css">
    <title>Chat</title>

<!-- code from yt -->
    <script
	src="https://code.jquery.com/jquery-3.7.1.min.js"
	integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
	crossorigin="anonymous"></script>
    <!-- Core plugin JavaScript-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/parsley.js/2.9.2/parsley.min.js"></script>
</head>
<body>

<!-- stores info in the page -->
	<?php
				
		$login_user_id = $_SESSION['auth_user']["id"];

		$token = $_SESSION['auth_user']["token"];
		$name = $_SESSION['auth_user']["fname"] . ' ' . $_SESSION['auth_user']["lname"];
		$role = $_SESSION['auth_user']["role"];
		$isAdmin = false;
		if ($role == '1'){
			$isAdmin = true;
		}
	?>
		<input type="hidden" name="login_user_id" id="login_user_id" value="<?php echo $login_user_id; ?>" />
		<input type="hidden" name="is_active_chat" id="is_active_chat" value="No" />
		<input type="hidden" name="isAdmin" id="isAdmin" value="<?php echo $isAdmin?>"/>
	<?php

		$user_object = new ChatUser;

		$user_object->setUserId($login_user_id);

		$user_data = $user_object->get_user_all_data_with_status_count();

	?>
					
<!-- start: Chat -->

<main class = "content">
	<div class="chat-container">
		<div class="chat-content">
			<div class="content-sidebar">
				<!-- search start here -->
				<div class="content-sidebar-title"><a>Chats</a></div>
				<form action="" class="content-sidebar-form">
					<input type="search" class="content-sidebar-input" placeholder="Search...">
					<button type="submit" class="content-sidebar-submit"><i class="ri-search-line"></i></button>
				</form>
				<div class="content-messages">
					<ul class="content-messages-list">
						<li class="content-message-title"></li>
						<?php
							foreach($user_data as $key => $user)
							{
								// for login ung icon
								$icon = '<input type=hidden id="user_status_'.$user["user_id"].'" value="false" >';


								if($user['user_login_status'] == 'Login')
								{
									$icon = '<input type=hidden id="user_status_'.$user["user_id"].'" value="true" >';
								}

								if($user['user_id'] != $login_user_id)
								{
									if($user['count_status'] > 0)
									{
										$total_unread_message = '
										<span class="content-message-more">
											<span class="content-message-unread" id="userid_'.$user['user_id'].'">'.$user['count_status'] .'</span>
										</span>';
									}
									else
									{
										$total_unread_message = '';
									}
									$image = $user['photo'];
									if($image == '') {
										$image = '../../icons/icons-user.png';
									}
									echo "
									<li>
										<a class='select_user'  data-userid = '".$user['user_id']."'>
											<img class='content-message-image' id='user_photo_".$user["user_id"]."' src='upload/userImages/".$image."' alt=''>
											<span class='content-message-info'>
												<span class='content-message-name' id='list_user_name_".$user["user_id"]."'>".$user['fname']."</span>
											</span>
											".$total_unread_message."
											".$icon."
										</a>
									</li>
									";
								}
							}
						?>
					</ul>
				</div>

			</div>

			<!-- start: Conversation -->
			<div class="conversation conversation-default active"  id = "default_chat_area">
				<i class="ri-chat-3-line"></i>
				<p>Select chat and view conversation</p>
			</div>
			<div class="conversation" id = "chat_area">
			</div>
		</div>
	</div>
</main>

</body>
<script type="text/javascript">
	$(document).ready(function(){

		var receiver_userid = '';

		var conn = new WebSocket('ws://localhost:8080?token=<?php echo $token; ?>');

		conn.onopen = function(event)
		{
			console.log('Connection Established');
		};

		conn.onmessage = function(event)
		{
			var data = JSON.parse(event.data);

			if(data.status_type == 'Online')
			{
				$('#userstatus_'+data.user_id_status).val('true') ;
			}
			else if(data.status_type == 'Offline')
			{
				$('#userstatus_'+data.user_id_status).val('false');
			}
			else
			{

				var row_class = '';
				var background_class = '';
				
				if(data.from == 'Me')
				{
					row_class = 'me';
				}
				else
				{
					row_class = '';
				}

				if(receiver_userid == data.userId || data.from == 'Me')
				{
					if($('#is_active_chat').val() == 'Yes')
					{
						var count = 0;
						count--;
						var output;
						if(data.type == 'call') {
							var isAdmin = $('#isAdmin').val();
							if(isAdmin == 1) {
								output = '<button type="button" class="btn btn-success btn-sm join_call_button">Call Again</button>';
							} else{
								output = '<b>A call has been processed by an admin. Message them to request for a call again</b>';
							}
						} else {
							output = data.msg;
						}

						var html_data = `
						<li class = "conversation-item  ${row_class}">
								<div class="conversation-item-content">
									<div class="conversation-item-wrapper">
										<div class="conversation-item-box">
											<div class = "conversation-item-text">
												<p> ${output}</p>
												<div class="conversation-item-time">${data.datetime}</div>
											</div>
										</div>
									</div>
								</div>
							</li>
							`;

						$('#messages_area').append(html_data);

						var parentElement = $('#messages_area').parent();
						parentElement.scrollTop(parentElement[0].scrollHeight);
						
						$('#chat_message').val("");
					}
				}
				else
				{
					var count_chat = $('#userid'+data.userId).text();

					if(count_chat == '')
					{
						count_chat = 0;
					}

					count_chat++;

					$('#userid_'+data.userId).html('<span class="">'+count_chat+'</span>');
				}
			}
		};

		conn.onclose = function(event)
		{
			console.log('connection close');
		};

		function make_chat_area(user_name, status, photo) {
			var isAdmin = $('#isAdmin').val();
			var call = '';
			if(isAdmin == "1") {
				call = `<button type="button" id="video_call_button"><i class="ri-vidicon-line"></i></button>`;
			}
			var html = `
				<div class = "conversation-top">
					<button type="button" class="conversation-back"  id="close_chat_area" data-dismiss="alert"><i class="ri-arrow-left-line"></i></button>
					<div class="conversation-user">
						<img class="conversation-user-image" src="${photo}" alt="">
						<div>
							<div class="conversation-user-name">${user_name}</div>
							<div class="conversation-user-status ${status}"><a>${status}</a></div>
						</div>
					</div>

					<!-- eto pang video call -->
					<div class="conversation-buttons">
						${call}
					</div>
				</div>
				<div class="conversation-main">
					<ul class="conversation-wrapper" id="messages_area" >
					</ul>
				</div>
				<form class = "conversation-form" id="chat_form" method="POST" data-parsley-errors-container="#validation_error">
					<div class="conversation-form-group">
						<input type="hidden" id="message_type" name="message_type" value="message">
						<input type="hidden" id="channel" name="channel">
						<textarea class="conversation-form-input" id="chat_message" name="chat_message" placeholder="Type Message Here" data-parsley-maxlength="1000" data-parsley-pattern="/^[a-zA-Z0-9 \\n]+$/" required></textarea>
					</div>
					<button type="submit" name="send" class="conversation-form-button conversation-form-submit"><i class="ri-send-plane-2-line"></i></button>
					<div id="validation_error"></div>
					<br/>
				</form>
			`;

			$('#chat_area').html(html);
			$('#default_chat_area').removeClass('active');
			$('#chat_area').addClass('active');
			$('#chat_form').parsley();
		}

		$(document).on('click', '.select_user', function(){
			receiver_userid = $(this).data('userid');

			var from_user_id = $('#login_user_id').val();

			var receiver_user_name = $('#list_user_name_'+receiver_userid).text();

			var photo = $('#user_photo_'+receiver_userid).attr('src');

			var inpStatus = $('#user_status_'+receiver_userid).val();
			var status = 'offline';
			if(inpStatus == "true"){
				status = 'online';
			}
			$('.select_user.active').removeClass('active');

			$(this).addClass('active');


			make_chat_area(receiver_user_name, status, photo);

			$('#is_active_chat').val('Yes');

			$.ajax({
				url:"function/call_chat/action.php",
				method:"POST",
				data:{action:'fetch_chat', to_user_id:receiver_userid, from_user_id:from_user_id},
				dataType:"JSON",
				success:function(data)
				{
					if(data.length > 0)
					{
						console.log("hello");
						var html_data = '';

						for(var count = 0; count < data.length; count++)
						{
							var row_class= ''; 
							var background_class = '';
							var user_name = '';

							var message_type = data[count].message_type;

							if(data[count].message_type == 'call') {
								var isAdmin = $('#isAdmin').val();
								if(isAdmin == 1) {
									output = '<button type="button" class="btn btn-success btn-sm join_call_button" >Call Again</button>';
								} else{
									output = '<b>A call has been processed by an admin. Message them to request for a call again</b>';
								}
								
							} else {
								output = data[count].chat_message;
							}

							if(data[count].from_user_id == from_user_id)
							{
								row_class = 'me';
								user_name = 'Me';
							}
							else
							{
								row_class = '';
								user_name = data[count].from_user_name;
							}
							html_data += `
							<li class = "conversation-item  ${row_class}">
								<div class="conversation-item-content">
									<div class="conversation-item-wrapper">
										<div class="conversation-item-box">
											<div class = "conversation-item-text">
												<p> ${output}</p>
												<div class="conversation-item-time">${data[count].timestamp}</div>
											</div>
										</div>
									</div>
								</div>
							</li>
							`;
							
						}

						$('#userid_'+receiver_userid).html('');

						$('#messages_area').html(html_data);

						var parentElement = $('#messages_area').parent();
						parentElement.scrollTop(parentElement[0].scrollHeight);

					}
				},
				error: function(jqXHR, textStatus, errorThrown) {
					console.log(textStatus, errorThrown);
				}
			})

		});

		$(document).on('click', '#close_chat_area', function(){

			$('#chat_area').html('');

			$('.select_user.active').removeClass('active');

			$('#is_active_chat').val('No');

			receiver_userid = '';

		});

		$(document).on('submit', '#chat_form', function(event){
			event.preventDefault();
			
			$.ajax({
				url: 'function/call_chat/check_login_status.php', // replace with your PHP script
				method: 'POST',
				success: function(response) {
					if (response.loggedIn) { // replace with the actual response field
						if($('#chat_form').parsley().isValid())
						{
							var user_id = parseInt($('#login_user_id').val());

							var message = $('#chat_message').val();

							var message_type=  $('#message_type').val();
							var data = {//save it in the database
								userId: user_id,
								msg: message,
								receiver_userid:receiver_userid,
								command:'private',
								type:message_type,
								channel:$('#channel').val()
							};
							conn.send(JSON.stringify(data));
						}
					} else {
						alert("session expired, log in again");
						location.reload();
					}
				}
			});
		});
		$(document).on('click', '#video_call_button', function(event){
			event.preventDefault();
			$('#message_type').val('call');
			$('#chat_message').val('this is a call');
			// Your code for initiating a video call goes here
			// Use AJAX to generate the channel
			$.ajax({
				url: 'function/call_chat/generateChannelForCall.php',
				method: 'POST',
				data: { uid: $('#login_user_id').val() },
				success: function(data) {
					// Set the values of the hidden fields
					$('#channel').val(data.channelName);
					$.ajax({
						url: 'function/call_chat/action.php',
						method: 'POST',
						data: {
							channel: $('#channel').val(),
							action: 'join_call'
						}
					});
					// Submit the form
					$('#chat_form').submit();
					window.open('user/VideoCall.php', '_blank');
				}
			});
			
		});

		$(document).on('click', '.join_call_button', function(event){
			$('#video_call_button').click();
		});

		$(document).on('click', '#send', function(event){
			event.preventDefault();
			//change the value of the message_type to message
			$('#message_type').val('message');
			$('#chat_form').submit();
		});

		$(document).on('click', '.conversation-back', function(){
			$('#chat_area').html('');

			$('#chat_area').removeClass('active');

			$('#default_chat_area').addClass('active');
		});
	})

</script>
</html>

