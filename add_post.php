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

// Post
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["thought"])) {
    $user_id = $_SESSION["id"]; // Use the session user ID
    $thought = $_POST["thought"];
    $post_media = null; // Initialize $post_media

    if ($_FILES["media_file"]["error"] == UPLOAD_ERR_OK) {
        $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'video/mp4'];
        if (in_array($_FILES["media_file"]["type"], $allowedTypes)) {
            $uploadDir = "post_media/"; // Directory where uploaded files will be stored
            $originalFilename = basename($_FILES["media_file"]["name"]);

            // Check for filename collisions and append a number if necessary
            $uploadFile = $uploadDir . $originalFilename;
            $fileExtension = pathinfo($uploadFile, PATHINFO_EXTENSION);
            $counter = 1;

            while (file_exists($uploadFile)) {
                $newFilename = pathinfo($originalFilename, PATHINFO_FILENAME) . '_' . $counter . '.' . $fileExtension;
                $uploadFile = $uploadDir . $newFilename;
                $counter++;
            }

            if (move_uploaded_file($_FILES["media_file"]["tmp_name"], $uploadFile)) {
                // File uploaded successfully, you can save the file path in the database
                $post_media = $uploadFile;
            } else {
                echo "Error uploading file.";
                exit;
            }
        } else {
            echo "<script>alert('Invalid file type. Only image files (JPEG, JPG, PNG, GIF) are allowed.'); window.location.href = 'profile.php';</script>";
            exit;
        }
    }

    // Insert the post into the "post" table
    $sql = "INSERT INTO posts (id, thought, media) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        // If no media is uploaded, set $post_media to an empty string
        if ($post_media === null) {
            $post_media = '';
        }

        $stmt->bind_param("iss", $user_id, $thought, $post_media);

        if ($stmt->execute()) {
            header("Location: profile.php");
            exit; // Add this to stop the script execution after the header redirect
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error preparing the statement: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add post</title>
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
            font-size: 1.2vw;
        }

        .menu a {
            color: white;
            text-decoration: none;
            margin: 0 0.5vw 0 0.5vw;
            position: relative;
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

        form {
            margin: 25vh 0 0 0;
        }

        .title {
            font-size: 2.5vw;
        }

        .field {
            width: 35vw;
            height: 2vw;
            border: none;
            background-color: transparent;
            border-bottom: 0.2vw solid white;
            color: white;
            margin: 0 0 1vw 0;
            font-size: 1.2vw;
        }

        .submit {
            width: 8vw;
            height: 3vw;
            background-color: transparent;
            color: white;
            border: 0.2vw solid white;
            transition: 0.5s all ease-in-out;
            font-size: 1.2vw;
            margin: 1vw 0 1vw 0;
        }

        .submit:hover {
            background-color: white;
            color: black;
            transition: 0.5s all ease-in-out;
        }

        .cancel {
            display: block;
            width: 8vw;
            height: 2.6vw;
            background-color: transparent;
            color: white;
            border: 0.2vw solid white;
            transition: 0.5s all ease-in-out;
            font-size: 1.2vw;
            margin: 1vw 0 1vw 1vw;
            text-decoration: none;
            line-height: 2.6vw;
        }

        .cancel:hover {
            background-color: white;
            color: black;
            transition: 0.5s all ease-in-out;
        }

        .inline {
            display: flex;
            justify-content: center;
        }

        .file-upload {
            margin-left: 6%;
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

            form {
                margin: 30vh 0 0 0;
            }

            .title {
                font-size: 6vw;
            }

            .field {
                width: 60vw;
                margin: 0 0 2vw 0;
                height: 5vw;
                font-size: 3vw;
            }

            .submit {
                width: 25vw;
                height: 8vw;
                font-size: 3vw;
                border: 0.4vw solid white;
                margin: 2vw 0 1vw 0;
            }

            .cancel {
                width: 25vw;
                height: 7.3vw;
                font-size: 3vw;
                border: 0.4vw solid white;
                margin: 2vw 0 1vw 1vw;
                line-height: 7.3vw; 
            }

            .file-upload {
                width: 50%;
                margin-left: 5%;
            }
        }

        @media (orientation: portrait) and (max-width: 1024px) and (min-width: 480px) {
            nav {
                height: 8vh;
            }

            nav h1 {
                font-size: 5vw;
                margin: 0 0 0 2vw;
            }

            .menu {
                margin: 0 0 0 2vw;
            }

            .menu a {
                font-size: 2.5vw;
            }

            form {
                margin: 29vh 0 0 0;
            }

            .title {
                font-size: 6vw;
            }

            .field {
                width: 60vw;
                margin: 0 0 2vw 0;
                height: 5vw;
                font-size: 3vw;
            }

            .submit {
                width: 20vw;
                height: 6vw;
                font-size: 2.5vw;
                border: 0.4vw solid white;
                margin: 2vw 0 1vw 0;
            }

            .cancel {
                width: 20vw;
                height: 5.3vw;
                font-size: 2.5vw;
                border: 0.4vw solid white;
                margin: 2vw 0 1vw 1vw;
                line-height: 5.3vw; 
            }

            .file-upload {
                width: 50%;
                margin-left: 29%;
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
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" align="center" enctype="multipart/form-data">
        <h1 class="title">Add post</h1>
        <input class="field" type="text" placeholder="What's on your mind?" name="thought"><br>
        <input type="file" class="file-upload" name="media_file"><br>
        <div class="inline">
            <input class="submit" type="submit" name="add" value="Post">
            <a href="profile.php" class="cancel">Cancel</a>
        </div>
    </form>
</body>
</html>