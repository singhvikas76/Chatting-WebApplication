<?php
session_start();
$conn = new mysqli("localhost", "root", "", "chat_app");

// Get users for dropdown
$result = $conn->query("SELECT id, username FROM users WHERE id != {$_SESSION['user_id']}");
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Chat - Dewi Bootstrap Template</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap"
    rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet">

  <style>
    .chat-card {
      background: rgba(0, 0, 0, 0.6);
      backdrop-filter: blur(15px);
      border-radius: 16px;
      color: #fff;
      padding: 30px;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
      width: 100%;
      max-width: 800px;
    }
    .chat-card input,
    .chat-card select {
      background: rgba(255, 255, 255, 0.1);
      border: none;
      color: white;
    }
    .chat-card input::placeholder {
      color: #ccc;
    }
    .chat-card button {
      background: #28a745;
      border: none;
    }
    .chat-card button:hover {
      background: #218838;
    }
    #chat-box {
      max-height: 400px;
      overflow-y: auto;
      margin-top: 20px;
      background: rgba(255, 255, 255, 0.05);
      padding: 15px;
      border-radius: 8px;
    }
    #chat-box p {
      margin-bottom: 10px;
    }
    select {
    background-color: #222; /* dark background */
    color: #fff;            /* white text */
    border: 1px solid #555;
    padding: 8px;
    border-radius: 5px;
    width: 100%;
    margin-bottom: 10px;
}

select option {
    background-color: #333;
    color: #fff;
}

  </style>
</head>

<body class="index-page">

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
      <a class="cta-btn" href="logout.php">Logout</a>
    </div>
  </header>

  <main class="main">
    <section id="hero" class="hero section dark-background d-flex align-items-center justify-content-center">
      <img src="assets/img/hero-bg.jpg" alt="" class="position-absolute w-100 h-100" style="object-fit: cover; z-index: -1;">
      <div class="container d-flex flex-column align-items-center">
        <div class="chat-card mt-5">
          <h3 class="mb-4">Welcome, <?= $_SESSION["username"] ?></h3>

          <form method="POST" action="send_message.php" class="row g-2">
            <div class="col-md-4">
              <select name="receiver_id" class="form-select">
                <?php while ($row = $result->fetch_assoc()): ?>
                  <option value="<?= $row['id'] ?>"><?= htmlspecialchars($row['username']) ?></option>
                <?php endwhile; ?>
              </select>
            </div>
            <div class="col-md-6">
              <input name="message" type="text" class="form-control" placeholder="Type message..." required>
            </div>
            <div class="col-md-2">
              <button type="submit" class="btn btn-success w-100">Send</button>
            </div>
          </form>

          <h4 class="mt-4">Messages</h4>
          <div id="chat-box">
            <?php
            $messages = $conn->query("
                SELECT u.username AS sender, m.message, m.timestamp
                FROM messages m
                JOIN users u ON m.sender_id = u.id
                WHERE m.sender_id = {$_SESSION['user_id']} OR m.receiver_id = {$_SESSION['user_id']}
                ORDER BY m.timestamp DESC
            ");
            while ($msg = $messages->fetch_assoc()):
            ?>
              <p><b><?= htmlspecialchars($msg['sender']) ?>:</b> <?= htmlspecialchars($msg['message']) ?> <small class="text-muted float-end" style="font-size:12px;"><?= $msg['timestamp'] ?></small></p>
            <?php endwhile; ?>
          </div>
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
