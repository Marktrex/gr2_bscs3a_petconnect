<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="icon" href="image/icon.png" type="image/png">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>rePaw City</title>
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Acme">
    <script src="https://kit.fontawesome.com/98b545cfa6.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
</head>

<body>
    <div class="container">
        <div class="nav">
            <div class="navbar" id="myNavbar">
                <a href="index.php" class="logo"><img src="./image/logo (1).png" class="img-logo"></a>
                <a href="home.php" class="list a">Home</a>
                <a href="adoptpage.php" class="list">Adopt</a>
                <a href="donatepage.php" class="list">Donate</a>
                <a href="news.php" class="list">News</a>
                <a href="volunteer.php" class="list">Volunteer</a>
                <a href="javascript:void(0);" class="icon" onclick="toggleMenu()">&#9776;</a>
            </div>

            <script>
                function toggleMenu() {
                    var navbar = document.getElementById("myNavbar");
                    if (navbar.className === "navbar") {
                        navbar.className += " responsive";
                    } else {
                        navbar.className = "navbar";
                    }
                }
            </script>

        </div>
        <div class="landingpage">
            <img src="./image/landingtext.png" alt="" class="landingtext">
            <img src="./image/landingfooter.png" alt="" class="landingfooter">
            <img src="./image/landingbg.png" alt="" class="landingbg">
        </div>
    </div>
</body>

</html>