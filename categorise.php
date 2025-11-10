<?php
require_once '../Config.php';
include './inc_admin/header.php'; ?>

<!-- Navbar -->
<?php include './inc_admin/nav.php'; ?>

<!-- Sidenav -->
<?php include './inc_admin/side_nav.php'; ?>

<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $category_name = $_POST['category_name'];
    $desc = $_POST['description'];
    $statment = $pdo->prepare("INSERT INTO `catogry`(`cat_name`, `cat_desc`) VALUES (?,?)");
    $statment->execute([$category_name, $desc]);
    echo "<script>window.location.href='categorise.php';</script>";
    exit();
}
?>

<div id="layoutSidenav_content">
    <main class="bg-dark text-light py-4">
        <div class="container-fluid px-4 page-container">
            <h1 class="mt-4 page-title text-center">Categories</h1>

            <div class="row g-4">
                <!-- Table Section -->
                <div class="col-md-6">
                    <div class="card custom-card">
                        <div class="card-header">All Categories</div>
                        <div class="card-body">
                            <table class="table table-hover align-middle text-center">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>NAME</th>
                                        <th>DESCRIPTION</th>
                                        <th>CREATED AT</th>
                                        <th>ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $statment = $pdo->prepare("SELECT * FROM `catogry`"); 
                                    $statment->execute(); 
                                    while($row = $statment->fetch()): ?>
                                        <tr>
                                            <td><?php echo $row['cat_id']; ?></td>
                                            <td><?php echo htmlspecialchars($row['cat_name']); ?></td>
                                            <td><?php echo htmlspecialchars($row['cat_desc']); ?></td>
                                            <td><?php echo $row['created_at']; ?></td>
                                            <td>
                                                <a href="edit.php?id=<?php echo $row['cat_id']; ?>" class="btn btn-sm btn-outline-primary me-2">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="delete.php?id=<?php echo $row['cat_id']; ?>" class="btn btn-sm btn-outline-danger"
                                                   onclick="return confirm('Are you sure you want to delete this category?');">
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

                <!-- Add Category Section -->
                <div class="col-md-6">
                    <div class="card custom-card">
                        <div class="card-header">Add New Category</div>
                        <div class="card-body">
                            <form action="categorise.php" method="POST">
                                <div class="mb-3">
                                    <input type="text" name="category_name" class="form-control custom-input" placeholder="Enter category name" required>
                                </div>
                                <div class="mb-3">
                                    <textarea name="description" class="form-control custom-input" placeholder="Description"></textarea>
                                </div>
                                <button type="submit" name="add_category" class="btn btn-primary fire-btn w-100">
                                    <i class="fas fa-plus"></i> Add Category
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
/* ======= NAVY DARK THEME ======= */
body {
    background-color: #0b132b;
    color: #e0e0e0;
    font-family: 'Poppins', sans-serif;
    overflow-x: hidden;
}

/* Container */
.page-container {
    background: linear-gradient(180deg, #0b132b, #1c2541);
    border-radius: 12px;
    padding: 25px;
    box-shadow: 0 0 25px rgba(41,182,246,0.15);
    animation: fadeIn 1s ease-in-out;
}

/* Title */
.page-title {
    color: #29b6f6;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    text-shadow: 0 0 10px rgba(41,182,246,0.5);
    animation: glow 2s infinite alternate;
}

/* Cards */
.custom-card {
    background: linear-gradient(145deg, #1c2541, #0b132b);
    border: 1px solid rgba(255,255,255,0.05);
    border-radius: 12px;
    color: #e0e0e0;
    box-shadow: 0 0 25px rgba(0,0,0,0.4);
    transition: all 0.3s ease;
}
.custom-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 0 35px rgba(41,182,246,0.3);
}

/* Card Header */
.custom-card .card-header {
    background: linear-gradient(90deg, #0044cc, #29b6f6);
    color: #fff;
    font-weight: 600;
    text-align: center;
    border-radius: 12px 12px 0 0;
    letter-spacing: 0.8px;
}

/* Table */
.table {
    background-color: transparent;
    color: #f1f1f1;
    border-radius: 8px;
}
.table thead {
    background: linear-gradient(135deg, #003366, #007bff);
    color: #fff;
}
.table tbody tr {
    transition: background 0.3s ease, transform 0.3s ease;
    animation: fadeIn 0.6s ease;
}
.table tbody tr:hover {
    background-color: rgba(41,182,246,0.15);
    transform: scale(1.02);
    box-shadow: 0 0 12px rgba(41,182,246,0.3);
}

/* Inputs */
.custom-input {
    background-color: #1a1a2e;
    color: #fff;
    border: 1px solid #2a2a4e;
    border-radius: 8px;
    transition: 0.3s ease;
}
.custom-input:focus {
    border-color: #29b6f6;
    box-shadow: 0 0 8px rgba(41,182,246,0.5);
    background-color: #0f1c2e;
}

/* Buttons */
.btn {
    border-radius: 10px;
    font-weight: 500;
    transition: all 0.3s ease;
}
.fire-btn {
    background: linear-gradient(90deg, #0060c0, #29b6f6);
    color: #fff;
    border: none;
    box-shadow: 0 0 20px rgba(41,182,246,0.4);
}
.fire-btn:hover {
    transform: scale(1.05);
    background: linear-gradient(90deg, #0288d1, #4fc3f7);
    box-shadow: 0 0 25px rgba(41,182,246,0.7);
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

/* Animations */
@keyframes fadeIn {
    from {opacity: 0; transform: translateY(20px);}
    to {opacity: 1; transform: translateY(0);}
}
@keyframes glow {
    from {text-shadow: 0 0 10px #29b6f6;}
    to {text-shadow: 0 0 20px #0288d1;}
}

/* Scrollbar */
::-webkit-scrollbar {
    width: 10px;
}
::-webkit-scrollbar-thumb {
    background: linear-gradient(#0044cc, #29b6f6);
    border-radius: 6px;
}
::-webkit-scrollbar-track {
    background: #0b132b;
}

/* Responsive */
@media (max-width: 768px) {
    .page-container {
        padding: 15px;
    }
    .card {
        margin-bottom: 20px;
    }
}
footer, nav {
    background-color: #1c2541 !important;
    color: #000000ff !important;
}
</style>
