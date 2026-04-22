<?php 
include 'includes/db.php'; 

if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$total_posts = $conn->query("SELECT COUNT(*) as count FROM posts WHERE user_id = $user_id")->fetch_assoc()['count'];
$published_posts = $conn->query("SELECT COUNT(*) as count FROM posts WHERE user_id = $user_id AND status = 'published'")->fetch_assoc()['count'];
$draft_posts = $conn->query("SELECT COUNT(*) as count FROM posts WHERE user_id = $user_id AND status = 'draft'")->fetch_assoc()['count'];

include 'includes/header.php';
include 'includes/navbar.php';
?>

<div class="container py-5">
    <div class="row mb-5 align-items-center">
        <div class="col-8">
            <h1 class="fw-bold mb-0">Hello, <?php echo $_SESSION['username']; ?>! 👋</h1>
            <p class="text-muted">Welcome back to your creator dashboard.</p>
        </div>
        <div class="col-4 text-end">
            <a href="create_post.php" class="btn btn-primary px-4 py-2 fw-bold">
                <i class="fas fa-plus me-2"></i> Create New Post
            </a>
        </div>
    </div>

    <!-- Stats Section -->
    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="card p-4 border-0 shadow-sm" style="background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%); color: #fff;">
                <h6 class="text-white-50 text-uppercase mb-3 small fw-bold">Total Stories</h6>
                <h2 class="fw-bold mb-0"><?php echo $total_posts; ?></h2>
                <i class="fas fa-newspaper position-absolute bottom-0 end-0 p-4 opacity-20 fa-3x"></i>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-4 border-0 shadow-sm">
                <h6 class="text-muted text-uppercase mb-3 small fw-bold">Published</h6>
                <h2 class="fw-bold mb-0"><?php echo $published_posts; ?></h2>
                <i class="fas fa-check-circle position-absolute bottom-0 end-0 p-4 opacity-10 fa-3x text-success"></i>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-4 border-0 shadow-sm">
                <h6 class="text-muted text-uppercase mb-3 small fw-bold">Drafts</h6>
                <h2 class="fw-bold mb-0"><?php echo $draft_posts; ?></h2>
                <i class="fas fa-edit position-absolute bottom-0 end-0 p-4 opacity-10 fa-3x text-warning"></i>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold m-0">Recent Activities</h5>
                    <a href="view_posts.php" class="btn btn-link text-decoration-none fw-bold small">Manage All Posts</a>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="bg-light">
                            <tr>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $recent_sql = "SELECT posts.*, categories.name as category_name 
                                           FROM posts 
                                           JOIN categories ON posts.category_id = categories.id 
                                           WHERE user_id = $user_id 
                                           ORDER BY created_at DESC LIMIT 5";
                            $result = $conn->query($recent_sql);
                            if($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    $status_class = $row['status'] == 'published' ? 'bg-success' : 'bg-warning text-dark';
                                    echo "<tr>
                                        <td><span class='fw-semibold'>{$row['title']}</span></td>
                                        <td>{$row['category_name']}</td>
                                        <td><span class='badge $status_class'>".ucfirst($row['status'])."</span></td>
                                        <td class='text-muted small'>".date('M d, Y', strtotime($row['created_at']))."</td>
                                        <td class='text-end'>
                                            <a href='edit_post.php?id={$row['id']}' class='btn btn-sm btn-outline-primary border-0'><i class='fas fa-edit'></i></a>
                                            <a href='delete_post.php?id={$row['id']}' class='btn btn-sm btn-outline-danger border-0' onclick='return confirm(\"Are you sure?\")'><i class='fas fa-trash'></i></a>
                                        </td>
                                    </tr>";
                                }
                            } else {
                                echo "<tr><td colspan='5' class='text-center py-4 text-muted'>You haven't written anything yet.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
