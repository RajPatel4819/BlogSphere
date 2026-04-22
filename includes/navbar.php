<nav class="navbar navbar-expand-lg navbar-dark sticky-top">
    <div class="container">
        <a class="navbar-brand" href="index.php"><span>Blog</span>Sphere</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Home</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                        Categories
                    </a>
                    <ul class="dropdown-menu">
                        <?php
                        $cats = $conn->query("SELECT * FROM categories");
                        while($c = $cats->fetch_assoc()) {
                            echo "<li><a class='dropdown-item' href='index.php?category={$c['id']}'>{$c['name']}</a></li>";
                        }
                        ?>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="about.php">About</a>
                </li>
            </ul>
            <div class="d-flex align-items-center">
                <?php if(isset($_SESSION['user_id'])): ?>
                    <div class="dropdown">
                        <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle px-3 py-2 rounded-pill" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);" data-bs-toggle="dropdown">
                            <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px; font-weight: bold; font-size: 0.8rem;">
                                <?php echo strtoupper(substr($_SESSION['username'], 0, 1)); ?>
                            </div>
                            <span class="fw-semibold small me-1"><?php echo $_SESSION['username']; ?></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2 p-2" style="border-radius: 12px; min-width: 200px;">
                            <li><h6 class="dropdown-header text-uppercase small fw-bold mb-1" style="color: #64748b;">Account Management</h6></li>
                            <li><a class="dropdown-item rounded-3 py-2" href="dashboard.php"><i class="fas fa-th-large me-2"></i> Dashboard</a></li>
                            <li><a class="dropdown-item rounded-3 py-2" href="view_posts.php"><i class="fas fa-newspaper me-2"></i> My Stories</a></li>
                            
                            <?php if($_SESSION['role'] == 'admin'): ?>
                                <li><hr class="dropdown-divider"></li>
                                <li><h6 class="dropdown-header text-uppercase small fw-bold mb-1" style="color: #6366f1;">Moderator Panel</h6></li>
                                <li><a class="dropdown-item rounded-3 py-2 text-primary fw-bold" href="admin/index.php"><i class="fas fa-user-shield me-2"></i> Admin Panel</a></li>
                            <?php endif; ?>
                            
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item rounded-3 py-2 text-danger" href="logout.php"><i class="fas fa-sign-out-alt me-2"></i> Logout</a></li>
                        </ul>
                    </div>
                <?php else: ?>
                    <a href="login.php" class="nav-link me-3">Login</a>
                    <a href="register.php" class="btn btn-primary">Join Now</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>
