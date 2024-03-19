<?php
    $title = (isset($_GET['edit'])) ? "Update Teacher" : "Add Teacher";
    $teacher = "active";
    include('admin_header.php');
    
    $get_class_qry = "SELECT * FROM class";
    $getClass = select($conn,$get_class_qry);

    if(isset($_POST['teacherName'],$_POST['email'],$_POST['gender'],$_POST['contactNo'],$_POST['address'])){
        if(!isset($_GET['edit'])){
            $teacherName = $_POST['teacherName'];
            $email = $_POST['email'];
            $classTaken = $_POST['classTaken'];
            $gender = $_POST['gender'];
            $contactNo = $_POST['contactNo'];
            $address = $_POST['address'];
            $class_taken = implode(",",$classTaken);
            if(!empty($teacherName)&&!empty($email)&&!empty($classTaken)&&!empty($gender)&&!empty($contactNo)&&!empty($address)){
                $insert_user = "INSERT INTO `users`(`name`, `email`, `password`, `role`) VALUES ('$teacherName','$email','$contactNo',2)";
                $insert = create($conn,$insert_user);
                $user_id = $conn->insert_id;
                $insert_teacher = "INSERT INTO `teachers`(`user_id`, `teacher_name`, `gender`, `class_taking`, `contact_no`, `address`) VALUES ('$user_id','$teacherName','$gender','$class_taken','$contactNo','$address')";
                $insert = create($conn,$insert_teacher);
                echo "<script>alert('Teacher added successfully.')</script>";
            }else{
                echo "<script>alert('Please fill out the form.')</script>";
            }
        }else{
            $teacherName = $_POST['teacherName'];
            $email = $_POST['email'];
            $classTaken = $_POST['classTaken'];
            $gender = $_POST['gender'];
            $contactNo = $_POST['contactNo'];
            $address = $_POST['address'];
            $class_taken = implode(",",$classTaken);
            $teacher_id = $_GET['edit'];
            $teacher_user = selectUserIdFromTeacher($conn,$teacher_id);
            if(!empty($teacherName)&&!empty($email)&&!empty($classTaken)&&!empty($gender)&&!empty($contactNo)&&!empty($address)){
                $teacher_user_id = $teacher_user[0]['user_id'];
                $update_user_query = "UPDATE `users` SET `name`='$teacherName', `email`='$email' WHERE id = $teacher_user_id";
                $update_user = update($conn,$update_user_query);
                $update_teacher_query = "UPDATE `teachers` SET  `teacher_name`='$teacherName', `gender`='$gender', `class_taking`='$class_taken', `contact_no`='$contactNo', `address`='$address' WHERE id=$teacher_id";
                $update_teacher = update($conn,$update_teacher_query);
                echo "<script>alert('Teacher updated successfully.')</script>";
                echo "<script> window.location.href='teacher.php'</script>";
            }else{
                echo "<script>alert('Please fill out the form.')</script>";
            }

        }
    }

    if(isset($_GET['edit'])){
        $id = $_GET['edit'];
        $data = select($conn,"SELECT t.*,u.email FROM teachers AS t INNER JOIN users AS u ON t.user_id = u.id  WHERE t.id = $id");
    }
?>

<!-- Main Content Here -->
<div class="container-fluid" style="position: relative; z-index: 10;">
    <div class="row">
        <div class="col-9 ms-3">
            <div class="mt-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><?= (isset($_GET['edit'])) ? "Update teacher info" : "Add Teacher" ?></h5>
            </div>
            <hr class="my-2">
            <div class="mt-3 border container p-2 overflow-auto" style="height: 470px;">
                <form action="" method="POST" name="teacherAdd">
                    <div class="mb-2">
                        <label for="teacherName" class="me-2">Teacher Name</label>
                        <input type="text" class="form-control" name="teacherName" id="teacherName" value="<?= (isset($_GET['edit'])) ? $data[0]['teacher_name'] : '' ?>">
                    </div>
                    <div class="mb-2">
                        <label for="email" class="me-2">Email</label>
                        <input type="email" class="form-control" name="email" id="email" value="<?= (isset($_GET['edit'])) ? $data[0]['email'] : '' ?>">
                    </div>
                    <div class="mb-2">
                        <label for="classTaken" class="me-2">Class Taken</label><br>
                        <select data-placeholder="Select class taken" multiple class="chosen-select w-100 " name="classTaken[]">
                            <?php foreach ($getClass as $class) { ?>
                                <option value="<?php echo $class['id']?>" <?php  
                                if(isset($_GET['edit'])){ $cls =explode(',',$data[0]['class_taking']);if(in_array($class['id'],$cls)){ echo 'selected';}} ?>><?php echo $class['class_name'];?></option>
                            <?php }?>
                        </select>
                        <p class="error"></p>
                    </div>
                    <div class="mb-2">
                        <label class="me-2">Gender</label><br>
                        <input type="radio" name="gender" value="Male" id="male" <?= (isset($_GET['edit'])) ? ($data[0]['gender'] == 'Male' ? 'checked' : '') : '' ?>>
                        <label class="me-2" for="male">Male</label>
                        <input type="radio" name="gender" value="Female" id="female" <?= (isset($_GET['edit'])) ? ($data[0]['gender'] == 'Female' ? 'checked' : '') : '' ?>>
                        <label class="me-2" for="female">Female</label>
                    </div>
                    <div class="mb-2">
                        <label for="contactNo" class="me-2">Contact No</label>
                        <input type="text" class="form-control" name="contactNo" id="contactNo" value="<?= (isset($_GET['edit'])) ? $data[0]['contact_no'] : '' ?>">
                    </div>
                    <div class="mb-2">
                        <label for="address" class="me-2">Address</label>
                        <textarea name="address" id="address" class="form-control" rows="3"><?= (isset($_GET['edit'])) ? $data[0]['address'] : '' ?></textarea>
                    </div>
                    <input type="submit" value="<?= (isset($_GET['edit'])) ? 'Update' : 'Submit' ?>" class="btn btn-sm btn-success">
                </form>
            </div>
        </div>
    </div>
</div>

    <!-- multiselect -->
    <!-- <link rel="stylesheet" href="plugins/chosen_multiselect/docsupport/style.css"> -->
    <link rel="stylesheet" href="plugins/chosen_multiselect/docsupport/prism.css">
    <link rel="stylesheet" href="plugins/chosen_multiselect/chosen.css">
<!-- <script src="plugins/cohsen_multiselect/docsupport/jquery-3.2.1.min.js" type="text/javascript"></script> -->
<script src="plugins/chosen_multiselect/chosen.jquery.js" type="text/javascript"></script>
<script>
     $(".chosen-select").chosen({no_results_text: "Oops, nothing found!"}); 
</script>
<?php
    include('footer.php');
?>