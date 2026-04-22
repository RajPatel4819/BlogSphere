<?php include 'includes/db.php'; ?>
<?php include 'includes/header.php'; ?>
<?php include 'includes/navbar.php'; ?>

<div class="container py-5 mt-5">
    <div class="row justify-content-center">
        <div class="col-md-9">
            <h1 class="display-3 fw-bold mb-4">About <span>BlogSphere</span></h1>
            <p class="lead mb-5 text-muted" style="line-height: 1.8;">BlogSphere is a modern blogging platform designed for storytellers, thinkers, and creators. Our mission is to provide a seamless and beautiful experience for sharing ideas and discovering new perspectives.</p>

            <div class="row g-4 mt-4">
                <div class="col-md-6">
                    <div class="card p-4 border-0 shadow-sm h-100">
                        <i class="fas fa-pen-nib fa-2x text-primary mb-3"></i>
                        <h4 class="fw-bold">For Writers</h4>
                        <p class="text-muted">A distraction-free environment to write and manage your posts. Whether it's technology, lifestyle, or travel, your voice matters here.</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card p-4 border-0 shadow-sm h-100">
                        <i class="fas fa-book-open fa-2x text-success mb-3"></i>
                        <h4 class="fw-bold">For Readers</h4>
                        <p class="text-muted">Explore a diverse range of topics and categories. Our platform is built to make reading an enjoyable and immersive experience.</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card p-4 border-0 shadow-sm h-100">
                        <i class="fas fa-microchip fa-2x text-info mb-3"></i>
                        <h4 class="fw-bold">Modern Tech</h4>
                        <p class="text-muted">Built with the latest web technologies like PHP, MySQL, and Bootstrap 5 to ensure speed, security, and responsiveness.</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card p-4 border-0 shadow-sm h-100">
                        <i class="fas fa-users fa-2x text-warning mb-3"></i>
                        <h4 class="fw-bold">Our Community</h4>
                        <p class="text-muted">Join thousands of other creators who share their journey every day on BlogSphere. Your story starts here.</p>
                    </div>
                </div>
            </div>

            <div class="mt-5 pt-5 text-center border-top">
                <h3 class="fw-bold mb-3">Ready to share your story?</h3>
                <a href="register.php" class="btn btn-primary px-5 py-3 rounded-pill fw-bold">Get Started for Free</a>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
