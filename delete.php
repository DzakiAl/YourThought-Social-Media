<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: register.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Get the post ID to delete from the URL
    $post_id = $_GET['id']; // Validate and sanitize this input

    include("database.php");

    // Perform the deletion in the database
    $sql = "DELETE FROM posts WHERE id_thought = ? AND id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $post_id, $_SESSION['id']);

    if ($stmt->execute()) {
        // Post deleted successfully
    } else {
        // Handle the deletion error
        echo "Error deleting post: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();

    // Redirect back to the user's profile or show a success message
    header('Location: profile.php');
}
?>
