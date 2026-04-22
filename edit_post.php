<?php 
include 'includes/db.php'; 

if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$post_id = (int)$_GET['id'];
$user_id = $_SESSION['user_id'];

// Check ownership
$check = $conn->query("SELECT * FROM posts WHERE id = $post_id AND user_id = $user_id");
if($check->num_rows == 0) {
    header("Location: dashboard.php");
    exit();
}
$post = $check->fetch_assoc();

$error = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_post'])) {
    $title = $conn->real_escape_string($_POST['title']);
    $category_id = (int)$_POST['category_id'];
    $content = $conn->real_escape_string($_POST['content']);
    $status = $_POST['status'];
    $image_url = $conn->real_escape_string($_POST['image_url']);

    // Handle File Upload
    if(!empty($_FILES['image_file']['name'])) {
        $target_dir = "uploads/";
        $filename = time() . "_" . basename($_FILES["image_file"]["name"]);
        $target_file = $target_dir . $filename;
        
        $check = getimagesize($_FILES["image_file"]["tmp_name"]);
        if($check !== false) {
            if (move_uploaded_file($_FILES["image_file"]["tmp_name"], $target_file)) {
                $image_url = $target_file; 
            } else {
                $error = "Error uploading file.";
            }
        } else {
            $error = "File is not an image.";
        }
    }

    if(empty($error)) {
        $sql = "UPDATE posts SET title='$title', category_id='$category_id', content='$content', image='$image_url', status='$status' 
                WHERE id=$post_id";
        
        if ($conn->query($sql)) {
            header("Location: view_posts.php?msg=Post updated successfully");
            exit();
        } else {
            $error = "Error updating post: " . $conn->error;
        }
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
                    <h2 class="fw-bold">Edit Post</h2>
                    <p class="text-muted">Update your story.</p>
                </div>

                <?php if($error): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>

                <form method="POST" action="edit_post.php?id=<?php echo $post_id; ?>" enctype="multipart/form-data">
                    <div class="row mb-4">
                        <div class="col-md-8">
                            <label class="form-label fw-semibold">Post Title</label>
                            <input type="text" name="title" class="form-control" value="<?php echo htmlspecialchars($post['title']); ?>" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Category</label>
                            <select name="category_id" class="form-select" required>
                                <?php 
                                $cats = $conn->query("SELECT * FROM categories");
                                while($c = $cats->fetch_assoc()) {
                                    $sel = $c['id'] == $post['category_id'] ? 'selected' : '';
                                    echo "<option value='{$c['id']}' $sel>{$c['name']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Featured Image URL</label>
                            <input type="url" name="image_url" class="form-control px-3" value="<?php echo htmlspecialchars($post['image']); ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Or Update Image (from PC)</label>
                            <input type="file" name="image_file" class="form-control px-3" accept="image/*">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Content</label>
                        <textarea name="content" class="form-control" rows="10" required><?php echo htmlspecialchars($post['content']); ?></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Status</label>
                        <div class="d-flex gap-4">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" id="draft" value="draft" <?php echo $post['status'] == 'draft' ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="draft">Draft</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" id="published" value="published" <?php echo $post['status'] == 'published' ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="published">Published</label>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-3 mt-5">
                        <button type="submit" name="update_post" class="btn btn-primary px-5 py-2 fw-bold">Update Post</button>
                        <a href="view_posts.php" class="btn btn-outline-secondary px-5 py-2 fw-bold">Back</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
