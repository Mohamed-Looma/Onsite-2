<?php
require_once '../Config.php';
require_once './inc_admin/header.php';

if (isset($_GET['id'])) {
    $statment = $pdo->prepare("SELECT * FROM `catogry` WHERE `cat_id` = ?");
    $statment->execute([$_GET['id']]);
    $row = $statment->fetch();
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $category_name = $_POST['category_name'];
    $desc = $_POST['description'];
    $statment = $pdo->prepare("UPDATE `catogry` SET `cat_name` = ?, `cat_desc` = ? WHERE `cat_id` = ?");
    $statment->execute([$category_name, $desc, $_GET['id']]);
    header("Location: categorise.php");
    exit();
}
?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0 rounded-lg animate__animated animate__fadeIn custom-card">
                <div class="card-header text-center text-white">
                    <h4>Edit Category</h4>
                </div>
                <div class="card-body">
                    <form method="POST">
                        <div class="mb-3">
                            <label for="categoryName" class="form-label">Category Name</label>
                            <input 
                                type="text" 
                                name="category_name" 
                                id="categoryName" 
                                class="form-control custom-input animate__animated animate__fadeIn" 
                                placeholder="Enter category name" 
                                value="<?php echo htmlspecialchars($row['cat_name']); ?>" 
                                required
                            >
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea 
                                name="description" 
                                id="description" 
                                class="form-control custom-input animate__animated animate__fadeIn" 
                                placeholder="Enter description" 
                                required
                            ><?php echo htmlspecialchars($row['cat_desc']); ?></textarea>
                        </div>
                        <div class="text-center">
                            <button type="submit" name="edit_category" class="btn fire-btn px-5 py-2 animate__animated animate__fadeIn">Update Category</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

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
.animate__animated {
    animation-duration: 1s;
}

@keyframes fadeIn {
    0% {
        opacity: 0;
        transform: translateY(20px);
    }
    100% {
        opacity: 1;
        transform: translateY(0);
    }
}
::-webkit-scrollbar {
    width: 10px;
}
::-webkit-scrollbar-track {
    background: #111;
}
::-webkit-scrollbar-thumb {
    background: linear-gradient(#0044cc, #007bff);
    border-radius: 5px;
}
@media (max-width: 768px) {
    .custom-card {
        margin: 0 10px;
    }
    .fire-btn {
        width: 100%;
    }
}
</style>
<link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">

