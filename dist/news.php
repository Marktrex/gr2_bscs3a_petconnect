<?php require './function/config.php' ?>
<?php
session_start(); // Add this line to start the session
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="icon" href="image/icon.png" type="image/png">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>rePaw City</title>
    <link rel="stylesheet" href="css/news.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Acme">
    <script src="https://kit.fontawesome.com/98b545cfa6.js" crossorigin="anonymous"></script>

</head>

<body>
    <?php include './function/navbar.php' ?>

    <section class="home">
        <div class="top">
            <div class="title">
                <h2>BLOGS, LATEST NEWS, AND UPDATES</h2> <br>
            </div>
            <div class="tips">
                <h1>PET CARE TIPS</h1>
                <p>How to Ensure a Happy and Healthy Life for Your New Companion: <br>
                    Discover essential tips for providing optimal care and well- being to your newly adopted pet,
                    including nutrition, exercise, grooming, and more
                </p>
                <br>
                <div class="slideshow-container">
                    <img src=".\image\news\pet-tips.jpg" alt="Image 1">
                    <img src=".\image\news\pet-tips2.jpg" alt="Image 2">
                    <img src=".\image\news\pet-tips3.jpg" alt="Image 3">
                </div>
            </div>
            <div class="news">
                <div class="headline">
                    <?php
                    // Fetch the featured news item from the database
                    $stmt = $conn->prepare("SELECT * FROM news WHERE is_featured = 1");
                    $stmt->execute();
                    $featuredNews = $stmt->fetch(PDO::FETCH_ASSOC);

                    if ($featuredNews) {
                        $image = $featuredNews['image'];
                        $title = $featuredNews['title'];
                        $details = $featuredNews['details'];


                        $maxCharacters = 300; // Maximum number of characters to show
                        if (strlen($title) > 50) {// if the title is too long
                            $maxCharacters = 200; //  Set maximum number of characters to show
                        }
                        // Check the length of the details paragraph
                        if (strlen($details) > $maxCharacters) {
                            $details = substr($details, 0, $maxCharacters) . '...'; // Cut the paragraph and add ellipsis
                        }
                        ?>
                        <a href="news-page.php?news_id=<?php echo $featuredNews['news_id']; ?>" class="headline-link">
                            <div class="img">
                                <img src="./upload/news/<?php echo $image; ?>" alt="Image">
                            </div>
                            <div class="details">
                                <h1>
                                    <?php echo $title; ?>
                                </h1>
                                <p>
                                    <?php echo $details; ?>
                                </p>
                            </div>
                        </a>
                    <?php } else { ?>
                        <div class="img">
                            <img src="#" alt="Image">
                        </div>
                        <div class="details">
                            <h1>No Featured News Available</h1>
                            <p>There is no featured news at the moment. Check back later for updates.</p>
                        </div>
                    <?php } ?>
                </div>


                <div class="card-container latest-news">
                    <div class="news-slider">
                        <?php
                        // Fetch the data from the database and store it in an array
                        // $newsItems = mysqli_query($conn, "SELECT * FROM news ORDER BY date_published DESC");
                        // $newsItems = mysqli_fetch_all($newsItems, MYSQLI_ASSOC);
        
                        $stmt = $conn->prepare("SELECT * FROM news ORDER BY date_published DESC");
                        $stmt->execute();
                        // Fetch the data as an associative array
                        $newsItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        // Loop through the news items and populate the HTML template
                        foreach ($newsItems as $newsItem) {
                            $newsId = $newsItem['news_id'];
                            $image = $newsItem['image'];
                            $title = $newsItem['title'];
                            $details = $newsItem['details'];
                            $date = $newsItem['date_published'];

                            // Set the timezone to Philippines
                            date_default_timezone_set('Asia/Manila');

                            // Get the datetime when the news was posted
                            $newsDatetime = $date;

                            // Get the current datetime
                            $currentDatetime = date('Y-m-d H:i:s');

                            // Calculate the time elapsed
                            $datetime1 = new DateTime($newsDatetime);
                            $datetime2 = new DateTime($currentDatetime);
                            $interval = date_diff($datetime1, $datetime2);

                            $years = $interval->format('%y');
                            $months = $interval->format('%m');
                            $days = $interval->format('%d');
                            $hours = $interval->format('%h');
                            $minutes = $interval->format('%i');

                            $timeElapsed = '';

                            if ($years > 0) {
                                $timeElapsed = ($years > 1) ? $years . ' years ago' : '1 year ago';
                            } elseif ($months > 0) {
                                $timeElapsed = ($months > 1) ? $months . ' months ago' : '1 month ago';
                            } elseif ($days > 0) {
                                $timeElapsed = ($days > 1) ? $days . ' days ago' : '1 day ago';
                            } elseif ($hours > 0) {
                                $timeElapsed = ($hours > 1) ? $hours . ' hours ago' : '1 hour ago';
                            } elseif ($minutes > 0) {
                                $timeElapsed = ($minutes > 1) ? $minutes . ' minutes ago' : '1 minute ago';
                            } else {
                                $timeElapsed = 'Just now';
                            }

                            // Check the length of the details paragraph
                            $maxCharacters = 100; // Maximum number of characters to show
                            if (strlen($details) > $maxCharacters) {
                                $details = substr($details, 0, $maxCharacters) . '...'; // Cut the paragraph and add ellipsis
                            }
                            ?>
                            <a href="news-page.php?news_id=<?php echo $newsId; ?>" class="latest card"
                                style="text-decoration: none; display: inline-block; transition: transform 0.3s; color: black;">
                                <div class="img">
                                    <img src="./upload/news/<?php echo $image; ?>" alt="Image">
                                </div>
                                <div class="details">
                                    <h1>
                                        <?php echo $title; ?>
                                    </h1>
                                    <br>
                                    <p>
                                        <?php echo $details; ?> <span>See more.</span>
                                    </p>
                                </div>
                                <p class="date"><span>
                                        <?php echo $timeElapsed; ?>
                                    </span></p>
                            </a>

                            <?php
                        }
                        ?>
                    </div>
                </div>


            </div>
        </div>
    </section>

    <?php include './function/footer.php' ?>

    <script>
        var slideIndex = 0;
        var slides = document.getElementsByClassName("slideshow-container")[0].getElementsByTagName("img");

        function showSlides() {
            for (var i = 0; i < slides.length; i++) {
                slides[i].style.opacity = 0;
            }

            slideIndex++;
            if (slideIndex > slides.length) {
                slideIndex = 1;
            }

            slides[slideIndex - 1].style.opacity = 1;

            setTimeout(showSlides, 4000); // Delay between slides (2 seconds)
        }
        showSlides();
    </script>
</body>

</html>