<?php 

use MyApp\Controller\Chat\ChatUser;

//privatechat.php

session_start();
print_r($_SESSION);
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
    <link rel="stylesheet" href="css/newlyAdded/message.css">
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
<?php
				
				$login_user_id = $_SESSION['auth_user']["id"];

				$token = $_SESSION['auth_user']["token"];
				$name = $_SESSION['auth_user']["fname"] . ' ' . $_SESSION['auth_user']["lname"];

				?>
				<input type="hidden" name="login_user_id" id="login_user_id" value="<?php echo $login_user_id; ?>" />

				<input type="hidden" name="is_active_chat" id="is_active_chat" value="No" />

				<div class="chat-container">
					<!-- <h3 class=""><?php
					//  echo $name; 
					 ?></h3> -->
					<a href="user/home.php" class="">Back</a>
					<input type="button" class="" id="logout" name="logout" value="Logout" onclick="window.location.href='function/logout.php'"/>
				</div>
				<?php

				$user_object = new ChatUser;

				$user_object->setUserId($login_user_id);

				$user_data = $user_object->get_user_all_data_with_status_count();

				?>
        <div class="">
					
<!-- start: Chat -->
<section class="chat-section">
        <div class="chat-container">

            <div class="chat-content">
                <!-- start: Conversation -->
                <div class="conversation" id="conversation-1">
                    <div class="conversation-top">
                        <button type="button" class="conversation-back"><i class="ri-arrow-left-line"></i></button>
                        <div class="conversation-user">
                            <img class="conversation-user-image" src="icons/icons-user.png" alt="">
                            <div>
                                <div class="conversation-user-name"><?php
					
					foreach($user_data as $key => $user)
					{
						$icon = '<i class="fa fa-circle text-danger"></i>';

						if($user['user_login_status'] == 'Login')
						{
							$icon = '<i class="fa fa-circle text-success"></i>';
						}

						if($user['user_id'] != $login_user_id)
						{
							if($user['count_status'] > 0)
							{
								$total_unread_message = '<span class="">' . $user['count_status'] . '</span>';
							}
							else
							{
								$total_unread_message = '';
							}

							echo "
							<a class='select_user'  data-userid = '".$user['user_id']."'>
								
								<span class='ml-1'>
									<strong>
										<span id='list_user_name_".$user["user_id"]."'>".$user['lname']."</span>
										<span id='userid_".$user['user_id']."'>".$total_unread_message."</span>
									</strong>
								</span>
								<span class='' id='userstatus_".$user['user_id']."'>".$icon."</span>
							</a>
							";
						}
					}


					?></div>
                                <div class="conversation-user-status online"><a>online</a></div>
                            </div>
                        </div>
                        <div class="conversation-buttons">
                            <button type="button"><i class="ri-vidicon-line"></i></button>
                            <button type="button"><i class="ri-information-line"></i></button>
                        </div>
                    </div>
                    <div class="conversation-main">
                        <ul class="conversation-wrapper">
                            <div class="coversation-divider"><span>Today</span></div>
							<div id="chat_area"></div>
                            <li class="conversation-item me">
                                <div class="conversation-item-side">
                                    <img class="conversation-item-image" src="icons/icons-user.png" alt="">
                                </div>
                                <div class="conversation-item-content">
                                    <div class="conversation-item-wrapper">
                                        <div class="conversation-item-box">
                                            <div class="conversation-item-text">
                                                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Amet natus repudiandae quisquam sequi nobis suscipit consequatur rerum alias odio repellat!</p>
                                                <div class="conversation-item-time">12:30</div>
                                            </div>
                                            <!-- <div class="conversation-item-dropdown">
                                                <button type="button" class="conversation-item-dropdown-toggle"><i class="ri-more-2-line"></i></button>
                                                <ul class="conversation-item-dropdown-list">
                                                    <li><a href="#"><i class="ri-share-forward-line"></i> Forward</a></li>
                                                    <li><a href="#"><i class="ri-delete-bin-line"></i> Delete</a></li>
                                                </ul>
                                            </div> -->
                                        </div>
                                    </div>
                                    <div class="conversation-item-wrapper">
                                        <div class="conversation-item-box">
                                            <div class="conversation-item-text">
                                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Eaque, tenetur!</p>
                                                <div class="conversation-item-time">12:30</div>
                                            </div>
                                           
                                        </div>
                                    </div>
                                </div>
                            </li>

		        <!-- <h3 class="">MESSAGES</h3>
		       <hr />
		        <br /> -->
		        <!-- <div id="chat_area"></div> --> 
			</div>
			
		<!-- </div> -->
	</div>
</section>

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
				$('#userstatus_'+data.user_id_status).html('<i class="fa fa-circle text-success"></i>');
			}
			else if(data.status_type == 'Offline')
			{
				$('#userstatus_'+data.user_id_status).html('<i class="fa fa-circle text-danger"></i>');
			}
			else
			{

				var row_class = '';
				var background_class = '';
				
				if(data.from == 'Me')
				{
					row_class = 'row justify-content-start';
					background_class = 'alert-primary';
				}
				else
				{
					row_class = 'row justify-content-end';
					background_class = 'alert-success';
				}

				if(receiver_userid == data.userId || data.from == 'Me')
				{
					if($('#is_active_chat').val() == 'Yes')
					{
						var count = 0;
						count--;
						var output;
						if(data.type == 'call') {
							output = '<form class="" id="join_call_form'+count+'" method="POST" data-count="'+count+'">';
								output += '<input type="hidden" name="channel' +count+'" value="' + data.channel + '">';
								output += '<button type="submit" class="" id="join_call_button">Join Call</button>';
							output += '</form>';
						} else {
							output = data.msg;
						}

						var html_data = `
						<div class="`+row_class+`">
							<div class="">
								<div class=" `+background_class+`">
									<b>`+data.from+` - </b>`+output+`<br />
									<div class="">
										<small><i>`+data.datetime+`</i></small>
									</div>
								</div>
							</div>
						</div>
						`;

						$('#messages_area').append(html_data);

						$('#messages_area').scrollTop($('#messages_area')[0].scrollHeight);

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

		function make_chat_area(user_name) {
    var html = `
        <div class="conversation-main">
            <ul class="conversation-wrapper">
                <div class="coversation-divider"><span>Chat with <span class="" id="chat_user_name">${user_name}</span></span></div>
                <li class="conversation-item me">
                    <div class="conversation-item-side">
                        <a href="#" id="video_call_button" class="">Call</a>&nbsp;&nbsp;&nbsp;
                        <button type="button" class="" id="close_chat_area" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </li>
            </ul>
            <ul class="conversation-wrapper" id="messages_area"></ul>
        </div>

        <form id="chat_form" method="POST" data-parsley-errors-container="#validation_error">
            <div class="conversation-form">
                <input type="hidden" id="message_type" name="message_type" value="message">
                <input type="hidden" id="channel" name="channel">
                <textarea class="conversation-form-input" id="chat_message" name="chat_message" placeholder="Type Message Here" data-parsley-maxlength="1000" data-parsley-pattern="/^[a-zA-Z0-9 ]+$/" required></textarea>
                <div class="">
                    <button type="submit" name="send" class="conversation-form-button conversation-form-submit"><i class="ri-send-plane-2-line"></i></button>
                </div>
            </div>
            <div id="validation_error"></div>
            <br/>
        </form>
    `;

    $('#chat_area').html(html);

    $('#chat_form').parsley();
}

		$(document).on('click', '.select_user', function(){
			receiver_userid = $(this).data('userid');

			var from_user_id = $('#login_user_id').val();

			var receiver_user_name = $('#list_user_name_'+receiver_userid).text();

			$('.select_user.active').removeClass('active');

			$(this).addClass('active');

			make_chat_area(receiver_user_name);

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
								output = '<form class="join_call_form" id="join_call_form'+count+'" method="POST" data-count="'+count+'">';
									output += '<input type="hidden" name="channel' +count+'" value="' + data[count].channel + '">';
									output += '<button type="submit" class="btn btn-success btn-sm" id="join_call_button">Join Call</button>';
								output += '</form>';
							} else {
								output = data[count].chat_message;
							}

							if(data[count].from_user_id == from_user_id)
							{
								row_class = 'row justify-content-start';

								background_class = 'alert-primary';

								user_name = 'Me';
								
							}
							else
							{
								row_class = 'row justify-content-end';

								background_class = 'alert-success';

								user_name = data[count].from_user_name;
							}
							html_data += `
							<div class="`+row_class+`">
								<div class="col-sm-10">
									<div class="shadow alert `+background_class+`">
										<b>`+user_name+` - </b>
										`+output+`<br />
										<div class="text-right">
											<small><i>`+data[count].timestamp+`</i></small>
										</div>
									</div>
								</div>
							</div>
							`;
							
						}

						$('#userid_'+receiver_userid).html('');

						$('#messages_area').html(html_data);

						$('#messages_area').scrollTop($('#messages_area')[0].scrollHeight);
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

		$(document).on('click', '#send', function(event){
			event.preventDefault();
			//change the value of the message_type to message
			$('#message_type').val('message');
			$('#chat_form').submit();
		});
	})

</script>
</html>

