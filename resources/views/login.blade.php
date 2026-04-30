<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>

     @vite(['resources/css/app.css','resources/css/login.css','resources/css/sweetalert2.min.css','resources/css/bootstrap.min.css']) 
</head>
<body>

<div class="container min-vh-100 d-flex align-items-center justify-content-center">
    <div class="row design-card shadow-lg w-100" style="max-width: 900px;">

        <!-- Image Section -->
        <div class="col-md-6 image-container d-none d-md-block">
            <img src="storage/uploads/images/web_images/loginpage.jpg" alt="Login Image" class="img-fluid h-100">
        </div>

        <!-- Login Form Section -->
        <div class="col-md-6 content-container">
            <h2 class="title text-center">Welcome Back</h2>
            <p class="description text-center">
                Please login to your account
            </p>

               <form id="loginForm">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Email Address</label>
                    <input type="email" name="username" class="form-control" placeholder="Enter email" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Enter password" required>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="remember">
                        <label class="form-check-label" for="remember">
                            Remember me
                        </label>
                    </div>
                    <a href="#" class="forgot-link">Forgot password?</a>
                </div>

                <button type="submit" class="btn btn-primary w-100 py-2">
                    Login
                </button>

                <p class="text-center mt-3">
                    Don’t have an account?
                    <a href="#" class="register-link">Register</a>
                </p>
            </form>
</div>
   @vite(['resources/js/app.js','resources/js/login.js','resources/js/sweetalert2.all.min.js','resources/js/bootstrap.bundle.min.js']) 
</body>
<script src="storage/libraries/sweetalert2.all.min.js"></script>