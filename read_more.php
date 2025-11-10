<?php 
include 'config.php'; 

// Fetch all posts
$statement = $pdo->prepare("SELECT * FROM `post` ORDER BY post_id DESC");
$statement->execute();
$posts = $statement->fetchAll();

// Add comment
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_comment'])) {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $comment = trim($_POST['comment']);
    $post_id = intval($_POST['post_id']); // important for foreign key

    if ($name && $email && $comment && $post_id) {
        $stmt = $pdo->prepare("INSERT INTO `comments`(`post_id`, `comments_username`, `comment_useremail`, `comments_content`) VALUES (?, ?, ?, ?)");
        $stmt->execute([$post_id, $name, $email, $comment]);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Looma Blog | Read More</title>

  <!-- Bootstrap + FontAwesome -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

  <style>
    :root {
      --bg: #ffffff;
      --text: #1b1b1b;
      --card-bg: #f9f9f9;
      --nav-bg: rgba(255, 255, 255, 0.8);
      --accent: #007bff;
    }
    body.dark {
      --bg: #0b0f1a;
      --text: #e4e6eb;
      --card-bg: #151a28;
      --nav-bg: rgba(20, 25, 40, 0.8);
      --accent: #00bfff;
    }
    body {
      background-color: var(--bg);
      color: var(--text);
      transition: background 0.3s, color 0.3s;
    }
    .navbar {
      background: var(--nav-bg);
      backdrop-filter: blur(10px);
    }
    .navbar-brand {
      font-weight: 700;
      color: var(--accent) !important;
    }
    .theme-toggle {
      border: none;
      background: var(--accent);
      color: white;
      border-radius: 20px;
      padding: 6px 15px;
      cursor: pointer;
      transition: 0.3s;
    }
    .theme-toggle:hover { opacity: 0.9; }
    .card {
      background: var(--card-bg);
      border: none;
      border-radius: 15px;
      overflow: hidden;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    .comment-box {
      background: var(--card-bg);
      padding: 10px 15px;
      border-radius: 10px;
      margin-bottom: 8px;
    }
  </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg fixed-top shadow-sm">
  <div class="container">
    <a class="navbar-brand" href="#"><i class="fas fa-pen-nib me-2"></i>Looma Blog</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navMenu">
      <ul class="navbar-nav me-3">
        <li class="nav-item"><a href="index.php" class="nav-link active">Home</a></li>
        <li class="nav-item"><a href="read_more.php" class="nav-link">Posts</a></li>
      </ul>
      <button id="themeToggle" class="theme-toggle">🌙 Dark Mode</button>
    </div>
  </div>
</nav>

<!-- Main Content -->
<div class="container mt-5 pt-5">

  <?php foreach ($posts as $post): ?>
    <?php
      // Fetch comments for this post
      $commentStmt = $pdo->prepare("SELECT * FROM `comments` WHERE `post_id` = ? ORDER BY `comments_id` DESC");
      $commentStmt->execute([$post['post_id']]);
      $comments = $commentStmt->fetchAll();
    ?>

    <div class="card mb-5 shadow-sm">
      <img src="images/<?php echo htmlspecialchars($post['post_img']); ?>" 
           class="card-img-top" 
           alt="Blog Image" 
           style="max-height: 400px; object-fit: cover;">
      <div class="card-body">
        <h3 class="card-title"><?php echo htmlspecialchars($post['post_title']); ?></h3>
        <span class="badge bg-primary"><?php echo htmlspecialchars($post['post_states']); ?></span>
        <p class="mt-3"><?php echo nl2br(htmlspecialchars($post['post_content'])); ?></p>

        <hr>
        <h4>Add Comment</h4>
        <form method="post" class="mb-3">
          <input type="hidden" name="post_id" value="<?php echo $post['post_id']; ?>">
          <input type="hidden" name="add_comment" value="1">
          <div class="row">
            <div class="col-md-6">
              <input type="text" name="name" class="form-control mb-2" placeholder="Your Name" required>
            </div>
            <div class="col-md-6">
              <input type="email" name="email" class="form-control mb-2" placeholder="Your Email" required>
            </div>
          </div>
          <textarea name="comment" class="form-control mb-2" rows="3" placeholder="Your Comment" required></textarea>
          <button type="submit" class="btn btn-primary">Post Comment</button>
        </form>

        <!-- Display Comments -->
        <h5 class="mt-4">Comments (<?php echo count($comments); ?>)</h5>
        <?php if ($comments): ?>
          <?php foreach ($comments as $comment): ?>
            <div class="comment-box">
              <strong><?php echo htmlspecialchars($comment['comments_username']); ?></strong>
              <p class="mb-1"><?php echo nl2br(htmlspecialchars($comment['comments_content'])); ?></p>
              <small class="text-muted">
                <?php echo isset($comment['created_at']) ? $comment['created_at'] : ''; ?>
              </small>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <p class="text-muted">No comments yet. Be the first!</p>
        <?php endif; ?>
      </div>
    </div>
  <?php endforeach; ?>
</div>

<script>
  const toggleBtn = document.getElementById('themeToggle');
  toggleBtn.addEventListener('click', () => {
    document.body.classList.toggle('dark');
    toggleBtn.textContent = document.body.classList.contains('dark')
      ? '☀️ Light Mode'
      : '🌙 Dark Mode';
  });
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
