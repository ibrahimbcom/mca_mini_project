<?php
    $title = (isset($_GET['edit'])) ? "Update Student" : "Add Student";
    $student = "active";
    include('admin_header.php');
    $get_class_qry = "SELECT * FROM class";
    $getClass = select($conn,$get_class_qry);
    
    if(isset($_GET['edit'])){
        $id = $_GET['edit'];
        
        if($role == 2)
        {
            $teacherGet = select($conn,"SELECT class_taking FROM teachers WHERE user_id = $user_id");
            $class_taking = $teacherGet[0]['class_taking'];
            $class_qry = " AND class IN($class_taking)";
        }else{
            $class_qry = '';
        }
        $data = select($conn,"SELECT s.*,u.email FROM students AS s INNER JOIN users AS u ON s.user_id = u.id  WHERE s.id = $id $class_qry");
        
        if(count($data) == 0){
            echo "<script>alert('You are not allowed to access this.')</script>";
            echo "<script> window.location.href='student.php'</script>";
        }
    }

    if(isset($_POST['studentName'],$_POST['email'],$_POST['dob'],$_POST['class'],$_POST['fatherName'],$_POST['motherName'],$_POST['gender'],$_POST['annualIncome'],$_POST['contactNo'],$_POST['address'])){

        if (isset($_FILES['studentImage']) && $_FILES["studentImage"]["name"] != "") {
            $target_dir = "profile-images/";
            $target_file = $target_dir . basename($_FILES["studentImage"]["name"]);
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
                echo "<script>alert('Sorry, only JPG, JPEG, PNG & GIF files are allowed.')</script>";
                echo "<script> window.location.href='student.php'</script>";
            }
        }

        if(!isset($_GET['edit'])){
            $studentName = $_POST['studentName'];
            $email = $_POST['email'];
            $dob = $_POST['dob'];
            $class = $_POST['class'];
            $fatherName = $_POST['fatherName'];
            $motherName = $_POST['motherName'];
            $gender = $_POST['gender'];
            $annualIncome = $_POST['annualIncome'];
            $contactNo = $_POST['contactNo'];
            $studentImage = $_FILES['studentImage'];
            $address = $_POST['address'];

            if (isset($_FILES['studentImage'])) {
                if (isset($_FILES['studentImage'])) {
                    $target_dir = "profile-images/";
                    $target_file = $target_dir. time() . basename($_FILES["studentImage"]["name"]);
                    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                }
                if (move_uploaded_file($_FILES["studentImage"]["tmp_name"], $target_file)) {
                    $file = $target_file;
                }else{
                    $file = NULL;
                }
            }

            if(!empty($studentName)&&!empty($email)&&!empty($dob)&&!empty($class)&&!empty($fatherName)&&!empty($motherName)&&!empty($gender)&&!empty($annualIncome)&&!empty($contactNo)&&!empty($address)){
                $insert_user = "INSERT INTO `users`(`name`, `email`, `password`, `role`) VALUES ('$studentName','$email','$contactNo',3)";
                $insert = create($conn,$insert_user);
                $user_id = $conn->insert_id;
                $cls_name = getClass($conn,$class);
                $roll_no = $cls_name.date('Y').sprintf("%03d", $user_id);

                $insert_student = "INSERT INTO `students`(`user_id`, `student_name`, `dob`, `gender`, `class`, `roll_no`, `father_name`, `mother_name`, `contact_no`, `address`, `annual_income`, `student_image`) VALUES ($user_id,'$studentName','$dob','$gender','$class','$roll_no','$fatherName','$motherName','$contactNo','$address','$annualIncome','$file')";
                $insert = create($conn,$insert_student);
                echo "<script>alert('Student added successfully.')</script>";
                echo "<script> window.location.href='student.php'</script>";

            }else{
                echo "<script>alert('Please fill out the form.')</script>";
            }
        }else{
            $studentName = $_POST['studentName'];
            $email = $_POST['email'];
            $dob = $_POST['dob'];
            $class = $_POST['class'];
            $fatherName = $_POST['fatherName'];
            $motherName = $_POST['motherName'];
            $gender = $_POST['gender'];
            $annualIncome = $_POST['annualIncome'];
            $contactNo = $_POST['contactNo'];
            $studentImage = $_FILES['studentImage'];
            $address = $_POST['address'];

            $student_id = $_GET['edit'];
            $student_user = selectUserIdFromStudent($conn,$student_id);
            if(!empty($studentName)&&!empty($email)&&!empty($dob)&&!empty($class)&&!empty($fatherName)&&!empty($motherName)&&!empty($gender)&&!empty($annualIncome)&&!empty($contactNo)&&!empty($address)){
                if (isset($_FILES['studentImage'])) {
                    if (isset($_FILES['studentImage'])) {
                        $target_dir = "profile-images/";
                        $target_file = $target_dir. time() . basename($_FILES["studentImage"]["name"]);
                        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                    }
                    if (move_uploaded_file($_FILES["studentImage"]["tmp_name"], $target_file)) {
                        if(file_exists($data[0]['student_image']))
                        {
                            unlink($data[0]['student_image']);
                        }
                        $file = ", `student_image` = '$target_file'";
                    }else{
                        $file = '';
                    }
                }

                $student_user_id = $student_user[0]['user_id'];
                $update_user_query = "UPDATE `users` SET `name`='$studentName', `email`='$email' WHERE id = $student_user_id";
                $update_user = update($conn,$update_user_query);
                $update_student_query = "UPDATE `students` SET  `student_name`='$studentName', `dob` = '$dob', `gender`='$gender', `class`='$class', `father_name` = '$fatherName', `mother_name` = '$motherName', `contact_no`='$contactNo', `address`='$address', `annual_income`= '$annualIncome' $file WHERE id=$student_id";
                $update_student = update($conn,$update_student_query);
                echo "<script>alert('Student updated successfully.')</script>";
                echo "<script> window.location.href='student.php'</script>";
            }else{
                echo "<script>alert('Please fill out the form.')</script>";
            }

        }
    }

?>
<!-- Main Content Here -->
<div class="container-fluid" style="position: relative; z-index: 10;">
    <div class="row">
        <div class="col-9 ms-3">
            <div class="mt-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><?= (isset($_GET['edit'])) ? "Update student info" : "Add Student" ?></h5>
            </div>
            <hr class="my-2">
            <div class="mt-3 border container p-2 overflow-auto" style="height: 470px;">
                <form action="" method="POST" name="studentAdd" enctype="multipart/form-data">
                    <div class="mb-2">
                        <label for="studentName" class="me-2">Student Name</label>
                        <input type="text" class="form-control" name="studentName" id="studentName" value="<?= (isset($_GET['edit'])) ? $data[0]['student_name'] : '' ?>">
                    </div>
                    <div class="mb-2">
                        <label for="email" class="me-2">Email</label>
                        <input type="email" class="form-control" name="email" id="email" value="<?= (isset($_GET['edit'])) ? $data[0]['email'] : '' ?>">
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <div class="w-50 me-2">
                            <label for="dob" class="me-2">Date of birth</label>
                            <input type="date" class="form-control" name="dob" id="dob" value="<?= (isset($_GET['edit'])) ? $data[0]['dob'] : '' ?>">
                        </div>
                        <div class="w-50">
                            <label for="class" class="me-2">Class</label><br>
                            <select class="form-select w-100 " name="class">
                                <option value="">Select the class</option>
                                <?php foreach ($getClass as $class) {?>
                                    <option value="<?= $class['id'] ?>" <?= (isset($_GET['edit']) && $data[0]['class'] == $class['id']) ? 'selected' : '' ?>><?= $class['class_name'] ?></option>
                                <?php }?>
                            </select>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <div class="w-50 me-2">
                            <label for="fatherName" class="me-2">Father Name</label>
                            <input type="text" class="form-control" name="fatherName" id="fatherName" value="<?= (isset($_GET['edit'])) ? $data[0]['father_name'] : '' ?>">
                        </div>
                        <div class="w-50">
                            <label for="motherName" class="me-2">Mother Name</label>
                            <input type="text" class="form-control" name="motherName" id="motherName" value="<?= (isset($_GET['edit'])) ? $data[0]['mother_name'] : '' ?>">
                        </div>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <div class="w-50 me-2">
                            <label class="me-2">Gender</label><br>
                            <input type="radio" name="gender" value="Male" id="male" <?= (isset($_GET['edit'])) ? ($data[0]['gender'] == 'Male' ? 'checked' : '') : '' ?>>
                            <label class="me-2" for="male">Male</label>
                            <input type="radio" name="gender" value="Female" id="female" <?= (isset($_GET['edit'])) ? ($data[0]['gender'] == 'Female' ? 'checked' : '') : '' ?>>
                            <label class="me-2" for="female">Female</label>
                        </div>
                        <div class="w-50">
                            <label for="annualIncome" class="me-2">Annual Income</label>
                            <input type="text" class="form-control" name="annualIncome" id="annualIncome" value="<?= (isset($_GET['edit'])) ? $data[0]['annual_income'] : '' ?>">
                        </div>
                    </div>
                    <div class="mb-2">
                        <label for="contactNo" class="me-2">Contact No</label>
                        <input type="text" class="form-control" name="contactNo" id="contactNo" value="<?= (isset($_GET['edit'])) ? $data[0]['contact_no'] : '' ?>">
                    </div>
                    <div class="mb-2">
                        <label for="studentImage" class="me-2">Student Image</label>
                        <input type="file" class="form-control" name="studentImage" id="studentImage">
                    </div>
                    <?php
                        if(isset($_GET['edit']) && $data[0]['student_image'] != ''){ ?>
                            <img src="<?= $data[0]['student_image'];?>" alt="" style="width: 100px; height: 100px;">
                    <?php } ?>
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
<?php
    include('footer.php');
?>