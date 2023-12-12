<?php

namespace MyApp\Class;

class MakeEmail {

    public function make_body_email_accept($name,$type, $date, $timeslot){
        return '
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Appointment Accept</title>
        </head>
        <body style = "background-color: #fdc161; box-sizing: border-box; font-family: Arial, Helvetica, sans-serif;">
            <div style="padding: 5vw;
                color:#127475;
                ">
                <div style="border: none; border-bottom: 1px solid rgba(242, 84, 45, 0.7); padding: 1rem 0;">
                    <img src="https://i.ibb.co/b6GMMSM/logo.png" alt="Pet Connect Logo" style="border-radius: 50%;
                    height: 10vw; width: 12vw; aspect-ratio: 1/1; margin-left: 5vw;">
                </div>
                <h2 style="text-align: center;">
                    <img src="https://i.ibb.co/1LzZbWH/Ok.png" alt="Image" style="border-radius: 50%;
                    aspect-ratio: 1/1; height: 10vw; width: 12vw;">
                    <br>
                    Your Appointment has been confirmed!
                </h2>
                <br>
                <div style="padding: 5vw;">
                    <p>
                        Dear <span style="font-weight: bold;">'.$name.'</span>,
                    </p>
                    <br><br>
                    <p>
                        PetConnect has successfully received your appointment on
                        <span style="font-weight: bold;">'.$date.'</span>,
                        Please review your details below to verify your information.
                    </p>
                    <br>
                    <table style="width: 100%; border: none; border-collapse: collapse;">
                        <thead style="background-color: #0e9594; color: #FFF6E8;">
                            <tr>
                                <th colspan="2" style="text-align: start; padding: 1.5rem;">Details</th>
                            </tr>
                        </thead>
                        <tbody style="background-color: #f5dfbb; color: #127475;">
                            <tr>
                                <th style="text-align: start; padding: 1.5rem;">Appointment Type</th>
                                <td style="text-align: end; padding: 1.5rem;">'.$type.'</td>
                            </tr>
                            <tr>
                                <th style="text-align: start; padding: 1.5rem;">Appointment Date</th>
                                <td style="text-align: end; padding: 1.5rem;">'.$date.'</td>
                            </tr>
                            <tr>
                                <th style="text-align: start; padding: 1.5rem;">Session Time</th>
                                <td style="text-align: end; padding: 1.5rem;">'.$timeslot.'</td>
                            </tr>
                            <tr>
                                <th style="text-align: start; padding: 1.5rem;">Address to visit</th>
                                <td style="text-align: end; padding: 1.5rem;">Dhvsu main</td>
                            </tr>
                        </tbody>
                    </table>
                    <br>
                    <p style="font-style: italic; font-size: 0.8rem;">
                        PetConnect values data confidentially. Your information will be only used in appointment purposes.
                    </p>
                    <br>
                    <p style=" font-size: 0.8rem;">
                        If there is something wrong with your details please message us at our website <span style="text-decoration: underline;
                        font-weight: bold; font-style: italic;">PetConnect.com</span>
                    </p>
                    <br>
                    <p>
                        Sincerely,
                    </p>
                    <p style="font-weight: bold;">
                        PetConnect
                    </p>
                </div>
            </div>
        </body>
        </html>

        ';
    }

    public function make_body_email_cancel($name){
        return '
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Appointment Accept</title>
        </head>
        <body style = "background-color: #fdc161; box-sizing: border-box; font-family: Arial, Helvetica, sans-serif;">
            <div style="padding: 5vw;
                color:#127475;
                ">
                <div style="border: none;
                border-bottom: 1px solid rgba(242, 84, 45, 0.7);
                padding: 1rem 0;
                display: flex;
                justify-content: space-between;
                align-items: center;">
                    <img src="https://i.ibb.co/b6GMMSM/logo.png" alt="Pet Connect Logo" style="border-radius: 50%;
                    height: 10vw; width: 12vw; aspect-ratio: 1/1; margin-left: 5vw;">
                    <img src="https://i.ibb.co/Pr4Vh99/Box-Important.png" alt="Urgent Image" style="border-radius: 50%;
                    height: 10vw; width: 12vw; aspect-ratio: 1/1; margin-right: 5vw;">
                </div>
                
                <h2 style="text-align: center; padding: 0 5vw;">
                    <img src="https://i.ibb.co/J77xPvN/Urgent-Message.png" alt="Image" style="aspect-ratio: 1/1;
                    height: 10vw; width: 12vw;">
                    <br>
                    Your Appointment has been cancelled
                </h2>
                <br>
                <div style="padding: 5vw;">
                    <p>
                        Dear <span style="font-weight: bold;">'.$name.'</span>,
                    </p>
                    <br><br>
                    <p style="text-align: center;">
                        We deeply apologize for having to cancel your appointment due to unforeseen events in our shelter. We hope for your kind consideration. 
                    </p>
                    <br>
                    <p style=" font-size: 0.8rem;">
                        You are welcome to message us at our website <span style="text-decoration: underline;
                        font-weight: bold; font-style: italic;">PetConnect.com</span>
                    </p>
                    <br>
                    <p>
                        Sincerely,
                    </p>
                    <p style="font-weight: bold;">
                        PetConnect
                    </p>
                </div>
            </div>
        </body>
        </html>

        ';
    }
        
    public function make_body_email_decline($name){
        return '
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Appointment Accept</title>
        </head>
        <body style = "background-color: #fdc161; box-sizing: border-box; font-family: Arial, Helvetica, sans-serif;">
            <div style="padding: 5vw;
                color:#127475;
                ">
                <div style="border: none;
                border-bottom: 1px solid rgba(242, 84, 45, 0.7);
                padding: 1rem 0;
                display: flex;
                justify-content: space-between;
                align-items: center;">
                    <img src="https://i.ibb.co/b6GMMSM/logo.png" alt="Pet Connect Logo" style="border-radius: 50%;
                    height: 10vw; width: 12vw; aspect-ratio: 1/1; margin-left: 5vw;">
                    <img src="https://i.ibb.co/Pr4Vh99/Box-Important.png" alt="Urgent Image" style="border-radius: 50%;
                    height: 10vw; width: 12vw; aspect-ratio: 1/1; margin-right: 5vw;">
                </div>
                <h2 style="text-align: center; padding: 0 5vw;">
                    <img src="https://i.ibb.co/J77xPvN/Urgent-Message.png" alt="Image" style="aspect-ratio: 1/1; height: 10vw; width: 12vw;">
                    <br>
                    Your Appointment has been declined
                </h2>
                <br>
                <div style="padding: 5vw;">
                    <p>
                        Dear <span style="font-weight: bold;">'.$name.'</span>,
                    </p>
                    <br><br>
                    <p style="text-align: center;">
                        Thank you for taking the time to book an appointment on our website. However, we regret to inform you that your appointment has been declined.
                    </p>
                    <br>
                    <p style=" font-size: 0.8rem;">
                        You are welcome to message us at our website <span style="text-decoration: underline;
                        font-weight: bold; font-style: italic;">PetConnect.com</span>
                    </p>
                    <br>
                    <p>
                        Sincerely,
                    </p>
                    <p style="font-weight: bold;">
                        PetConnect
                    </p>
                </div>
            </div>
        </body>
        </html>

        ';
    }

    public function make_body_email_verify($name, $link){
        return '
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Appointment Accept</title>
        </head>
        <body style = "background-color: #fdc161; box-sizing: border-box; font-family: Arial, Helvetica, sans-serif;">
            <div style="padding: 5vw;
                color:#127475;
                ">
                <div style="border: none; border-bottom: 1px solid rgba(242, 84, 45, 0.7); padding: 1rem 0;">
                    <img src="https://i.ibb.co/b6GMMSM/logo.png" alt="Pet Connect Logo" style="border-radius: 50%;
                    height: 10vw; width: 12vw; aspect-ratio: 1/1; margin-left: 5vw;">
                </div>
                <h2 style="text-align: center;">
                    <img src="https://i.ibb.co/J77xPvN/Urgent-Message.png" alt="Image" style="
                    aspect-ratio: 1/1; height: 10vw; width: 12vw;">
                    <br>
                    Your Appointment still needs Verification!
                </h2>
                <br>
                <div style="padding: 5vw;">
                    <p>
                        Dear <span style="font-weight: bold;">'.$name.'</span>,
                    </p>
                    <br><br>
                    <p>
                        PetConnect has successfully received your appointment.
                    </p>
                    <br>
                    <p>
                        Please Click the button below to finish the last step of your booking.
                    </p>
                    <a href="'.$link.'" style="background-color: #f5dfbb;
                    padding: 10px;
                    border-radius: 30px;
                    border: 2px solid #ffb845;
                    text-decoration: none;
                    display: inline-block;
                    color: black;">
                        Verify Appointment
                    </a>
                    <br><br>
                    <p style="font-style: italic; font-size: 0.8rem;">
                        PetConnect values data confidentially. Your information will be only used in appointment purposes.
                    </p>
                    <p style=" font-size: 0.8rem;">
                        You are welcome to ignore this email if you did not book an appointment. You are welcome to message us anytime.
                    </p>
                    <br>
                    <p>
                        Sincerely,
                    </p>
                    <p style="font-weight: bold;">
                        PetConnect
                    </p>
                </div>
            </div>
        </body>
        </html>

        ';
    }
}