<?php
    require('db_config.php');
    if(isset($_SESSION['role'],$_SESSION['user_id'])){
        $role = $_SESSION['role'];
        if($role == 1) {
            header('location: admin_dashboard.php');
        }else if($role == 2){
            header('location: teacher_dashboard.php');
        }else if($role == 3){
            header('location: student_dashboard.php');
        }
    }

    if(isset($_POST['email'],$_POST['password']))
    {
        $email = $conn->real_escape_string($_POST['email']);
        $password = $conn->real_escape_string($_POST['password']);

        $user = select($conn,"SELECT * FROM users WHERE email = '$email' AND `password` = '$password' AND `status` = 1");
        
        if(count($user) == 1){
            $role = $user[0]['role'];
            $_SESSION['user_id'] = $user[0]['id'];
            $_SESSION['role'] = $role;

            if($role == 1) {
                header('location: admin_dashboard.php');
            }else if($role == 2){
                header('location: teacher_dashboard.php');
            }else if($role == 3){
                header('location: student_dashboard.php');
            }else{
                echo "<script>alert('Unauthorized user')</script>";
            }
        }else{
            echo "<script>alert('Incorrect username or password.')</script>";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="plugins/bootstrap-5.0.2-dist/css/bootstrap.min.css">
    <style>
        body{
            background-color: #508bfc;
        }
    </style>
</head>
<body>
    <section>
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card shadow-2-strong" style="border-radius: 1rem;">
                        <div class="card-body p-5">

                            <h3 class="mb-3 text-center">Sign in</h3>
                            <form action="" method="POST" name="loginForm">
                                <div class="form-outline mb-4">
                                    <label class="form-label" for="email">Email</label>
                                    <input type="email" id="email" name="email" class="form-control form-control-lg" name="email" required/>
                                </div>

                                <div class="form-outline mb-4">
                                    <label class="form-label" for="password">Password</label>
                                    <input type="password" id="password" name="password" class="form-control form-control-lg" required/>
                                </div>

                                <!-- Checkbox -->
                                <div class="form-check d-flex justify-content-start mb-4">
                                    <input class="form-check-input me-2" type="checkbox" value="1" id="remember" />
                                    <label class="form-check-label" for="remember"> Remember password </label>
                                </div>

                                <button class="btn btn-primary btn-block" type="submit">Login</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

</html>