<?php 

//privatechat.php

session_start();
if(!isset($_SESSION['auth_user']))
{
	header('location:dist/loginpage.php');
}

require('database/ChatUser.php');

require('database/ChatRooms.php');

?>

<!DOCTYPE html>
<html>
<head>
	<title>Chat application in php using web scocket programming</title>
	<!-- Bootstrap core CSS -->
    <link href="vendor-front/bootstrap/bootstrap.min.css" rel="stylesheet">

    <link href="vendor-front/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <link rel="stylesheet" type="text/css" href="vendor-front/parsley/parsley.css"/>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor-front/jquery/jquery.min.js"></script>
    <script src="vendor-front/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor-front/jquery-easing/jquery.easing.min.js"></script>

    <script type="text/javascript" src="vendor-front/parsley/dist/parsley.min.js"></script>
	<style type="text/css">
		html,
		body {
		  height: 100%;
		  width: 100%;
		  margin: 0;
		}
		#wrapper
		{
			display: flex;
		  	flex-flow: column;
		  	height: 100%;
		}
		#remaining
		{
			flex-grow : 1;
		}
		#messages {
			height: 200px;
			background: whitesmoke;
			overflow: auto;
		}
		#chat-room-frm {
			margin-top: 10px;
		}
		#user_list
		{
			height:450px;
			overflow-y: auto;
		}

		#messages_area
		{
			height: 75vh;
			overflow-y: auto;
			/*background-color:#e6e6e6;*/
			/*background-color: #EDE6DE;*/
		}

	</style>
</head>
<body>
	<div class="container-fluid">
		
		<div class="row">

			<div class="col-lg-3 col-md-4 col-sm-5" style="background-color: #f1f1f1; height: 100vh; border-right:1px solid #ccc;">
				<?php
				
				$login_user_id = $_SESSION['auth_user']["id"];

				$token = $_SESSION['auth_user']["token"];
				$name = $_SESSION['auth_user']["fname"] . ' ' . $_SESSION['auth_user']["lname"];

				?>
				<input type="hidden" name="login_user_id" id="login_user_id" value="<?php echo $login_user_id; ?>" />

				<input type="hidden" name="is_active_chat" id="is_active_chat" value="No" />

				<div class="mt-3 mb-3 text-center">

					
	
					<h3 class="mt-2"><?php echo $name; ?></h3>

					<a href="dist/user/home.php" class="btn btn-secondary mt-2 mb-2">Back</a>
					<input type="button" class="btn btn-primary mt-2 mb-2" id="logout" name="logout" value="Logout" onclick="window.location.href='dist/function/logout.php'"/>
				</div>
				<?php

				$user_object = new ChatUser;

				$user_object->setUserId($login_user_id);

				$user_data = $user_object->get_user_all_data_with_status_count();

				?>
				<div class="list-group" style=" max-height: 100vh; margin-bottom: 10px; overflow-y:scroll; -webkit-overflow-scrolling: touch;">
					<?php
					
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
								$total_unread_message = '<span class="badge badge-danger badge-pill">' . $user['count_status'] . '</span>';
							}
							else
							{
								$total_unread_message = '';
							}

							echo "
							<a class='list-group-item list-group-item-action select_user' style='cursor:pointer' data-userid = '".$user['user_id']."'>
								
								<span class='ml-1'>
									<strong>
										<span id='list_user_name_".$user["user_id"]."'>".$user['lname']."</span>
										<span id='userid_".$user['user_id']."'>".$total_unread_message."</span>
									</strong>
								</span>
								<span class='mt-2 float-right' id='userstatus_".$user['user_id']."'>".$icon."</span>
							</a>
							";
						}
					}


					?>
				</div>
			</div>
			
			<div class="col-lg-9 col-md-8 col-sm-7">
				<br />
		        <h3 class="text-center">MESSAGES</h3>
		        <hr />
		        <br />
		        <div id="chat_area"></div>
			</div>
			
		</div>
	</div>
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
							output = '<form class="join_call_form" id="join_call_form'+count+'" method="POST" data-count="'+count+'">';
								output += '<input type="hidden" name="channel' +count+'" value="' + data.channel + '">';
								output += '<button type="submit" class="btn btn-success btn-sm" id="join_call_button">Join Call</button>';
							output += '</form>';
						} else {
							output = data.msg;
						}

						var html_data = `
						<div class="`+row_class+`">
							<div class="col-sm-10">
								<div class="shadow-sm alert `+background_class+`">
									<b>`+data.from+` - </b>`+output+`<br />
									<div class="text-right">
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

					$('#userid_'+data.userId).html('<span class="badge badge-danger badge-pill">'+count_chat+'</span>');
				}
			}
		};

		conn.onclose = function(event)
		{
			console.log('connection close');
		};

		function make_chat_area(user_name)
		{
			var html = `
			<div class="card">
				<div class="card-header">

					<div class="row">
						<div class="col col-sm-6">
							<b>Chat with <span class="text-danger" id="chat_user_name">`+user_name+`</span></b>
						</div>
						<div class="col col-sm-6 text-right">
							<a href="#" id="video_call_button" class="btn btn-success btn-sm">Call</a>&nbsp;&nbsp;&nbsp;
							<button type="button" class="close" id="close_chat_area" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
					</div>

				</div>
				<div class="card-body" id="messages_area">

				</div>
			</div>

			<form id="chat_form" method="POST" data-parsley-errors-container="#validation_error">
				<div class="input-group mb-3" style="height:7vh">
					<input type="hidden" id="message_type" name="message_type" value="message">
					<input type="hidden" id="channel" name="channel">
					<textarea class="form-control" id="chat_message" name="chat_message" placeholder="Type Message Here" data-parsley-maxlength="1000" data-parsley-pattern="/^[a-zA-Z0-9 ]+$/" required></textarea>
					<div class="input-group-append">
						<button type="submit" name="send" id="send" class="btn btn-primary"><i class="fa fa-paper-plane"></i></button>
					</div>
				</div>
				<div id="validation_error"></div>
				<br />
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
				url:"action.php",
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

								user_name = data[count].from_user_lname;
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
		$(document).on('submit', '.join_call_form', function(event){
			event.preventDefault();

			var form = $(this);
			var count = form.data('count');

			$.ajax({
				url: 'action.php',
				method: 'POST',
				data: {
					channel: form.find('input[name="channel'+count+'"]').val(),
					action: 'join_call'
				},
				success: function() {
					window.open('dist/user/VideoCall.php', '_blank');
				}
			});
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
				url: 'dist/function/check_login_status.php', // replace with your PHP script
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
				url: 'dist\\function\\generateChannelForCall.php',
				method: 'POST',
				data: { uid: $('#login_user_id').val() },
				success: function(data) {
					// Set the values of the hidden fields
					$('#channel').val(data.channelName);
					$.ajax({
						url: 'action.php',
						method: 'POST',
						data: {
							channel: $('#channel').val(),
							action: 'join_call'
						}
					});
					// Submit the form
					$('#chat_form').submit();
					window.open('dist/user/VideoCall.php', '_blank');
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
