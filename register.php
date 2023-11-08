<?php
include("database.php");

if (isset($_POST["register"])) {
    // Sanitize and validate the input
    $name = filter_var($_POST["name"], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    $password = $_POST["password"];

    if (empty($password)) {
        echo "<script>alert('Password is empty'); window.location.href = 'register.php';</script>";
    } else {
        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Check if email is already in the database
        $duplicateStmt = $conn->prepare("SELECT * FROM user WHERE email = ? OR name = ?");
        $duplicateStmt->bind_param("ss", $email, $name); // Bind both email and name
        $duplicateStmt->execute();
        $duplicateResult = $duplicateStmt->get_result();

        if ($duplicateResult->num_rows > 0) {
            echo "<script>alert('Email or name already taken!'); window.location.href = 'register.php';</script>";

        } else {
            // Handle file upload (profile picture)
            if ($_FILES["profile_picture"]["error"] == UPLOAD_ERR_OK) {
                $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
                if (in_array($_FILES["profile_picture"]["type"], $allowedTypes)) {
                    $uploadDir = "pfp/"; // Directory where uploaded files will be stored
                    $originalFilename = basename($_FILES["profile_picture"]["name"]);

                    // Check for filename collisions and append a number if necessary
                    $uploadFile = $uploadDir . $originalFilename;
                    $fileExtension = pathinfo($uploadFile, PATHINFO_EXTENSION);
                    $counter = 1;

                    while (file_exists($uploadFile)) {
                        $newFilename = pathinfo($originalFilename, PATHINFO_FILENAME) . '_' . $counter . '.' . $fileExtension;
                        $uploadFile = $uploadDir . $newFilename;
                        $counter++;
                    }

                    if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $uploadFile)) {
                        // File uploaded successfully, you can save the file path in the database
                        $profilePicture = $uploadFile;
                    } else {
                        echo "Error uploading file.";
                        exit;
                    }
                } else {
                    echo "<script>alert('Invalid file type. Only image files (JPEG, JPG, PNG, GIF) are allowed.'); window.location.href = 'register.php';</script>";
                    exit;
                }
            } else {
                echo "<script>alert('No profile picture uploaded. Please upload a profile picture.'); window.location.href = 'register.php';</script>";
                exit;
            }

            // Use a prepared statement to insert user data into the database
            $query = "INSERT INTO user (name, email, password, profile_picture) VALUES (?, ?, ?, ?)";
            $insertStmt = $conn->prepare($query);
            $insertStmt->bind_param("ssss", $name, $email, $hashedPassword, $profilePicture);

            if ($insertStmt->execute()) {
                header("Location: login.php");
            } else {
                echo "Error inserting user data: " . $insertStmt->error;
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
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
            margin: 18vh 0 0 0;
        }

        .title {
            font-size: 2.5vw;
        }

        .field {
            width: 20vw;
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

        .file-upload {
            margin-left: 6%;
        }

        .register {
            color: white;
            text-decoration: none;
            position: relative;
        }

        .register::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 0.15vw;
            background-color: white;
            transition: width 0.3s;
        }

        .register:hover::before {
            width: 100%;
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
                margin: 25vh 0 0 0;
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

            .file-upload {
                width: 50%;
                margin-left: 5%;
            }

            .submit {
                width: 25vw;
                height: 8vw;
                font-size: 3vw;
                border: 0.4vw solid white;
                margin: 2vw 0 1vw 0;
            }

            .register {
                font-size: 3vw;
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
                margin: 25vh 0 0 0;
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

            .file-upload {
                width: 50%;
                margin-left: 32.5%;
            }

            .submit {
                width: 25vw;
                height: 8vw;
                font-size: 3vw;
                border: 0.4vw solid white;
                margin: 2vw 0 1vw 0;
            }

            .register {
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
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" align="center"
        enctype="multipart/form-data">
        <h1 class="title">Register</h1>
        <input class="field" type="text" name="name" placeholder="Enter your name"><br>
        <input class="field" type="email" name="email" placeholder="Enter your email"><br>
        <input class="field" type="password" name="password" placeholder="Enter your password"><br>
        <input type="file" name="profile_picture" id="profile_picture" class="file-upload"><br>
        <input class="submit" type="submit" name="register" value="Register"><br>
        <a href="login.php" class="register">Login if you have account</a>
    </form>
</body>
</html>