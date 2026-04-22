<?php 
include 'includes/db.php'; 

if(isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}

$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $username = $conn->real_escape_string($_POST['username']);
    $password = $_POST['password'];

    $result = $conn->query("SELECT * FROM users WHERE username='$username' OR email='$username'");
    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            
            if ($user['role'] == 'admin') {
                header("Location: admin/index.php");
            } else {
                header("Location: dashboard.php");
            }
            exit();
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "User not found.";
    }
}

include 'includes/header.php';
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow-lg p-4">
                <div class="text-center mb-4">
                    <h2 class="fw-bold">Welcome Back</h2>
                    <p class="text-muted">Sign in to continue your writing journey.</p>
                </div>

                <?php if($error): ?>
                    <div class="alert alert-danger text-center"><?php echo $error; ?></div>
                <?php endif; ?>

                <form method="POST" action="login.php">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Username or Email</label>
                        <input type="text" name="username" class="form-control px-3" placeholder="Enter username or email" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-semibold d-flex justify-content-between">
                            Password
                            <a href="#" class="small text-decoration-none fw-normal">Forgot?</a>
                        </label>
                        <input type="password" name="password" class="form-control px-3" placeholder="••••••••" required>
                    </div>
                    <button type="submit" name="login" class="btn btn-primary w-100 py-2 fw-bold">Log In</button>
                    <div class="text-center mt-4 text-muted">
                        Don't have an account? <a href="register.php" class="text-decoration-none fw-bold">Sign Up</a>
                    </div>
                </form>
            </div>
            
            <div class="mt-4 p-3 bg-light rounded text-center small text-muted">
                <strong>Demo Admin:</strong> admin / password <br>
                <strong>Demo User:</strong> raj / password
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
