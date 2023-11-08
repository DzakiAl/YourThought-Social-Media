<?php
include("database.php");
session_start(); // Initialize sessions

if (isset($_POST["login"])) {
    // Sanitize and validate the input
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    $password = $_POST["password"];

    $result = mysqli_query($conn, "SELECT * FROM user WHERE email = '$email'");
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $hashedPassword = $row["password"];

        if (password_verify($password, $hashedPassword)) {
            // Passwords match
            $_SESSION["login"] = true;
            $_SESSION["id"] = $row["id"];
            header("Location: index.php");
            exit; // Ensure the script stops here to avoid further execution
        } else {
            echo "<script> alert('Password is incorrect'); </script>";
        }
    } else {
        echo "<script> alert('User is not registered yet'); </script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" align="center">
        <h1 class="title">Login Page</h1>
        <input class="field" type="text" name="email" placeholder="Enter your email"><br>
        <input class="field" type="password" name="password" placeholder="Enter your password"><br>
        <input class="submit" type="submit" name="login" value="Login"><br>
        <a href="register.php" class="register">Register now</a>
    </form>
</body>
</html>