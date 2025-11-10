<?php
require_once '../Config.php';
require_once './inc_admin/header.php';

if (isset($_GET['id'])) {
    $statment = $pdo->prepare("SELECT * FROM `post` WHERE `post_id` = ?");
    $statment->execute([$_GET['id']]);
    $row = $statment->fetch();
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $post_title = $_POST['post_title'];
    $post_content = $_POST['post_content'];
    $post_category = $_POST['post_category'];
    $post_status = $_POST['post_status'];

    // Image upload
    $img = '';
    if (isset($_FILES['post_image']['name']) && $_FILES['post_image']['name'] != '') {
        $img = $_FILES['post_image']['name'];
        $img_tmp = $_FILES['post_image']['tmp_name'];
        move_uploaded_file($img_tmp, "../images/$img");
    }

    // Corrected SQL query without the extra space in `catogry_id`
    $statment = $pdo->prepare("UPDATE `post` SET `post_title` = ?, `post_content` = ?, `catogry_id` = ?, `post_states` = ?, `post_img` = ? WHERE `post_id` = ?");
    $statment->execute([$post_title, $post_content, $post_category, $post_status, $img, $_GET['id']]);
    
    header("Location: display_all_posts.php");
    exit();
}
?>
<main>
    <div class="container-fluid px-5 page-container">
        <h1 class="mt-4 page-title">Edit Post</h1>
        
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card custom-card">
                    <div class="card-header">Edit Posts</div>
                    <div class="card-body">
                        <form method="POST" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="title" class="form-label">Post Title</label>
                                <input type="text" name="post_title" id="title" class="form-control custom-input" placeholder="Enter post title" value="<?php echo $row['post_title']; ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="content" class="form-label">Post Content</label>
                                <textarea name="post_content" id="content" class="form-control custom-input" rows="6" placeholder="Write your post content..." required><?php echo $row['post_content']; ?></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="category" class="form-label">Post Category</label>
                                <select name="post_category" class="form-control custom-input" id="category">
                                    <option value="tech">Tech</option>
                                    <?php 
                                    $statment = $pdo->prepare("SELECT * FROM `category`");
                                    $statment->execute();
                                    $categories = $statment->fetchAll();

                                    foreach($categories as $category){
                                        // Check if the category is selected
                                        $selected = ($category['cat_id'] == $row['catogry_id']) ? 'selected' : '';
                                        echo "<option value='{$category['cat_id']}' {$selected}>{$category['cat_name']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="image" class="form-label">Post Image</label>
                                <input type="file" name="post_image" id="image" class="form-control custom-input" accept="image/*">
                                <?php if ($row['post_img']): ?>
                                    <img src="../images/<?php echo $row['post_img']; ?>" alt="Post Image" width="100">
                                <?php endif; ?>
                            </div>

                            <div class="mb-3">
                                <label for="status" class="form-label">Post Status</label>
                                <select name="post_status" class="form-control custom-input" id="status">
                                    <option value="draft" <?php echo $row['post_states'] == 'draft' ? 'selected' : ''; ?>>Draft</option>
                                    <option value="published" <?php echo $row['post_states'] == 'published' ? 'selected' : ''; ?>>Published</option>
                                </select>
                            </div>

                            <button type="submit" name="add_post" class="btn fire-btn w-100">Edit Post</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Custom CSS -->
<style>
/* === General Body === */
body {
    background-color: #0d0d0d;
    color: #e6e6e6;
    font-family: 'Poppins', sans-serif;
}

/* === Card Styling === */
.custom-card {
    background-color: #1a1a1a;
    border-radius: 15px;
    box-shadow: 0 0 25px rgba(0, 123, 255, 0.25);
    transition: all 0.3s ease;
}

.custom-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 0 35px rgba(0, 123, 255, 0.45);
}

.card-header {
    background: linear-gradient(90deg, #0044cc, #007bff);
    border-radius: 15px 15px 0 0;
    font-weight: 600;
    letter-spacing: 1px;
}

/* === Labels & Inputs === */
.form-label {
    font-weight: 500;
    color: #b8b8b8;
}

.custom-input {
    background-color: #222;
    color: #e6e6e6;
    border: 1px solid #333;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.custom-input:focus {
    background-color: #2b2b2b;
    border-color: #007bff;
    box-shadow: 0 0 8px rgba(0, 123, 255, 0.5);
}

/* === Button Styling === */
.fire-btn {
    background: linear-gradient(90deg, #0044cc, #007bff);
    color: white;
    border: none;
    border-radius: 30px;
    padding: 10px 25px;
    font-weight: 600;
    text-transform: uppercase;
    transition: all 0.3s ease;
    box-shadow: 0 0 15px rgba(0, 123, 255, 0.4);
}

.fire-btn:hover {
    background: linear-gradient(90deg, #007bff, #3399ff);
    transform: scale(1.05);
    box-shadow: 0 0 25px rgba(0, 123, 255, 0.7);
}
</style>
<link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
