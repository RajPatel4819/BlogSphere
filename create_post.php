<?php 
include 'includes/db.php'; 

if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$error = "";
$success = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['create_post'])) {
    $title = $conn->real_escape_string($_POST['title']);
    $category_id = (int)$_POST['category_id'];
    $content = $conn->real_escape_string($_POST['content']);
    $status = $_POST['status'];
    $user_id = $_SESSION['user_id'];
    $image_url = $conn->real_escape_string($_POST['image_url']);

    $sql = "INSERT INTO posts (user_id, category_id, title, content, image, status) 
            VALUES ('$user_id', '$category_id', '$title', '$content', '$image_url', '$status')";
    
    if ($conn->query($sql)) {
        header("Location: dashboard.php?msg=Post created successfully");
        exit();
    } else {
        $error = "Error adding post: " . $conn->error;
    }
}

include 'includes/header.php';
include 'includes/navbar.php';
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-9">
            <div class="card border-0 shadow-lg p-5">
                <div class="mb-4">
                    <h2 class="fw-bold">Create New Post</h2>
                    <p class="text-muted">Share your thoughts with the community.</p>
                </div>

                <?php if($error): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>

                <form method="POST" action="create_post.php">
                    <div class="row mb-4">
                        <div class="col-md-8">
                            <label class="form-label fw-semibold">Post Title</label>
                            <input type="text" name="title" class="form-control" placeholder="Enter a catchy title" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Category</label>
                            <select name="category_id" class="form-select" required>
                                <option value="">Select Category</option>
                                <?php 
                                $cats = $conn->query("SELECT * FROM categories");
                                while($c = $cats->fetch_assoc()) echo "<option value='{$c['id']}'>{$c['name']}</option>";
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Featured Image URL</label>
                        <input type="url" name="image_url" class="form-control" placeholder="https://example.com/image.jpg (Optional)">
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Content</label>
                        <textarea name="content" class="form-control" rows="10" placeholder="Write your story here..." required></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Status</label>
                        <div class="d-flex gap-4">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" id="draft" value="draft" checked>
                                <label class="form-check-label" for="draft">Save as Draft</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" id="published" value="published">
                                <label class="form-check-label" for="published">Publish Now</label>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-3 mt-5">
                        <button type="submit" name="create_post" class="btn btn-primary px-5 py-2 fw-bold">Save Post</button>
                        <a href="dashboard.php" class="btn btn-outline-secondary px-5 py-2 fw-bold">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
