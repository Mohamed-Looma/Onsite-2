<?php 
require '../Config.php'; 
include './inc_admin/header.php'; 
include './inc_admin/nav.php'; 
include './inc_admin/side_nav.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $post_title = $_POST['post_title'];
    $post_content = $_POST['post_content'];
    $post_category = $_POST['post_category'];
    $post_status = $_POST['post_status'];

    $img = '';
    if (isset($_FILES['post_image']['name']) && $_FILES['post_image']['name'] != '') {
        $img = $_FILES['post_image']['name'];
        $img_tmp = $_FILES['post_image']['tmp_name'];
        move_uploaded_file($img_tmp, "../images/$img");
    }

    $statment = $pdo->prepare("SELECT * FROM `catogry` WHERE `cat_id` = ?");
    $statment->execute([$post_category]);
    $category = $statment->fetch();

    if ($category) {
        $statment = $pdo->prepare("
            INSERT INTO `post` 
            (`post_title`, `post_content`, `post_img`, `catogry_id`, `post_states`) 
            VALUES (?, ?, ?, ?, ?)
        ");
        $statment->execute([$post_title, $post_content, $img, $post_category, $post_status]);
        echo "<script>window.location.href='display_all_posts.php';</script>";
    } 
}
?>

<!-- Modern Add Post Page -->
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-5 page-container">
            <h1 class="mt-4 page-title">
                <i class="fas fa-pen-nib me-2"></i> Add New Post
            </h1>
            
            <div class="row justify-content-center">
                <div class="col-lg-9">
                    <div class="card glass-card">
                        <div class="card-header">
                            <i class="fas fa-file-signature me-2"></i> Create a New Post
                        </div>
                        <div class="card-body">
                            <form method="post" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <label for="title" class="form-label">Post Title</label>
                                    <input type="text" name="post_title" id="title" class="form-control glass-input" placeholder="Enter your post title..." required>
                                </div>

                                <div class="mb-3">
                                    <label for="content" class="form-label">Post Content</label>
                                    <textarea name="post_content" id="content" class="form-control glass-input" rows="6" placeholder="Write your content here..." required></textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="category" class="form-label">Post Category</label>
                                    <select name="post_category" class="form-control glass-input" id="category" required>
                                        <option value="">Select category</option>
                                        <?php 
                                        $statment = $pdo->prepare("SELECT * FROM `catogry`");
                                        $statment->execute();
                                        $catogries = $statment->fetchAll();
                                        foreach ($catogries as $catogry) {
                                            echo "<option value='{$catogry['cat_id']}'>{$catogry['cat_name']}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="image" class="form-label">Post Image</label>
                                    <input type="file" name="post_image" id="image" class="form-control glass-input" accept="image/*" required>
                                </div>

                                <div class="mb-3">
                                    <label for="status" class="form-label">Post Status</label>
                                    <select name="post_status" class="form-control glass-input" id="status">
                                        <option value="draft">Draft</option>
                                        <option value="published">Published</option>
                                    </select>
                                </div>

                                <button type="submit" name="add_post" class="btn neon-btn w-100">
                                    <i class="fas fa-upload me-2"></i> Publish Post
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <?php include './inc_admin/footer.php'; ?>
</div>

<!-- Font Awesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

<style>
/* ====== Dark Navy Futuristic Theme ====== */

body {
    background: radial-gradient(circle at top left, #020b24, #06163d 60%, #0b1a3d);
    color: #e2e6f3;
    font-family: 'Poppins', sans-serif;
    margin: 0;
    padding: 0;
    overflow-x: hidden;
}

/* Page container */
.page-container {
    min-height: calc(100vh - 120px);
    animation: fadeIn 1s ease-in-out;
}

/* Title */
.page-title {
    color: #7fa6ff;
    font-weight: 600;
    text-transform: uppercase;
    text-align: center;
    letter-spacing: 1px;
    margin-bottom: 40px;
    text-shadow: 0 0 20px rgba(80, 130, 255, 0.4);
}

/* Glass card */
.glass-card {
    background: rgba(15, 25, 55, 0.6);
    backdrop-filter: blur(18px);
    border: 1px solid rgba(100, 150, 255, 0.25);
    border-radius: 20px;
    box-shadow: 0 0 25px rgba(50, 100, 200, 0.2);
    color: #dfe6ff;
    transition: 0.4s ease;
}

.glass-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 0 35px rgba(70, 120, 255, 0.4);
}

/* Card header */
.glass-card .card-header {
    background: linear-gradient(90deg, #0b1f4a, #153b7c);
    color: #e6ecff;
    font-weight: 600;
    text-align: center;
    padding: 16px;
    border-radius: 20px 20px 0 0;
    letter-spacing: 1px;
    font-size: 1.1rem;
}

/* Inputs */
.glass-input {
    background: rgba(10, 20, 45, 0.6);
    color: #e0e8ff;
    border: 1px solid rgba(80, 120, 200, 0.3);
    border-radius: 10px;
    padding: 12px;
    transition: all 0.3s ease;
}

.glass-input:focus {
    border-color: #7fa6ff;
    box-shadow: 0 0 12px rgba(80, 130, 255, 0.5);
    outline: none;
    background: rgba(15, 30, 60, 0.8);
}

/* Buttons */
.neon-btn {
    background: linear-gradient(90deg, #0b2a5c, #1f4c9e);
    border: none;
    color: #fff;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.8px;
    border-radius: 40px;
    padding: 12px;
    transition: all 0.3s ease;
    box-shadow: 0 0 20px rgba(60, 100, 200, 0.3);
}

.neon-btn:hover {
    background: linear-gradient(90deg, #3068e2, #153b7c);
    box-shadow: 0 0 30px rgba(100, 150, 255, 0.6);
    transform: scale(1.05);
}

/* Labels */
label {
    color: #bcd1ff;
    font-weight: 500;
}

/* Animations */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

/* Scrollbar */
::-webkit-scrollbar {
    width: 10px;
}
::-webkit-scrollbar-track {
    background: #0a1024;
}
::-webkit-scrollbar-thumb {
    background: linear-gradient(#1f4c9e, #3c7dff);
    border-radius: 5px;
}

/* Responsive */
@media (max-width: 768px) {
    .glass-card {
        border-radius: 14px;
    }
}
</style>
