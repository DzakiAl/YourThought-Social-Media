<?php
include("database.php");
session_start();

if (!empty($_SESSION["id"])) {
    $id = $_SESSION["id"];
    $result = mysqli_query($conn, "SELECT * FROM user WHERE id = $id");
    $row = mysqli_fetch_assoc($result);
} else {
    header("Location: register.php");
}

// Fetch and display posts by the user
$user_id = $_SESSION['id'];
$sql = "SELECT posts.id_thought, posts.thought, posts.created_at, posts.media, user.name, user.profile_picture
        FROM posts
        JOIN user ON posts.id = user.id
        WHERE posts.id = ?
        ORDER BY posts.created_at DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
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

        .profile_container {
            width: 60vw;
            margin-left: 20%;
        }

        .pfp {
            width: 14vw;
            height: 14vw;
            border-radius: 50%;
        }

        .name {
            margin-top: 8%;
            font-size: 3.5vw;
        }

        .add_post {
            color: white;
            text-decoration: none;
            position: relative;
            font-size: 1.3vw;
        }

        .add_post::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 0.15vw;
            background-color: white;
            transition: width 0.3s;
        }

        .add_post:hover::before {
            width: 100%;
        }

        .edit_profile {
            color: white;
            text-decoration: none;
            position: relative;
            font-size: 1.3vw;
            margin: 0 0 0 1vw;
        }

        .edit_profile::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 0.15vw;
            background-color: white;
            transition: width 0.3s;
        }

        .edit_profile:hover::before {
            width: 100%;
        }

        .logout {
            color: white;
            text-decoration: none;
            position: relative;
            font-size: 1.3vw;
            margin: 0 0 0 1vw;
        }

        .logout::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 0.15vw;
            background-color: white;
            transition: width 0.3s;
        }

        .logout:hover::before {
            width: 100%;
        }

        .post_word {
            text-align: center;
            font-size: 2vw;
            border-bottom: 0.2vw solid white;
        }

        .container {
            background-color: transparent;
            width: 100%;
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

        .pfp-page {
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

        .add_bar {
            width: 63.2%;
            height: 3vw;
            font-size: 1.5vw;
            background-color: transparent;
            border: none;
            border-bottom: 0.2vw solid white;
            color: white;
            margin: 1vw 0 4vw 0;
        }

        .send_button {
            background-color: white;
            color: black;
            width: 6.5vw;
            height: 2vw;
            transition: 0.5s ease;
            border-radius: 5vw;
            line-height: 1.5vw;
            box-shadow: none;
            border: none;
            font-size: 1.2vw;
        }

        .send_button:hover {
            background-color: gray;
            transition: all ease-in-out 0.5s;
        }

        .delete-menu {
            margin: 0 0 0 2vw;
        }

        .delete-menu a {
            color: white;
            text-decoration: none;
            position: relative;
            font-size: 1.3vw;
        }

        .delete-menu a::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 0.15vw;
            background-color: white;
            transition: width 0.3s;
        }

        .delete-menu a:hover::before {
            width: 100%;
        }

        .date {
            margin: 0 0 0 1vw;
            font-size: 1.1vw;
            opacity: 50%;
        }

        .post {
            width: 60vw;
            height: 28.2vw;
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

            .profile_container {
                margin: 0 0 0 10%;
                width: 80%;
            }

            .pfp {
                width: 25vw;
                height: 25vw;
            }

            .name {
                margin: 2vw 0 2vw 0;
                font-size: 7vw;
            }

            .add_post {
                font-size: 3vw;
            }

            .edit_profile {
                font-size: 3vw;
            }

            .logout {
                font-size: 3vw;
            }

            .post_word {
                font-size: 4vw;
                margin: 2vw 0 2vw 0;
            }

            .add_bar {
                width: 52.5%;
                height: 5vw;
                font-size: 3vw;
            }

            .send_button {
                width: 15vw;
                height: 4vw;
                font-size: 2.4vw;
            }

            .file-upload {
                width: 5%;
            }

            .container {
                width: 100%;
                margin: 0 0 5vw 0;
            }

            .pfp-page {
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

            .delete-menu p {
                margin: 1vw 0 1vw 0;
            }

            .delete-menu p a {
                font-size: 2.5vw;
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

            .profile_container {
                margin: 0 0 0 10%;
                width: 80%;
            }

            .pfp {
                width: 25vw;
                height: 25vw;
            }

            .name {
                margin: 2vw 0 2vw 0;
                font-size: 7vw;
            }

            .edit_profile {
                font-size: 3vw;
            }

            .logout {
                font-size: 3vw;
            }

            .post_word {
                font-size: 4vw;
                margin: 2vw 0 2vw 0;
            }

            .add_bar {
                width: 52.5%;
                height: 5vw;
                font-size: 3vw;
            }

            .send_button {
                width: 15vw;
                height: 4vw;
                font-size: 2.4vw;
            }

            .file-upload {
                width: 20vw;
                height: 5vw;
            }

            .container {
                width: 100%;
                margin: 0 0 5vw 0;
            }

            .pfp-page {
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

            .delete-menu p {
                margin: 1vw 0 1vw 0;
            }

            .delete-menu p a {
                font-size: 2.5vw;
            }

            .add_post {
                font-size: 3vw;
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
    <div class="profile_container">
        <div class="pfpNname">
            <img class="pfp" src="<?php echo $row["profile_picture"]; ?>">
            <h1 class="name">
                <?php echo $row["name"]; ?>
            </h1>
            <a class="add_post" href="add_post.php">Add post</a>
            <a class="edit_profile" href="edit_profile.php">Edit Profile</a>
            <a class="logout" href="logout.php">Logout</a>
        </div>
        <p class="post_word">Thought</p>
        <?php
        while ($row = $result->fetch_assoc()) {
            ?>
            <div class="centering">
                <div class="container">
                    <div class="profile">
                        <img src="<?php echo $row['profile_picture']; ?>" alt="" class="pfp-page">
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
                    <div class="delete-menu">
                        <p><a href="delete.php?id=<?php echo $row['id_thought']; ?>">Delete</a></p>
                    </div>
                </div>
            </div>
            <?php
        }
        $result->close();
        ?>
    </div>
</body>
</html>