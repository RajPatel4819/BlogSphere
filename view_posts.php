<?php 
include 'includes/db.php'; 

if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$where = "WHERE user_id = $user_id";
if(isset($_GET['search'])) {
    $s = $conn->real_escape_string($_GET['search']);
    $where .= " AND title LIKE '%$s%'";
}

include 'includes/header.php';
include 'includes/navbar.php';
?>

<div class="container py-5">
    <div class="row mb-5 align-items-center">
        <div class="col-md-6">
            <h1 class="fw-bold mb-0">Manage My Posts</h1>
            <p class="text-muted">A complete list of all your stories on BlogSphere.</p>
        </div>
        <div class="col-md-6 text-end d-flex justify-content-end gap-3 align-items-center">
            <form action="view_posts.php" method="GET" class="d-flex bg-white rounded border p-1" style="max-width: 300px;">
                <input type="text" name="search" class="form-control border-0 bg-transparent" placeholder="Search my posts..." value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
                <button type="submit" class="btn btn-primary btn-sm rounded"><i class="fas fa-search"></i></button>
            </form>
            <a href="create_post.php" class="btn btn-primary px-4 py-2 fw-bold">New Post</a>
        </div>
    </div>

    <div class="card border-0 shadow-sm p-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="bg-light">
                    <tr>
                        <th style="width: 100px;">Image</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Status</th>
                        <th>Created At</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT posts.*, categories.name as category_name 
                            FROM posts 
                            JOIN categories ON posts.category_id = categories.id 
                            $where 
                            ORDER BY created_at DESC";
                    $result = $conn->query($sql);
                    if($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            $status_class = $row['status'] == 'published' ? 'bg-success' : 'bg-warning text-dark';
                            $img = $row['image'] ? $row['image'] : 'https://images.unsplash.com/photo-1499750310107-5fef28a66643?w=200&h=120&fit=crop';
                            echo "<tr>
                                <td><img src='$img' class='rounded' style='width: 80px; height: 50px; object-fit: cover;'></td>
                                <td><span class='fw-semibold'>{$row['title']}</span></td>
                                <td>{$row['category_name']}</td>
                                <td><span class='badge $status_class'>".ucfirst($row['status'])."</span></td>
                                <td>".date('d M Y', strtotime($row['created_at']))."</td>
                                <td class='text-end'>
                                    <a href='post_details.php?id={$row['id']}' class='btn btn-sm btn-outline-info border-0' title='View'><i class='fas fa-eye'></i></a>
                                    <a href='edit_post.php?id={$row['id']}' class='btn btn-sm btn-outline-primary border-0' title='Edit'><i class='fas fa-edit'></i></a>
                                    <a href='delete_post.php?id={$row['id']}' class='btn btn-sm btn-outline-danger border-0' onclick='return confirm(\"Permanently delete this post?\")' title='Delete'><i class='fas fa-trash'></i></a>
                                </td>
                            </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6' class='text-center py-5'>No posts found. <a href='create_post.php'>Create one now</a></td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
