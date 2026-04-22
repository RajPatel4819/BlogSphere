<?php 
include 'includes/db.php'; 

if(!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = (int)$_GET['id'];
$sql = "SELECT posts.*, users.username, users.email as author_email, categories.name as category_name 
        FROM posts 
        JOIN users ON posts.user_id = users.id 
        JOIN categories ON posts.category_id = categories.id 
        WHERE posts.id = $id";
$result = $conn->query($sql);

if($result->num_rows == 0) {
    header("Location: index.php");
    exit();
}

$post = $result->fetch_assoc();

// Restrict published check for non-owners/admins
if($post['status'] != 'published' && (!isset($_SESSION['user_id']) || ($_SESSION['user_id'] != $post['user_id'] && $_SESSION['role'] != 'admin'))) {
    header("Location: index.php?msg=Post not published yet");
    exit();
}

include 'includes/header.php';
include 'includes/navbar.php';
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-9">
            <!-- Breadcrumbs -->
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php" class="text-decoration-none">Home</a></li>
                    <li class="breadcrumb-item active"><?php echo $post['category_name']; ?></li>
                </ol>
            </nav>

            <h1 class="display-4 fw-bold mb-4"><?php echo $post['title']; ?></h1>
            
            <div class="d-flex align-items-center mb-5 pb-4 border-bottom">
                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-3" style="width: 48px; height: 48px; font-weight: bold;">
                    <?php echo strtoupper(substr($post['username'], 0, 1)); ?>
                </div>
                <div>
                    <h6 class="mb-0 fw-bold"><?php echo $post['username']; ?></h6>
                    <p class="text-muted small mb-0"><?php echo date('F d, Y', strtotime($post['created_at'])); ?> • 5 min read</p>
                </div>
                <div class="ms-auto">
                    <?php if(isset($_SESSION['user_id']) && ($_SESSION['user_id'] == $post['user_id'] || $_SESSION['role'] == 'admin')): ?>
                        <a href="edit_post.php?id=<?php echo $post['id']; ?>" class="btn btn-outline-primary btn-sm">Edit Post</a>
                    <?php endif; ?>
                </div>
            </div>

            <?php if($post['image']): ?>
                <img src="<?php echo $post['image']; ?>" class="img-fluid rounded-4 mb-5 shadow" alt="Blog Image" style="width: 100%; max-height: 500px; object-fit: cover;">
            <?php endif; ?>

            <div class="post-content lead" style="line-height: 1.8; color: #334155;">
                <?php echo nl2br($post['content']); ?>
            </div>

            <!-- Author Card -->
            <div class="card bg-light border-0 rounded-4 mt-5 p-4">
                <div class="row align-items-center">
                    <div class="col-md-2 text-center text-md-start">
                        <div class="rounded-circle bg-white shadow-sm d-flex align-items-center justify-content-center mx-auto" style="width: 80px; height: 80px;">
                            <i class="fas fa-user fa-2x text-primary"></i>
                        </div>
                    </div>
                    <div class="col-md-10 mt-3 mt-md-0">
                        <h5 class="fw-bold mb-1">About the Author</h5>
                        <p class="text-muted mb-0"><?php echo $post['username']; ?> is a passionate writer sharing their knowledge and experiences with the community.</p>
                    </div>
                </div>
            </div>
            
            <div class="mt-5 text-center">
                <a href="index.php" class="btn btn-outline-secondary px-5">Back to Feed</a>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
