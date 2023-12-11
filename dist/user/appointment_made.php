<?php 
    session_start(); // Add this line to start the session
    print_r($_SESSION);
    // if (isset($_SESSION['auth_user']) && $_SESSION['auth_user']['role'] === "1") { 
    //     header("Location: ../admin/admin-dashboard.php");
    //     exit();
    // }
    // if (!isset($_SESSION['auth_user'])) { 
    //     header("Location: ../error/403-forbidden.html");
    //     exit();
    // }

    // if (!isset($_POST['fname'])){
    //     header("Location: ../user/appointment.php");
    //     exit();
    // }
    // $fname = $_POST['fname'];
    // $lname = $_POST['lname'];
    // $mobile = $_POST['mobile'];
    // $address = $_POST['address'];
    // $type = $_POST['type'];
    // $date = $_POST['date'];
    // $time_slot = $_POST['time-slot'];

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Confirmation Page</title>
    <link rel="stylesheet" href="../css/newlyAdded/confirmation.css">
</head>
<body>
	<main>

		<div class="container">
		<div class="content-box">


		<div class="text">
		<p><h2>Booking Successful</h2></p>
	    </div>

		<div class="text2">
		<h4>We have successfully recorded your appointment in our database. We will be happy to be of service. PetConnect is eager to meet with you at the appointed time. Please review the appointment details listed below:</h4>
	    </div>

        <div class="stacks">
        	<span class="details"><h3>Details:</h3></span>
        	<span class="apptype"><h3>Appointed Type:</h3></span>
        	<span class="appdate"><h3>Appointed Date:</h3></span>
        	<span class="sesstime"><h3>Session Time:</h3></span>
        	<span class="address"><h3>Address:</h3></span>
       

     <div class="conditions">
      <h3>Conditions:</h3>
     </div>
     
     <div class="text3">
     	<h3>Kindly arrive at the designated location no later that ten minutes before your 
     scheduled the time of the appointment.</h3>
     </div>
    
      <div class="text4">
      	<h3>Please send our admin a private message or email our customer support team at mail to petconnect@gmail.com at least <b>24 hours in advance</b> if you need to cancel or reschedule your appointment.</h3>
      </div>
   
     <div class="text5">
     	<h3>You can log in to your appointment to see its status and make any changes. profile on our mobile application or website. Details and status of your appointmenr will be accessible.</h3>
     </div>

     <div class="text6 ">
       <h3> You can log in to your appointment to see its status and make any changes. profile on our mobile application or website. Details and status of your appointment will be accessible.</h3>
   </div>

   <div class="flex-container">
   	<div class="exit-box">
   		<div class="exit">
         <h3>Exit</h3>
     </div>
   	</div>
   </div>



   </div>
   </div>

		
   
	</main>
</html>