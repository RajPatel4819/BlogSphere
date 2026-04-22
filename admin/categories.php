<?php 
include '../includes/db.php'; 

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: ../index.php");
    exit();
}

$error = "";
$success = "";

// Add Category
if(isset($_POST['add_category'])) {
    $name = $conn->real_escape_string($_POST['category_name']);
    if(!empty($name)) {
        $conn->query("INSERT INTO categories (name) VALUES ('$name')");
        $success = "Category added successfully!";
    }
}

// Delete Category
if(isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $conn->query("DELETE FROM categories WHERE id = $id");
    header("Location: categories.php?msg=Deleted");
    exit();
}

include '../includes/header.php';
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand fw-bold" href="index.php">Admin Panel</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="index.php">Dashboard</a></li>
                <li class="nav-item"><a class="nav-link active" href="categories.php">Categories</a></li>
                <li class="nav-item"><a class="nav-link" href="../index.php">Website</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container py-5">
    <div class="row">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm p-4">
                <h5 class="fw-bold mb-4">Add New Category</h5>
                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label">Category Name</label>
                        <input type="text" name="category_name" class="form-control" placeholder="e.g. Fashion, Sports" required>
                    </div>
                    <button type="submit" name="add_category" class="btn btn-primary w-100">Add Category</button>
                </form>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card border-0 shadow-sm p-4">
                <h5 class="fw-bold mb-4">Existing Categories</h5>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Created At</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $res = $conn->query("SELECT * FROM categories ORDER BY id DESC");
                        while($row = $res->fetch_assoc()) {
                            echo "<tr>
                                <td>{$row['id']}</td>
                                <td><span class='fw-bold'>{$row['name']}</span></td>
                                <td class='small text-muted'>{$row['created_at']}</td>
                                <td class='text-end'>
                                    <a href='categories.php?delete={$row['id']}' class='text-danger' onclick='return confirm(\"Are you sure?\")'><i class='fas fa-trash'></i></a>
                                </td>
                            </tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
