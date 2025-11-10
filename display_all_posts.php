<?php require '../Config.php'; ?>
<?php include './inc_admin/header.php'; ?>

<!-- Navbar -->
<?php include './inc_admin/nav.php'; ?>

<!-- Side Navigation -->
<?php include './inc_admin/side_nav.php'; ?>

<style>
/* ======== NAVY DARK THEME ======== */
body {
    background-color: #0b132b !important;
    color: #f5f5f5 !important;
    font-family: 'Poppins', sans-serif;
    overflow-x: hidden;
}

/* Container + Headings */
h1 {
    color: #29b6f6;
    text-shadow: 0 0 8px rgba(41,182,246,0.4);
}

/* Card Styling */
.card {
    background: linear-gradient(145deg, #1c2541, #0b132b);
    border: 1px solid rgba(255, 255, 255, 0.05);
    color: #e0e0e0;
    box-shadow: 0 0 25px rgba(0,0,0,0.5);
    transition: all 0.3s ease;
}
.card:hover {
    transform: translateY(-4px);
    box-shadow: 0 0 35px rgba(41,182,246,0.25);
}

/* Table */
.table {
    background-color: transparent;
    color: #f1f1f1;
}
.table thead {
    background-color: #1d3557;
    color: #fff;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}
.table-hover tbody tr:hover {
    background-color: rgba(41,182,246,0.15);
    transition: 0.3s;
}

/* Badges */
.badge {
    border-radius: 8px;
    padding: 6px 10px;
    font-weight: 500;
    animation: fadeIn 0.8s ease;
}

/* Buttons */
.btn {
    border-radius: 10px;
    font-weight: 500;
    transition: all 0.3s ease;
}
.btn-success {
    background-color: #29b6f6;
    border: none;
    color: #fff;
}
.btn-success:hover {
    background-color: #0288d1;
    transform: scale(1.05);
}

.btn-outline-primary {
    color: #29b6f6;
    border-color: #29b6f6;
}
.btn-outline-primary:hover {
    background-color: #29b6f6;
    color: #fff;
    transform: scale(1.1);
}

.btn-outline-danger {
    color: #ef5350;
    border-color: #ef5350;
}
.btn-outline-danger:hover {
    background-color: #ef5350;
    color: #fff;
    transform: scale(1.1);
}

/* Images */
img.rounded-3 {
    border: 2px solid rgba(255,255,255,0.1);
    transition: all 0.3s ease;
}
img.rounded-3:hover {
    transform: scale(1.15) rotate(1deg);
    box-shadow: 0 0 15px rgba(41,182,246,0.5);
}

/* Animation Effects */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

tbody tr {
    animation: fadeIn 0.8s ease;
}

/* Footer & Navbar overrides */
footer, nav {
    background-color: #1c2541 !important;
    color: #000000ff !important;
}

/* Scrollbar */
::-webkit-scrollbar {
    width: 10px;
}
::-webkit-scrollbar-thumb {
    background: #29b6f6;
    border-radius: 5px;
}
::-webkit-scrollbar-track {
    background: #0b132b;
}
</style>

<div id="layoutSidenav_content">
    <main class="py-4">
        <div class="container-fluid px-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="mt-4 fw-bold">All Blog Posts</h1>
                <a href="add_post.php" class="btn btn-success shadow-lg">
                    <i class="fas fa-plus"></i> Add New Post
                </a>
            </div>

            <!-- Modern Card -->
            <div class="card rounded-4 shadow-lg p-3">
                <div class="card-body">
                    <table class="table table-hover table-striped align-middle text-center">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Content</th>
                                <th>Category</th>
                                <th>Image</th>
                                <th>Views</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $statment = $pdo->prepare("SELECT * FROM `post`");
                            $statment->execute(); 
                            while($row = $statment->fetch()):
                                $cat_id = $row['catogry_id']; 
                                $stmt = $pdo->prepare("SELECT * FROM `catogry` WHERE `cat_id` = ?");
                                $stmt->execute([$cat_id]);
                                $catogry = $stmt->fetch();
                            ?>
                            <tr>
                                <td class="fw-semibold"><?php echo $row['post_id']; ?></td>
                                <td class="text-start"><?php echo htmlspecialchars($row['post_title']); ?></td>
                                <td class="text-muted" style="max-width: 250px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    <?php echo htmlspecialchars($row['post_content']); ?>
                                </td>
                                <td>
                                    <span class="badge bg-info text-dark">
                                        <?php echo htmlspecialchars($catogry['cat_name']); ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if (!empty($row['post_img'])): ?>
                                        <img src="../images/<?php echo $row['post_img']; ?>" alt="Post Image" width="60" class="rounded-3 shadow-sm">
                                    <?php else: ?>
                                        <span class="text-secondary">No Image</span>
                                    <?php endif; ?>
                                </td>
                                <td><span class="badge bg-secondary"><?php echo $row['post_views']; ?></span></td>
                                <td>
                                    <?php if ($row['post_states'] == 'published'): ?>
                                        <span class="badge bg-success">Published</span>
                                    <?php else: ?>
                                        <span class="badge bg-warning text-dark">Draft</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="edit_display.php?id=<?php echo $row['post_id']; ?>" class="btn btn-sm btn-outline-primary me-2">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="delete_post.php?id=<?php echo $row['post_id']; ?>" 
                                       class="btn btn-sm btn-outline-danger delete"
                                       onclick="return confirm('Are you sure you want to delete this post?');">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <?php include './inc_admin/footer.php'; ?>
</div>

<!-- Font Awesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
