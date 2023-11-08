<?php
include("database.php");
session_start();

if (!empty($_SESSION["id"])) {
    $id = $_SESSION["id"];
} else {
    header("Location: register.php");
}

// SQL query to fetch posts with user information
$sql = "SELECT posts.id_thought, user.name, user.profile_picture, posts.thought, posts.created_at, posts.media 
        FROM posts
        JOIN user ON posts.id = user.id
        ORDER BY posts.created_at DESC";

$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YouThought Social Media</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: black;
            color: white;
            font-family: Arial, Helvetica, sans-serif;
        }

        nav {
            display: flex;
            background-color: transparent;
            width: 100%;
            height: 15vh;
        }

        nav h1 {
            display: flex;
            align-items: center;
            font-size: 3vw;
            margin: 0 0 0 1vw;
        }

        .menu {
            display: flex;
            align-items: center;
            margin: 0 0 0 1.5vw;
        }

        .menu a {
            color: white;
            text-decoration: none;
            margin: 0 0.5vw 0 0.5vw;
            position: relative;
            font-size: 1.2vw;
        }

        .menu a::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 0.15vw;
            background-color: white;
            transition: width 0.3s;
        }

        .menu a:hover::before {
            width: 100%;
        }

        .container {
            background-color: transparent;
            width: 65%;
            height: auto;
            border-radius: 0.5vw;
            box-shadow: 0 0 1vw gray;
            margin-bottom: 2vw;
        }

        .profile {
            display: flex;
            align-items: center;
            padding: 1vw 0 0 1vw;
        }

        .pfp {
            width: 5vw;
            height: 5vw;
            border-radius: 100%;
        }

        .username {
            margin: 0 0 0 1vw;
            font-size: 1.5vw;
        }

        .thought {
            margin: 2vw;
            font-size: 1.3vw;
        }

        .centering {
            display: flex;
            justify-content: center;
        }

        .date {
            margin: 0 0 0 1vw;
            font-size: 1.1vw;
            opacity: 50%;
        }

        .post {
            width: 65vw;
            height: 30vw;
        }

        .content_of_the_post {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        @media (orientation: portrait) and (max-width: 480px) {
            nav {
                height: 8vh;
            }

            nav h1 {
                font-size: 5vw;
                margin: 0 0 0 3vw;
            }

            .menu {
                margin: 0 0 0 2vw;
            }

            .menu a {
                font-size: 2.5vw;
            }

            .container {
                width: 80%;
                margin: 0 0 5vw 0;
            }

            .pfp {
                width: 10vw;
                height: 10vw;
            }

            .username {
                font-size: 2.5vw;
            }

            .date {
                font-size: 1.5vw;
            }

            .thought {
                font-size: 2.5vw;
            }

            .post {
                width: 80vw;
                height: 45vw;
            }
        }

        @media (orientation: portrait) and (max-width: 1024px) and (min-width: 480px) {
            nav {
                height: 9vh;
            }

            nav h1 {
                font-size: 5.5vw;
            }

            .menu {
                margin: 0 0 0 2vw;
            }

            .menu a {
                font-size: 2.5vw;
            }
            
            .container {
                width: 80%;
                margin: 0 0 5vw 0;
            }

            .pfp {
                width: 10vw;
                height: 10vw;
            }

            .username {
                font-size: 2.5vw;
            }

            .date {
                font-size: 1.5vw;
            }

            .thought {
                font-size: 2.5vw;
            }

            .post {
                width: 80vw;
                height: 45vw;
            }   
        }
    </style>
</head>
<body>
    <nav>
        <h1>YourThought</h1>
        <div class="menu">
            <a href="index.php">Home</a>
            <a href="search.php">Search</a>
            <a href="profile.php">Profile</a>
        </div>
    </nav>
    <div class="content">
        <?php
        while ($row = mysqli_fetch_assoc($result)) {
            ?>
            <div class="centering">
                <div class="container">
                    <div class="profile">
                        <img src="<?php echo $row['profile_picture']; ?>" alt="" class="pfp">
                        <p class="username">
                            <?php echo $row['name']; ?>
                        </p>
                        <p class="date">
                            <?php echo $row['created_at']; ?>
                        </p>
                    </div>
                    <div class="thought">
                        <?php echo $row['thought']; ?>
                    </div>
                    <?php if (!empty($row['media'])) { ?>
                        <div class="post">
                            <?php
                            // Check the media type (e.g., image or video) and display it accordingly
                            $mediaPath = $row['media'];
                            $mediaType = pathinfo($mediaPath, PATHINFO_EXTENSION);

                            if (in_array($mediaType, ['jpg', 'jpeg', 'png', 'gif'])) {
                                // Display an image
                                echo "<img src='$mediaPath' alt='Media' class='content_of_the_post'>";
                            } elseif ($mediaType === 'mp4') {
                                // Display a video
                                echo "<video controls class='content_of_the_post'><source src='$mediaPath' type='video/mp4' ></video>";
                            }
                            ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
</body>
</html>