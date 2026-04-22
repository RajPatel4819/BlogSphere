<?php include 'includes/db.php'; ?>
<?php include 'includes/header.php'; ?>
<?php include 'includes/navbar.php'; ?>

<!-- Hero Section -->
<section class="hero-section py-5 bg-dark text-white text-center position-relative overflow-hidden" style="min-height: 400px; display: flex; align-items: center;">
    <div class="container position-relative z-1">
        <h1 class="display-3 fw-bold mb-3">Your Journey Starts <span>Here</span></h1>
        <p class="lead mb-4 text-gray" style="color: #cbd5e1; max-width: 700px; margin: 0 auto;">Discover the latest stories, insights, and inspirations from our global community of writers. Share your voice with the world.</p>
        <div class="search-container max-width-600 mx-auto mt-5">
            <form action="index.php" method="GET" class="d-flex shadow-lg rounded-pill p-1 bg-white">
                <input type="text" name="search" class="form-control border-0 rounded-pill px-4" placeholder="Search for stories, categories..." value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
                <button type="submit" class="btn btn-primary rounded-pill px-4">Search</button>
            </form>
        </div>
    </div>
    <div class="position-absolute top-0 start-0 w-100 h-100 opacity-20" style="background: radial-gradient(circle at 50% 50%, var(--primary-color) 0%, transparent 70%);"></div>
</section>

<!-- Blog Posts Section -->
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <h2 class="fw-bold m-0">Latest Stories</h2>
        <div class="dropdown">
            <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                Filter by Category
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="index.php">All</a></li>
                <?php
                $cat_res = $conn->query("SELECT * FROM categories");
                while($cat = $cat_res->fetch_assoc()) {
                    echo "<li><a class='dropdown-item' href='index.php?category={$cat['id']}'>{$cat['name']}</a></li>";
                }
                ?>
            </ul>
        </div>
    </div>

    <div class="row g-4">
        <?php
        $where = "WHERE status = 'published'";
        if(isset($_GET['search'])) {
            $s = $conn->real_escape_string($_GET['search']);
            $where .= " AND (title LIKE '%$s%' OR content LIKE '%$s%')";
        }
        if(isset($_GET['category'])) {
            $cat_id = (int)$_GET['category'];
            $where .= " AND category_id = $cat_id";
        }

        $sql = "SELECT posts.*, users.username, categories.name as category_name 
                FROM posts 
                JOIN users ON posts.user_id = users.id 
                JOIN categories ON posts.category_id = categories.id 
                $where 
                ORDER BY created_at DESC";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                ?>
                <div class="col-md-4">
                    <div class="card h-100">
                        <img src="<?php echo $row['image'] ? $row['image'] : 'https://images.unsplash.com/photo-1499750310107-5fef28a66643?w=800&auto=format&fit=crop&q=60'; ?>" class="card-img-top" alt="Blog Image" style="height: 200px; object-fit: cover;">
                        <div class="card-body p-4">
                            <span class="badge bg-primary-subtle text-primary mb-2"><?php echo $row['category_name']; ?></span>
                            <h5 class="card-title fw-bold mb-3"><?php echo $row['title']; ?></h5>
                            <p class="card-text text-muted mb-4"><?php echo substr(strip_tags($row['content']), 0, 100) . '...'; ?></p>
                            <div class="d-flex align-items-center justify-content-between mt-auto">
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle bg-light d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px;">
                                        <i class="fas fa-user text-muted small"></i>
                                    </div>
                                    <span class="small text-muted"><?php echo $row['username']; ?></span>
                                </div>
                                <a href="post_details.php?id=<?php echo $row['id']; ?>" class="btn btn-link text-decoration-none p-0 fw-bold">Read More</a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
        } else {
            echo "<div class='col-12 text-center py-5'><h4 class='text-muted'>No stories found matching your criteria.</h4></div>";
        }
        ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
