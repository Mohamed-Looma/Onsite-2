<?php 
require '../Config.php'; 
include './inc_admin/header.php'; 
include './inc_admin/nav.php'; 
include './inc_admin/side_nav.php'; 

// ===================== 🛠 Comment Counters ===================== //
$pending_comments = $pdo->query("SELECT COUNT(*) FROM comments WHERE comments_states = 'pending'")->fetchColumn();
$approved_comments = $pdo->query("SELECT COUNT(*) FROM comments WHERE comments_states = 'approved'")->fetchColumn();
$rejected_comments = $pdo->query("SELECT COUNT(*) FROM comments WHERE comments_states = 'rejected'")->fetchColumn();

// ===================== ⚡ Handle Actions ===================== //
$message = '';
$message_type = '';

if (isset($_GET['action']) && isset($_GET['id'])) {
    $comment_id = (int)$_GET['id'];
    $action = $_GET['action'];

    if ($action === 'approve') {
        $stmt = $pdo->prepare("UPDATE comments SET comments_states = 'approved' WHERE comments_id = ?");
        $stmt->execute([$comment_id]);
        $message = "✅ Comment approved!";
        $message_type = "success";
    } elseif ($action === 'reject') {
        $stmt = $pdo->prepare("UPDATE comments SET comments_states = 'rejected' WHERE comments_id = ?");
        $stmt->execute([$comment_id]);
        $message = "⚠️ Comment rejected!";
        $message_type = "warning";
    } elseif ($action === 'delete') {
        $stmt = $pdo->prepare("DELETE FROM comments WHERE comments_id = ?");
        $stmt->execute([$comment_id]);
        $message = "🗑️ Comment deleted!";
        $message_type = "danger";
    }

    echo "<script>window.location.href = 'comments.php';</script>";
    exit();
}

// ===================== 💬 Fetch Comments ===================== //
$stmt = $pdo->query("SELECT * FROM comments ORDER BY created_at DESC");
$comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- ===================== 🧱 Layout Content ===================== -->
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4 mt-4 comments-container">

            <h1 class="text-center mb-4 page-title">Comments Management</h1>

            <?php if ($message): ?>
                <div class="alert alert-<?php echo $message_type; ?> alert-dismissible fade show text-center" role="alert">
                    <?php echo $message; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <div class="stats-bar mb-4">
                <span class="badge bg-primary">Total: <?php echo count($comments); ?></span>
                <span class="badge bg-success">Approved: <?php echo $approved_comments; ?></span>
                <span class="badge bg-danger">Rejected: <?php echo $rejected_comments; ?></span>
            </div>

            <div class="table-responsive">
                <table class="table table-dark table-hover align-middle text-center">
                    <thead class="table-gradient">
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Content</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($comments as $comment): ?>
                        <tr>
                            <td><?php echo $comment['comments_id']; ?></td>
                            <td><?php echo htmlspecialchars($comment['comments_username']); ?></td>
                            <td><?php echo htmlspecialchars($comment['comment_useremail']); ?></td>
                            <td class="text-start"><?php echo htmlspecialchars($comment['comments_content']); ?></td>
                            <td>
                                <?php 
                                    $state = $comment['comments_states'];
                                    $badge = $state === 'approved' ? 'success' : ($state === 'rejected' ? 'danger' : 'warning text-dark');
                                ?>
                                <span class="badge bg-<?php echo $badge; ?>">
                                    <?php echo ucfirst($state); ?>
                                </span>
                            </td>
                            <td>
                                <?php if ($comment['comments_states'] != 'approved'): ?>
                                    <a href="comments.php?action=approve&id=<?php echo $comment['comments_id']; ?>" class="btn btn-sm btn-success">
                                        <i class="bi bi-check"></i>
                                    </a>
                                <?php endif; ?>
                                <a href="comments.php?action=delete&id=<?php echo $comment['comments_id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this comment?')">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <?php include './inc_admin/footer.php'; ?>
</div>

<!-- ===================== 🎨 Dark Style ===================== -->
<style>
body {
    background-color: #121212;
    color: #f1f1f1;
    font-family: 'Poppins', sans-serif;
}
.comments-container {
    background: #1a1a1a;
    border-radius: 12px;
    padding: 30px;
    box-shadow: 0 0 25px rgba(255,255,255,0.05);
}
.page-title {
    color: #c77dff;
    text-transform: uppercase;
    font-weight: 600;
    letter-spacing: 1px;
}
.table-gradient {
    background: linear-gradient(90deg, #4b0082, #9d4edd);
}
.table-dark {
    color: #fff;
    border-color: #2b2b2b;
}
.table-dark tbody tr:hover {
    background-color: #2b2b2b;
}
.stats-bar {
    display: flex;
    gap: 15px;
    justify-content: center;
    flex-wrap: wrap;
}
.btn {
    border: none;
    transition: 0.3s ease;
}
.btn:hover {
    transform: scale(1.05);
}
</style>

<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
