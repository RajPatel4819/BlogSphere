<?php 
include 'includes/db.php'; 

if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if(isset($_GET['id'])) {
    $post_id = (int)$_GET['id'];
    $user_id = $_SESSION['user_id'];

    // Check ownership or admin role
    $check = $conn->query("SELECT * FROM posts WHERE id = $post_id AND (user_id = $user_id OR '{$_SESSION['role']}' = 'admin')");
    
    if($check->num_rows > 0) {
        $conn->query("DELETE FROM posts WHERE id = $post_id");
        header("Location: dashboard.php?msg=Post deleted successfully");
    } else {
        header("Location: dashboard.php?err=Action unauthorized");
    }
} else {
    header("Location: dashboard.php");
}
exit();
?>
