<?php 
require '../Config.php';
include './inc_admin/header.php'; 
?>
<?php include './inc_admin/nav.php'; ?>
<?php include './inc_admin/side_nav.php'; ?>
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-5 dashboard-container">
            <h1 class="mt-4 dashboard-title">Dashboard</h1>
            <ol class="breadcrumb mb-4 breadcrumb-dark">
                <li class="breadcrumb-item active">Dashboard Overview</li>
            </ol>
            <div class="row justify-content-center">
                <div class="col-md-3">
                    <div class="card dashboard-card card-purple animate__animated animate__fadeIn">
                        <div class="card-header">
                            <i class="fas fa-file-alt"></i> Total Posts
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">
                                 <?php
                                $stmt = $pdo->prepare("SELECT COUNT(*) AS total FROM `post`");
                                $stmt->execute();
                                $row = $stmt->fetch();
                                echo $row['total'];
                                ?>
                            </h5>
                            <a href="#" class="btn fire-btn">View Details</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card dashboard-card card-blue animate__animated animate__fadeIn animate__delay-1s">
                        <div class="card-header">
                            <i class="fas fa-th-large"></i> Total Categories
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">
                                <?php
                                $stmt = $pdo->prepare("SELECT COUNT(*) AS total FROM `catogry`");
                                $stmt->execute();
                                $row = $stmt->fetch();
                                echo $row['total'];
                                ?>
                            </h5>
                            <a href="#" class="btn btn-primary">View Details</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card dashboard-card card-green animate__animated animate__fadeIn animate__delay-2s">
                        <div class="card-header">
                            <i class="fas fa-comments"></i> Total Comments
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">

                                 <?php
                                $stmt = $pdo->prepare("SELECT COUNT(*) AS total FROM `comments`");
                                $stmt->execute();
                                $row = $stmt->fetch();
                                echo $row['total'];
                                ?>
                            </h5>
                            <a href="#" class="btn btn-success">View Details</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card dashboard-card card-red animate__animated animate__fadeIn animate__delay-3s">
                        <div class="card-header">
                            <i class="fas fa-clock"></i> rejected Comments
                        </div>
                        <div class="card-body">
<div class="card-body">
    <h5 class="card-title">
        <?php 
            $stmt = $pdo->prepare("SELECT COUNT(*) AS total FROM comments WHERE comments_states = 'rejected'");
            $stmt->execute();
            $row = $stmt->fetch();
            echo $row['total'];
        ?>
    </h5>
    <a href="comments.php" class="btn btn-danger">View Details</a>
</div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <?php include './inc_admin/footer.php'; ?>
</div>
<style>
body {
    background-color: #121212;
    color: #f1f1f1;
    font-family: 'Poppins', sans-serif;
    margin: 0;
    padding: 0;
}

.dashboard-container {
    background: linear-gradient(180deg, #1a1a1a, #1f1f1f);
    border-radius: 15px;
    padding: 40px;
    min-height: calc(100vh - 100px);
}

/* ===== Titles ===== */
.dashboard-title {
    color: #c77dff;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 20px;
    text-align: center;
    animation: fadeInDown 1s ease-in-out;
}

.breadcrumb-dark {
    background-color: #2a2a2a;
    border-radius: 8px;
    color: #bbb;
    padding: 8px 15px;
}

/* ===== Dashboard Cards ===== */
.dashboard-card {
    background: #1e1e1e;
    border: 1px solid #2b2b2b;
    border-radius: 15px;
    color: #ddd;
    text-align: center;
    transition: all 0.3s ease;
    margin-bottom: 30px;
    box-shadow: 0 0 20px rgba(255, 255, 255, 0.08);
}

.dashboard-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 0 25px rgba(255, 255, 255, 0.15);
}

/* ===== Colored Header Variants ===== */
.card-purple .card-header {
    background: linear-gradient(90deg, #4b0082, #9d4edd);
}
.card-blue .card-header {
    background: linear-gradient(90deg, #007bff, #00bfff);
}
.card-green .card-header {
    background: linear-gradient(90deg, #28a745, #00ff99);
}
.card-red .card-header {
    background: linear-gradient(90deg, #dc3545, #ff6666);
}

.dashboard-card .card-header {
    color: #fff;
    font-weight: 600;
    text-transform: uppercase;
    border-radius: 15px 15px 0 0;
    padding: 12px;
    letter-spacing: 0.8px;
    font-size: 1.1rem;
}

/* ===== Card Body ===== */
.dashboard-card .card-body {
    background-color: #242424;
    border-radius: 0 0 15px 15px;
    padding: 25px 10px;
}

.dashboard-card .card-title {
    font-size: 2rem;
    font-weight: bold;
    margin-bottom: 15px;
    color: #e0c3fc;
}

/* ===== Buttons ===== */
.fire-btn {
    background: linear-gradient(90deg, #4b0082, #9d4edd);
    border: none;
    color: #fff;
    border-radius: 30px;
    padding: 10px 18px;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    transition: 0.3s ease;
    box-shadow: 0 0 15px rgba(128, 0, 128, 0.4);
}

.fire-btn:hover {
    background: linear-gradient(90deg, #9d4edd, #6a0dad);
    box-shadow: 0 0 25px rgba(157, 78, 221, 0.7);
    transform: scale(1.05);
}

/* ===== Animations ===== */
@keyframes fadeInDown {
    0% { opacity: 0; transform: translateY(-30px); }
    100% { opacity: 1; transform: translateY(0); }
}

/* ===== Footer & Layout ===== */
#layoutSidenav_content {
    display: flex;
    flex-direction: column;
    min-height: 100vh;
}

main {
    flex: 1;
}

footer {
    background: linear-gradient(180deg, #1b1b1b, #181818);
    border-radius: 12px;
    padding: 20px;
    animation: fadeIn 1s ease-in-out;
}

/* ===== Scrollbar ===== */
::-webkit-scrollbar {
    width: 10px;
}
::-webkit-scrollbar-track {
    background: #1a1a1a;
}
::-webkit-scrollbar-thumb {
    background: linear-gradient(#4b0082, #9d4edd);
    border-radius: 5px;
}

/* ===== Responsive ===== */
@media (max-width: 992px) {
    .dashboard-card {
        margin-bottom: 25px;
    }
}
</style>

<!-- Animate.css -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">

<!-- Font Awesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
