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

//find user
if (isset($_GET["search"])) {
    $searchedUsername = $_GET["search-user"];

    // Query the database for users with a similar username
    $sql = "SELECT * FROM user WHERE name LIKE ?";
    $stmt = $conn->prepare($sql);
    $searchedUsername = '%' . $searchedUsername . '%';
    $stmt->bind_param("s", $searchedUsername);
    $stmt->execute();
    $result = $stmt->get_result();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search</title>
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

        .search_container {
            display: flex;
            justify-content: center;
        }

        .search_bar {
            width: 90%;
            background-color: transparent;
            border: none;
            border-bottom: 0.2vw solid white;
            color: white;
            margin-right: 0.5vw;
        }

        .search_button {
            background-color: white;
            color: black;
            width: 6.5vw;
            height: 2vw;
            transition: 0.5s ease;
            border-radius: 5vw;
            line-height: 1.5vw;
            box-shadow: none;
            border: none;
        }

        .search_button:hover {
            background-color: gray;
            transition: all ease-in-out 0.5s;
        }

        .container {
            width: 97%;
            display: flex;
            align-items: center;
            margin: 1vw 0 1vw 1.5vw;
        }

        .name {
            font-size: 1.5vw;
            margin-left: 1vw;
        }

        .img {
            width: 5vw;
            height: 5vw;
            border-radius: 100%;
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

            .search_bar {
                width: 80%;
                height: 5vw;
                font-size: 3vw;
            }

            .search_button {
                width: 15vw;
                height: 4vw;
                font-size: 2.4vw;
            }

            .center-vertical {
                display: flex;
                align-items: center;
            }

            .container {
                margin: 3vw 0 3vw 2.1vw;
            }

            .name {
                font-size: 4vw;
                margin-left: 2vw;
            }

            .img {
                width: 12vw;
                height: 12vw;
                border-radius: 100%;
            }

            .center {
                display: flex;
                justify-content: center;
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

            .search_bar {
                width: 80%;
                height: 5vw;
                font-size: 3vw;
            }

            .search_button {
                width: 15vw;
                height: 4vw;
                font-size: 2.4vw;
            }

            .center-vertical {
                display: flex;
                align-items: center;
            }

            .container {
                margin: 2vw 0 2vw 2.1vw;
            }

            .name {
                font-size: 3vw;
                margin-left: 2vw;
            }

            .img {
                width: 10vw;
                height: 10vw;
                border-radius: 100%;
            }

            .center {
                display: flex;
                justify-content: center;
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
    <form action="" class="search_container" method="">
        <input class="search_bar" type="text" placeholder="Search a user" name="search-user">
        <div class="center-vertical">
            <input class="search_button" type="submit" value="Search" name="search">
        </div>
    </form>
    <?php while ($row = $result->fetch_assoc()) { ?>
        <div class="container">
            <img src="<?php echo $row["profile_picture"] ?>" alt="" class="img">
            <p class="name">
                <?php echo $row["name"] ?>
            </p>
        </div>
        <?php
    }
    ?>
</body>
</html>