<?php
    include('db_config.php');
    if(isset($_SESSION['role'])) {
        $role = $_SESSION['role'];
        $user_id = $_SESSION['user_id'];
        $user = select($conn,"SELECT `name` FROM users WHERE id = $user_id");
    }else{
        header('location: index.php');
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <!-- Bootstrap + jQuery -->
    <link rel="stylesheet" href="plugins/bootstrap-5.0.2-dist/css/bootstrap.min.css">
    <script src="plugins/bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js"></script>
    <script src="plugins/jquery-3.7.1/jquery-3.7.1.min.js"></script>

    <!-- Bootstrap Offcanvas Component -->
    <link rel="stylesheet" href="plugins/offcanvas-push-menu-bootstrap/css/bootstrap-off-canvas.css">
    <script src="plugins/offcanvas-push-menu-bootstrap/js/bootstrap-off-canvas.js"></script>

    <!-- datatable -->
    <link rel="stylesheet" href="plugins/datatables/DataTables-2.0.2/css/dataTables.dataTables.css">
    <script src="plugins/datatables/DataTables-2.0.2/js/dataTables.js"></script>

    <!-- jqury validator -->
    <script src="plugins/jquery-validation/dist/jquery.validate.min.js"></script>
    <link rel="stylesheet" href="style.css">
    <script src="form-validation.js"></script>

</head>

<body>
    <div class="off-canvas-wrapper">
        <div id="off_canvas" class="off-canvas active">
            <!-- Navbar -->
            <div class="off-canvas-nav bg-dark">
                <div class="d-flex align-items-center flex-column text-center mb-3">
                    <?php 
                        if($role != 3){
                    ?>
                    <img src="images/avatar.png" alt="avatar" style="width: 150px; height: 150px; border-radius: 50%;">
                    <?php }else{
                            $image = select($conn,"SELECT student_image FROM students WHERE user_id = $user_id");
                    ?>
                        <img src="<?= $image[0]['student_image']; ?>" alt="avatar" style="width: 150px; height: 150px; border-radius: 50%;">
                    <?php }?>
                    <p class="mt-3 mb-1 text-light text-center"><?= $user[0]['name']; ?></p>
                    <small class="text-white">Role : <?php if($role == 1){echo "Admin";}else if($role == 2){echo "Teacher";}else{echo "Student";}?></small>
                </div>
                <hr class="mt-0 bg-light">
                <div class="nav nav-pills nav-fill flex-column">
                    <a href="admin_dashboard.php" class="text-left nav-item nav-link <?php if(isset($home)){ echo "active"; }else{ echo "text-light"; } ?>">Dashboard</a>
                    <?php if($role == 1){ ?>
                        <a href="class.php" class="text-left nav-item nav-link <?php if(isset($class)){ echo "active"; }else{ echo "text-light"; } ?>">Class</a>
                    <?php } ?>
                    <a href="teacher.php" class="text-left nav-item nav-link <?php if(isset($teacher)){ echo "active"; }else{ echo "text-light"; } ?>">Teachers</a>
                    <a href="student.php" class="text-left nav-item nav-link <?php if(isset($student)){ echo "active"; }else{ echo "text-light"; } ?>">Students</a>
                    <a href="logout.php" class="text-left nav-item nav-link text-light">Logout</a>
                </div>
            </div>
            <div class="off-canvas-content">
                <nav class="navbar navbar-dark bg-dark ">
                    <!-- <button class="navbar-toggler off-canvas-toggler mx-2" type="button" data-target="#off_canvas" aria-controls="offcanvasSupportedContent" aria-expanded="true" aria-label="Toggle off canvas menu">
                        <span class="navbar-toggler-icon"></span>
                    </button> -->
                    <div class="navbar-brand ms-2 col-5">
                        Student Management System
                    </div>
                </nav>