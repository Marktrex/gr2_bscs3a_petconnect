<?php
session_start();
require '../function/config.php';

// print_r($_SESSION);
if (isset($_SESSION['auth_user']) && $_SESSION['auth_user']['role'] === "1") { 
    header("Location: ../admin/admin-dashboard.php");
    exit();
}
if (!isset($_SESSION['auth_user'])) { 
  echo '<script language="javascript">';
  echo 'alert("You do not have access to this page");';
  echo '</script>';
  header("Location: ../loginpage.php");
  exit();
} ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="icon" href="image/icon.png" type="image/png">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>rePaw City</title>
    <link rel="stylesheet" href="css/privacy-policy.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Acme">
    <script src="https://kit.fontawesome.com/98b545cfa6.js" crossorigin="anonymous"></script>
</head>

<body>
    <?php include './function/navbar.php' ?>
    <section class="home">
        <div class="contact-wrapper">
            <div class="contact-container">
                <div class="contact-heading">
                    <h2>Privacy Policy</h2>
                </div>
                <div class="contact-info">
                    <div class="info-heading">
                        <h2>Introduction</h2>
                    </div>
                    <p>
                        rePawCity respects your privacy and is committed to complying with this privacy policy (“Privacy
                        Policy”), which describes what information we collect about you, including how we collect it,
                        how we use it, with whom we may share it and what choices you have regarding our use of your
                        information. This Privacy Policy applies to information collected on our Site,
                        www.repawcity.com, (the “Site”), whether accessed via computer, mobile device or other
                        technology or any associated content, material, or functionality contained on the Site (the
                        “Services”). If you make a donation to the rePawCity, the terms of our Donor Privacy Policy will
                        also apply to you. We encourage you to become familiar with the terms and conditions of this
                        Privacy Policy and the Donor Privacy Policy if it applies to you. By accessing and using the
                        Site,
                        or any part thereof, you acknowledge that you have read and understand this Privacy Policy.
                    </p>
                    <p>For the purposes of applicable data protection laws, rePawCity is the controller of the
                        information you provide to us. As a controller, we process information in accordance with this
                        Privacy Policy.</p>
                </div>
                <div class="contact-info">
                    <div class="info-heading">
                        <h2>Information We Collect</h2>
                    </div>
                    <ul>
                        <li>Personal Information: We may collect personal information such as your name, address, email
                            address, phone number, and other relevant details when you voluntarily provide them to us
                            through
                            our website, forms, or communication channels.
                        </li>
                        <li>
                            Non-Personal Information: We may automatically collect non-personal information such as your
                            IP
                            address, browser type, operating system, referring website, and pages visited on our site.
                            This
                            information is collected to analyze trends, administer the site, track user engagement, and
                            gather
                            demographic information.
                        </li>
                    </ul>
                </div>
                <div class="contact-info">
                    <div class="info-heading">
                        <h2>Use of Information</h2>
                    </div>
                    <p>We may use the collected information for the following purposes:</p>
                    <ul>
                        <li>To respond to your inquiries, requests, or comments.</li>
                        <li>To process adoption applications or other services you may request.</li>
                        <li>To improve our website, services, and user experience.</li>
                        <li>To send periodic emails or newsletters with updates, promotions, or other information
                            related to
                            our shelter.</li>
                        <li>To analyze data, monitor website usage, and measure the effectiveness of our marketing
                            campaigns.</li>
                    </ul>
                </div>
                <div class="contact-info">
                    <div class="info-heading">
                        <h2>Sharing of Information</h2>
                    </div>
                    <p>We may share your personal information with:</p>
                    <ul>
                        <li>Third-party service providers: We may engage trusted third-party service providers to assist
                            us in
                            operating our website, conducting our business, or providing services on our behalf. These
                            service
                            providers have access to your personal information only to perform specific tasks and are
                            obligated
                            to maintain its confidentiality.</li>
                        <li>Legal requirements: We may disclose your information if required by law, court order, or
                            governmental authority.</li>
                        <li>- Consent: We may share your information with your consent or as otherwise described at the
                            time
                            of collection.</li>
                    </ul>
                </div>
                <div class="contact-info">
                    <div class="info-heading">
                        <h2>Data Security</h2>
                    </div>
                    <p>We implement reasonable security measures to protect your personal information from unauthorized
                        access, alteration, disclosure, or destruction. However, please be aware that no method of
                        transmission over the internet or electronic storage is 100% secure.</p>

                </div>
                <div class="contact-info">
                    <div class="info-heading">
                        <h2>Third-Party Links</h2>
                    </div>
                    <p>Our website may contain links to third-party websites or services. We are not responsible for the
                        privacy practices or content of such websites. We encourage you to review the privacy policies
                        of
                        those websites before providing any personal information.</p>

                </div>
                <div class="contact-info">
                    <div class="info-heading">
                        <h2>Updates to this Privacy Policy</h2>
                    </div>
                    <p>We reserve the right to update this Privacy Policy from time to time. We will notify you of any
                        significant changes by posting the updated policy on our website.</p>

                </div>
                <div class="contact-info">
                    <div class="info-heading">
                        <h2>Contact Us</h2>
                    </div>
                    <p>If you have any questions, concerns, or requests regarding this Privacy Policy or our data
                        practices,
                        please contact us at +63 923 4897 632.
                    </p>
                </div>
            </div>

        </div>

    </section>

    <?php include './function/footer.php' ?>

</body>

</html>