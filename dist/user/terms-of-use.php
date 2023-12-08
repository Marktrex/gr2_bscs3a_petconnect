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
    <link rel="stylesheet" href="css/terms-of-use.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Acme">
    <script src="https://kit.fontawesome.com/98b545cfa6.js" crossorigin="anonymous"></script>
</head>

<body>
    <?php include './function/navbar.php' ?>
    <section class="home">
        <div class="contact-wrapper">
            <div class="contact-container">
                <div class="contact-heading">
                    <h2>Terms of Use</h2>
                </div>
                <div class="contact-info">
                    <div class="info-heading">
                        <h2>Welcome to rePaw City!</h2>
                    </div>
                    <p>
                        The rePaw City website located at accessible from https://www.repawcity.com. Certain features of
                        the Site may be
                        subject to additional guidelines, terms, or rules, which will be posted on the Site in
                        connection with such features.
                    </p>
                    <p>
                        All such additional terms, guidelines, and rules are incorporated by reference into these Terms.
                    </p>
                    <p>
                        These Terms of Use described the legally binding terms and conditions that oversee your use of
                        the Site. BY
                        LOGGING INTO THE SITE, YOU ARE BEING COMPLIANT THAT THESE TERMS and you represent that you have
                        the
                        authority and capacity to enter into these Terms. YOU SHOULD BE AT LEAST 18 YEARS OF AGE TO
                        ACCESS THE SITE.
                        IF YOU DISAGREE WITH ALL OF THE PROVISION OF THESE TERMS, DO NOT LOG INTO AND/OR USE THE SITE.
                    </p>
                </div>
                <div class="contact-info">
                    <div class="info-heading">
                        <h2>Acceptance of Terms</h2>
                    </div>
                    <p>
                        By accessing or using the Website, you acknowledge that you have read, understood, and agree to
                        be bound by
                        these Terms, as well as our Privacy Policy. If you do not agree to these Terms or the Privacy
                        Policy, please refrain
                        from using the Website.
                    </p>
                </div>
                <div class="contact-info">
                    <div class="info-heading">
                        <h2>Age Restrictions</h2>
                    </div>
                    <p>
                        The Website is intended for use by individuals who are 18 years of age or older. By accessing or
                        using the Website,
                        you represent and warrant that you are at least 18 years old. If you are under the age of 18,
                        please do not use the
                        Website.
                    </p>
                </div>
                <div class="contact-info">
                    <div class="info-heading">
                        <h2>Pet Listings</h2>
                    </div>
                    <ol type="a">
                        <li>The Website may provide information, images, and descriptions of pets available for
                            adoption.</li>
                        <li>You acknowledge that the information provided about the pets is based on the best available
                            knowledge at the
                            time, but rePaw City cannot guarantee the accuracy or completeness of such information.</li>
                        <li>The availability of pets listed on the Website is subject to change without prior notice.
                        </li>
                    </ol>
                </div>
                <div class="contact-info">
                    <div class="info-heading">
                        <h2>User Conduct</h2>
                    </div>
                    <p>When using the Website, you agree to abide by the following rules of conduct:</p>
                    <ol type="a">
                        <li>You will provide accurate and truthful information during the adoption process and any
                            related interactions.</li>
                        <li>You will treat the pets, rePaw City staff, and other users with respect and kindness.</li>
                        <li>You will not use the Website for any unlawful or unauthorized purpose.</li>
                        <li>You will not interfere with or disrupt the functioning of the Website.</li>
                        <li>You will not attempt to gain unauthorized access to any portion of the Website or any
                            related systems or
                            networks.</li>
                        <li>You will not engage in any activity that could damage, disable, overburden, or impair the
                            Website or its servers.</li>
                        <li>You will not engage in any form of harassment or abusive behavior towards other users or
                            rePaw City staff.</li>
                        <li>You will not upload or distribute any content that is defamatory, obscene, or infringing on
                            intellectual property
                            rights.</li>
                    </ol>
                </div>
                <div class="contact-info">
                    <div class="info-heading">
                        <h2>Third-Party Links</h2>
                    </div>
                    <p>The Website may contain links to third-party websites or resources. These links are provided for
                        your convenience,
                        and rePaw City does not endorse or have any control over the content, or services offered by
                        these third-party
                        websites. You acknowledge and agree that rePaw City is not responsible or liable for any damages
                        or losses arising
                        from your use of any third-party websites.</p>

                </div>
                <div class="contact-info">
                    <div class="info-heading">
                        <h2>Disclaimer of Warranties</h2>
                    </div>
                    <p>The Website and its content, including pet listings, are provided on an "as is" and "as available" basis, without
warranties of any kind, either express or implied. rePaw City does not warrant that the Website will be error-free or
uninterrupted, or that any defects will be corrected.</p>

                </div>
            </div>

        </div>

    </section>

    <?php include './function/footer.php' ?>
    <?php require_once "..\components\call_across_pages.php"?>
</body>

</html>