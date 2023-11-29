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
    <link rel="icon" href="../image/icon.png" type="image/png">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>rePaw City</title>
    <link rel="stylesheet" href="../css/FAQ.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Acme">
    <script src="https://kit.fontawesome.com/98b545cfa6.js" crossorigin="anonymous"></script>
</head>

<body>
    <?php include '../function/navbar.php' ?>
    <section class="home">

        <div class="faq-container">
            <div class="faq-heading">
                <h2 data-translate="Frequently Asked Questions">Frequently Asked Questions</h2>
                <p data-translate="Welcome to the FAQ">Welcome to the FAQ section for our pet shelter! Below are answers to some commonly asked questions.
                    If you have any additional inquiries, please don't hesitate to ask.</p>
            </div>
            <div class="faq-item">
                <h3 data-translate="What is the purpose of rePaw City?">Q: What is the purpose of rePaw City? <i class="fa fa-caret-down"></i></h3>
                <div class="answer">
                    A: rePaw City is dedicated to providing a safe and caring environment for abandoned, neglected, or
                    surrendered pets. Our main goal is to rehabilitate and rehome these animals, ensuring they find
                    loving
                    and permanent homes.
                </div>
            </div>
            <div class="faq-item">
                <h3>Q: How can I adopt a pet from your shelter?<i class="fa fa-caret-down"></i></h3>
                <div class="answer">
                    A: To adopt a pet from our shelter, please book an appointment first or check our website for
                    available
                    animals.
                </div>
            </div>
            <div class="faq-item">
                <h3>Q: Do you have a policy for screening potential adopters?<i class="fa fa-caret-down"></i></h3>
                <div class="answer">
                    A: Yes, we have a screening process to ensure that our animals are placed in suitable and loving
                    homes.
                    The process may involve an application, an interview, reference checks, and sometimes a home visit.
                    We
                    aim to match the needs and personalities of our animals with the lifestyle and capabilities of
                    potential
                    adopters.
                </div>
            </div>
            <div class="faq-item">
                <h3>Q: Can I surrender my pet to your shelter?<i class="fa fa-caret-down"></i></h3>
                <div class="answer">
                    A: Yes, we accept owner surrenders, but we encourage you to contact us in advance to discuss your
                    situation. Surrendering a pet is a serious decision, and we want to ensure we have the necessary
                    resources to accommodate your pet's needs.
                </div>
            </div>
            <div class="faq-item">
                <h3>Q: What happens if a pet is not adopted?<i class="fa fa-caret-down"></i></h3>
                <div class="answer">
                    A: If a pet is not adopted within a reasonable timeframe, we continue to provide them with care and
                    enrichment while actively seeking a suitable home. We do not have a time limit for how long an
                    animal
                    can stay with us. Our priority is finding the best match for each pet, even if it takes longer.
                </div>
            </div>
            <div class="faq-item">
                <h3>Q: Can I volunteer at your shelter?<i class="fa fa-caret-down"></i></h3>
                <div class="answer">
                    A: Yes, we welcome volunteers who are passionate about animal welfare. Volunteers play a crucial
                    role
                    in providing care and socialization to our animals. Please contact our shelter or book an
                    appointment to
                    learn more about our volunteer opportunities and requirements.
                </div>
            </div>
            <div class="faq-item">
                <h3>Q: How can I support your pet shelter if I cannot adopt or volunteer?<i
                        class="fa fa-caret-down"></i></h3>
                <div class="answer">
                    A: There are several ways to support our shelter. You can consider making a monetary donation,
                    donating pet supplies or food, sponsoring a specific animal, or organizing fundraising events.
                    Sharing our
                    social media posts and spreading awareness about our shelter can also make a significant impact.
                </div>
            </div>
            <div class="faq-footer">
                <p>We hope these answers have been helpful. If you have any further questions, feel free to ask.</p>
            </div>
        </div>
    </section>
    <?php include '../function/footer.php' ?>
    <script src="..\script\translation.js"></script>  
</body>

</html>
<script>
    window.addEventListener('DOMContentLoaded', function () {
        var faqItems = document.getElementsByClassName('faq-item');
        for (var i = 0; i < faqItems.length; i++) {
            faqItems[i].addEventListener('click', toggleAnswer);
        }

        function toggleAnswer() {
            var answer = this.querySelector('.answer');
            var isActive = this.classList.contains('active');

            // Close all answers
            for (var i = 0; i < faqItems.length; i++) {
                faqItems[i].classList.remove('active');
                faqItems[i].querySelector('.answer').style.display = 'none';
            }

            if (!isActive) {
                this.classList.add('active');
                answer.style.display = 'block';
            }
        }
    });
</script>