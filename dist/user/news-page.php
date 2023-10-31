<?php require './function/config.php' ?>
<?php
session_start(); // Add this line to start the session

// Retrieve the news content based on the news ID (replace 'YOUR_DB_TABLE_NAME' with the actual table name)
$newsId = $_GET['news_id']; // Assuming the news ID is passed through the URL parameter
$sql = "SELECT * FROM news WHERE news_id = $newsId";
$result = $conn->prepare($sql);

// Check if the query was successful
if ($result->execute()) {
    // Fetch the data from the query result
    $newsItem = $result->fetch(PDO::FETCH_ASSOC);

    // Retrieve the desired data fields
    $title = $newsItem['title'];
    $date = $newsItem['date_published'];
    $content = $newsItem['details'];
    $image = $newsItem['image'];

    // Close the database connection
    $conn = null;
} else {
    // Handle the case when the query fails
    echo "Failed to retrieve news content.";
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="icon" href="image/icon.png" type="image/png">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>rePaw City</title>
    <link rel="stylesheet" href="css/news-page.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Acme">
    <script src="https://kit.fontawesome.com/98b545cfa6.js" crossorigin="anonymous"></script>
</head>

<body>
    <?php include './function/navbar.php' ?>
    <section class="home">
        <div class="news-wrapper">
            <div class="news-container">
                <div class="news-heading">
                    <h1>
                        <?php echo $title; ?>
                    </h1>
                    <p class="published">Published:
                        <?php echo date('F d, Y', strtotime($date)); ?>
                    </p>
                    <div class="social-icons" style="text-align: left; margin-top: 10px; margin-right: 10px">
                        <a href="#"><img src="./image/social media/fb-icon.png" alt="Facebook" style="width: 30px;"></a>
                        <a href="#"><img src="./image/social media/ig-icon.png" alt="Instagram"
                                style="width: 30px;"></a>
                        <a href="#"><img src="./image/social media/tiktok-icon.png" alt="TikTok"
                                style="width: 30px;"></a>
                    </div>
                </div>

                <div class="news-info">
                    <div class="img" style="margin: 0 auto; text-align: center;">
                        <img src="./upload/news/<?php echo $image; ?>" alt="Image">
                    </div>
                    <p style=" white-space: pre-line;">
                        <?php echo $content; ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include './function/footer.php' ?>


    <script>
        window.addEventListener('DOMContentLoaded', () => {
            const homeSection = document.querySelector('.home');
            const newsWrapper = document.querySelector('.news-wrapper');

            // Set the height of the home section based on the news wrapper's height
            homeSection.style.height = `${newsWrapper.offsetHeight}px`;
        });
    </script>
</body>

</html>