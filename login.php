<?php
session_start();
$conn = new mysqli("localhost", "root", "", "chat_app");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST["username"];
  $password = $_POST["password"];

  $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
  $stmt->bind_param("s", $username);
  $stmt->execute();

  $stmt->bind_result($id, $hashed_password);
  $stmt->fetch();

  if (password_verify($password, $hashed_password)) {
    $_SESSION["user_id"] = $id;
    $_SESSION["username"] = $username;
    header("Location: chat.php");
    exit;
  } else {
    $error = "Invalid username or password.";
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Login - Dewi Bootstrap Template</title>
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto&family=Raleway&family=Inter&display=swap" rel="stylesheet">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link href="assets/css/main.css" rel="stylesheet">
  <style>
    .dark-background {
      background-color: #0e0e0e;
      color: white;
    }
    .card.glass-effect {
      background: rgba(0, 0, 0, 0.5);
      backdrop-filter: blur(15px);
      -webkit-backdrop-filter: blur(15px);
      border: 1px solid rgba(255, 255, 255, 0.1);
      border-radius: 15px;
      color: white;
    }
    .card.glass-effect .form-control {
      background-color: rgba(255, 255, 255, 0.05);
      color: white;
      border: 1px solid rgba(255, 255, 255, 0.2);
    }
    .card.glass-effect .form-control:focus {
      background-color: rgba(255, 255, 255, 0.1);
      color: white;
      border-color: rgba(255, 255, 255, 0.4);
      box-shadow: none;
    }
    .card.glass-effect ::placeholder {
      color: rgba(255, 255, 255, 0.6);
    }
  </style>
</head>

<body class="index-page dark-background">
  <header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center">
      <a href="index.php" class="logo d-flex align-items-center me-auto">
        <h1 class="sitename">iChat</h1>
      </a>
      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="index.php" class="active">Home</a></li>
          <li><a href="#">About</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>
      <a class="cta-btn" href="index.php#about">Get Started</a>
    </div>
  </header>

  <main class="main">
    <section id="hero" class="hero section dark-background">
      <img src="assets/img/hero-bg.jpg" alt="" data-aos="fade-in">
      <div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
        <div class="card glass-effect p-4 shadow" style="width: 100%; max-width: 400px;">
          <h3 class="text-center mb-4">Login</h3>
          <form method="POST" action="" class="needs-validation" novalidate>
            <div class="form-group mb-3">
              <label for="username">Username</label>
              <input name="username" type="text" class="form-control" placeholder="Enter username" required>
            </div>
            <div class="form-group mb-3">
              <label for="password">Password</label>
              <input name="password" type="password" class="form-control" placeholder="Enter password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
            <?php if (!empty($error)): ?>
              <div class="alert alert-danger mt-3 mb-0 py-2 text-center">
                <?= $error ?>
              </div>
            <?php endif; ?>
          </form>
        </div>
      </div>
    </section>
  </main>

  <?php
    include_once 'footer.php';
  ?>

  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
  <div id="preloader"></div>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets/js/main.js"></script>
</body>

</html>