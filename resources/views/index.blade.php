<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>DevTrack System</title>


    {{-- Laravel Vite --}}    
    @vite(['resources/css/bootstrap.min.css'])

<!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"> -->

<style>
body {
    background: #f4f6f9;
}

/* NAVBAR LOGO */
.logo {
    width: 40px;
    height: 40px;
    object-fit: cover;
    margin-right: 10px;
    border-radius:50%;
}

/* HERO */
.hero {
    /* background: linear-gradient(135deg, #0d6efd, #6610f2); */
    background: linear-gradient(#0d6efd, #9587aa);
    color: white;
    padding: 70px 15px;
    text-align: center;
}

.hero-logo {
    width:10rem;
    /* max-width: 40%; */
    margin-bottom: 20px;
    height:10rem;
    border-radius:50%;

    object-fit: cover;
}

.hero h1 {
    font-size: 2.5rem;
    font-weight: bold;
}

.hero p {
    font-size: 1.1rem;
}

/* FEATURES */
.feature-card {
    border: none;
    border-radius: 15px;
    transition: 0.3s;
    height: 100%;
}

.feature-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.1);
}

/* BUTTONS */
.btn-custom {
    padding: 10px 20px;
    border-radius: 25px;
}

/* MOBILE FIX */
@media (max-width: 576px) {
    .hero h1 {
        font-size: 1.8rem;
    }

    .hero p {
        font-size: 1rem;
    }
}
</style>
</head>

<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
<div class="container">

    <!-- LOGO + BRAND -->
    <a class="navbar-brand d-flex align-items-center" href="#">
        <img src="storage/uploads/images/web_images/FullLogo.png" class="logo" alt="logo">
        <span class="fw-bold">DevTrack</span>
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="nav">

        <ul class="navbar-nav ms-auto text-center text-lg-start">

            <li class="nav-item">
                <a class="nav-link" href="#">Home</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="#features">Features</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="#about">About</a>
            </li>

            <li class="nav-item mt-2 mt-lg-0 ms-lg-2">
                <a class="btn btn-primary btn-custom w-100 w-lg-auto" href="{{ route('login') }}">Login</a>
            </li>

            <!-- <li class="nav-item mt-2 mt-lg-0 ms-lg-2">
                <a class="btn btn-outline-light btn-custom w-100 w-lg-auto" href="register.php">Register</a>
            </li> -->

        </ul>

    </div>
</div>
</nav>

<!-- HERO -->
<section class="hero">

    <img src="storage/uploads/images/web_images/FullLogo.png" class="hero-logo" alt="logo">

    <h1>Software Development Tracking System</h1>
    <p>Manage, track, and monitor software projects from request to delivery.</p>

    <a href="register.php" class="btn btn-light btn-lg btn-custom mt-3">Get Started</a>
    <a href="login" class="btn btn-outline-light btn-lg btn-custom mt-3" target="_blank">Login</a>
</section>

<!-- FEATURES -->
<section id="features" class="py-5">
<div class="container">
<h2 class="text-center mb-5">System Features</h2>

<div class="row g-4">

<div class="col-md-4">
<div class="card feature-card p-4 text-center">
<h5>Project Request</h5>
<p>Clients submit software requests easily.</p>
</div>
</div>

<div class="col-md-4">
<div class="card feature-card p-4 text-center">
<h5>Progress Tracking</h5>
<p>Track project stages in real time.</p>
</div>
</div>

<div class="col-md-4">
<div class="card feature-card p-4 text-center">
<h5>Admin Dashboard</h5>
<p>Manage users, projects, and analytics.</p>
</div>
</div>

<div class="col-md-4">
<div class="card feature-card p-4 text-center">
<h5>Task Assignment</h5>
<p>Assign tasks to developers.</p>
</div>
</div>

<div class="col-md-4">
<div class="card feature-card p-4 text-center">
<h5>Notifications</h5>
<p>Get instant updates on projects.</p>
</div>
</div>

<div class="col-md-4">
<div class="card feature-card p-4 text-center">
<h5>Reports</h5>
<p>Generate system reports easily.</p>
</div>
</div>

</div>
</div>
</section>

<!-- ABOUT -->
<section id="about" class="py-5 bg-light">
<div class="container text-center">
<h2>About the System</h2>
<p class="mt-3">
DevTrack is a modern system for tracking software development lifecycle from request to delivery.
</p>
</div>
</section>

<!-- FOOTER -->
<footer class="bg-dark text-white text-center p-3">
&copy; 2026 DevTrack System
</footer>

  {{-- Laravel Vite --}}    
@vite(['resources/js/bootstrap.bundle.min.js'])
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> -->

</body>
</html>