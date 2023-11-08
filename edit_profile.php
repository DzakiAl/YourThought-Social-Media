<?php
// Start the session
session_start();

if (!isset($_SESSION['id'])) {
    // Redirect to the login page if the user is not logged in
    header("Location: login.php");
    exit;
}

// Include your database connection code
include("database.php");

$user_id = $_SESSION['id'];

// Fetch the user's current information from the database
$query = "SELECT * FROM user WHERE id = $user_id";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

if (isset($_POST["apply"])) {
    // Handle changes to name, email, and password
    $new_name = filter_var($_POST["name"], FILTER_SANITIZE_STRING);
    $new_email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    $new_password = $_POST["password"]; // Do not hash the password here

    // Build the SQL query dynamically based on which fields are not empty
    $update_query = "UPDATE user SET ";
    $updates = array();

    if (!empty($new_name)) {
        $updates[] = "name = '$new_name'";
    }

    if (!empty($new_email)) {
        $updates[] = "email = '$new_email'";
    }

    if (!empty($new_password)) {
        $new_password = password_hash($new_password, PASSWORD_DEFAULT);
        $updates[] = "password = '$new_password'";
    }

    if (empty($updates)) {
        echo "<script>alert('No fields provided for update.');</script>";
    } else {
        $update_query .= implode(', ', $updates);
        $update_query .= " WHERE id = $user_id";

        if (mysqli_query($conn, $update_query)) {
            echo "<script>alert('User information updated successfully.');</script>";
        } else {
            echo "<script>alert('Error updating user information.');</script>";
        }
    }

    // Check if a new profile picture is uploaded
    if ($_FILES["profile_picture"]["error"] == UPLOAD_ERR_OK) {
        $uploadDir = "pfp/"; // Directory where uploaded files will be stored
        $originalFilename = basename($_FILES["profile_picture"]["name"]);
        $uploadFile = $uploadDir . $originalFilename;
        $fileExtension = pathinfo($uploadFile, PATHINFO_EXTENSION);

        // Check for filename collisions and append a number if necessary
        $counter = 1;
        while (file_exists($uploadFile)) {
            $newFilename = pathinfo($originalFilename, PATHINFO_FILENAME) . '_' . $counter . '.' . $fileExtension;
            $uploadFile = $uploadDir . $newFilename;
            $counter++;
        }

        if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $uploadFile)) {
            // File uploaded successfully, you can save the file path in the database
            $new_profile_picture = $uploadFile;
            $update_profile_picture_query = "UPDATE user SET profile_picture = '$new_profile_picture' WHERE id = $user_id";
            mysqli_query($conn, $update_profile_picture_query);
        } else {
            echo "Error uploading file.";
            exit;
        }
    }
    // Update the user's session with the new information
    $_SESSION['name'] = $new_name;
    $_SESSION['email'] = $new_email;

    // Redirect to the user's profile page or any other desired page
    header("Location: profile.php");
}

if (isset($_POST["cancel"])) {
    header("Location: profile.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit profile</title>
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

        form {
            margin: 15vh 0 0 0;
        }

        .input {
            width: 20vw;
            height: 2vw;
            border: none;
            background-color: transparent;
            border-bottom: 0.2vw solid white;
            color: white;
            margin: 0 0 1vw 0;
            font-size: 1.2vw;
        }

        .button {
            width: 8vw;
            height: 3vw;
            background-color: transparent;
            color: white;
            border: 0.2vw solid white;
            transition: 0.5s all ease-in-out;
            font-size: 1.2vw;
        }

        .button:hover {
            background-color: white;
            color: black;
            transition: 0.5s all ease-in-out;
        }

        .change-pfp {
            margin: 0 0 2vh 0;
        }

        .file-upload {
            margin: 0 0 1vw 6%;
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
                margin: 27vh 0 0 0;
            }

            .title {
                font-size: 6vw;
            }

            .input {
                width: 60vw;
                margin: 0 0 2vw 0;
                height: 5vw;
                font-size: 3vw;
            }

            .button {
                width: 25vw;
                height: 8vw;
                font-size: 3vw;
                border: 0.4vw solid white;
                margin: 2vw 0 1vw 0;
            }

            .change-pfp {
                font-size: 3vw;
                margin: 1vw 0 2vw 0;
            }

            .file-upload {
                margin: 1vw 0 1vw 20%;
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
                margin: 24vh 0 0 0;
            }

            .title {
                font-size: 6vw;
            }

            .input {
                width: 60vw;
                margin: 0 0 2vw 0;
                height: 5vw;
                font-size: 3vw;
            }

            .button {
                width: 25vw;
                height: 8vw;
                font-size: 3vw;
                border: 0.4vw solid white;
                margin: 2vw 0 1vw 0;
            }

            .change-pfp {
                font-size: 3vw;
                margin: 1vw 0 2vw 0;
            }

            .file-upload {
                margin: 1vw 0 1vw 10%;
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
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" align="center"
        enctype="multipart/form-data">
        <h1 class="title">Edit your profile</h1>
        <input class="input" type="text" name="name" placeholder="Change your name"><br>
        <input class="input" type="email" name="email" placeholder="Change your email"><br>
        <input class="input" type="password" name="password" placeholder="Change your password"><br>
        <p class="change-pfp">Change your profile picture</p>
        <input type="file" name="profile_picture" id="profile_picture" class="file-upload"><br>
        <input type="submit" name="apply" value="Apply" class="button">
        <input type="submit" name="cancel" value="Cancel" class="button">
    </form>
</body>
</html>