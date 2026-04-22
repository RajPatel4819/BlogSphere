<?php 
include '../includes/db.php'; 

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: ../index.php");
    exit();
}

// Stats
$total_users = $conn->query("SELECT COUNT(*) as count FROM users")->fetch_assoc()['count'];
$total_posts = $conn->query("SELECT COUNT(*) as count FROM posts")->fetch_assoc()['count'];
$total_cats = $conn->query("SELECT COUNT(*) as count FROM categories")->fetch_assoc()['count'];

include '../includes/header.php';
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand fw-bold" href="index.php">Admin Panel</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link active" href="index.php">Dashboard</a></li>
                <li class="nav-item"><a class="nav-link" href="../index.php">Go to Website</a></li>
            </ul>
            <div class="navbar-nav">
                <a class="nav-link" href="../logout.php">Logout</a>
            </div>
        </div>
    </div>
</nav>

<div class="container py-5">
    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="card p-4 border-0 shadow-sm bg-primary text-white">
                <h6>Total Users</h6>
                <h2><?php echo $total_users; ?></h2>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-4 border-0 shadow-sm bg-success text-white">
                <h6>Total Posts</h6>
                <h2><?php echo $total_posts; ?></h2>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-4 border-0 shadow-sm bg-info text-white">
                <h6>Categories</h6>
                <h2><?php echo $total_cats; ?></h2>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm p-4">
                <h5 class="fw-bold mb-4">All Stories</h5>
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $posts = $conn->query("SELECT posts.*, users.username FROM posts JOIN users ON posts.user_id = users.id ORDER BY created_at DESC");
                        while($p = $posts->fetch_assoc()) {
                            echo "<tr>
                                <td>{$p['title']}</td>
                                <td>{$p['username']}</td>
                                <td>{$p['status']}</td>
                                <td>
                                    <a href='../delete_post.php?id={$p['id']}' class='text-danger' onclick='return confirm(\"Delete?\")'><i class='fas fa-trash'></i></a>
                                </td>
                            </tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm p-4">
                <h5 class="fw-bold mb-4">Users</h5>
                <ul class="list-group list-group-flush">
                    <?php
                    $users = $conn->query("SELECT * FROM users LIMIT 10");
                    while($u = $users->fetch_assoc()) {
                        echo "<li class='list-group-item d-flex justify-content-between'>
                            <span>{$u['username']}</span>
                            <span class='badge bg-light text-dark'>{$u['role']}</span>
                        </li>";
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
