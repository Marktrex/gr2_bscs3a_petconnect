<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Successfully Changed</title>
    <link rel="stylesheet" href="../css/newlyAdded/sent.css">
    <link rel="stylesheet" href="..\css\colorStyle\user\sent-colors.css">
</head>
<body>
    <div class="container">
        <div class="item icon">
            <img src="../icons/laptop_740418.png" alt="envelope-icon">
        </div>

        <div class="item content">
        <h1>Password Successfully Changed!</h1>
        <p>
            Go back to the login page and use your new password.
        </p>
        <form action="../function/authentication/logout.php" method="post">
            <button type="submit" class="btn btn-verify">Go Back</button>
        </form>
        </div>
        </div>
    <?php require_once "../components/light-switch.php";?>
    <script src="../script/change-color-schema.js"></script>
</body>
</html>
