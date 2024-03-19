<?php
    $title = "Student Dashboard";
    $home = "active";
    include('admin_header.php');
    if(!isset($_SESSION['role']) || $_SESSION['role'] != 3) {
        header('location: index.php');
    }
    $get_class_qry = "SELECT * FROM class";
    $getClass = select($conn,$get_class_qry);

    $data = select($conn,"SELECT s.*,u.email FROM students AS s INNER JOIN users AS u ON s.user_id = u.id  WHERE s.user_id = $user_id");
    $student = $data[0];
?>
<!-- Main Content Here -->
<div class="container-fluid " style="position: relative; z-index: 10;">
    <div class="row">
        <div class="col-9 ms-3 mt-4">
            <table class="table table-bordered">
                <tr>
                    <th width="300" class="bg-secondary text-light">Student's Name</th>
                    <td><?= $student['student_name'];?></td>
                </tr>
                <tr>
                    <th width="300" class="bg-secondary text-light">Gender</th>
                    <td><?= $student['gender'];?></td>
                </tr>
                <tr>
                    <th width="300" class="bg-secondary text-light">Class</th>
                    <td><?= getClass($conn,$student['class']);?></td>
                </tr>
                <tr>
                    <th width="300" class="bg-secondary text-light">Roll No</th>
                    <td><?= $student['roll_no']?></td>
                </tr>
                <tr>
                    <th width="300" class="bg-secondary text-light">Date of birth</th>
                    <td><?= $student['dob'];?></td>
                </tr>
                <tr>
                    <th width="300" class="bg-secondary text-light">Father Name</th>
                    <td><?= $student['father_name'];?></td>
                </tr>
                <tr>
                    <th width="300" class="bg-secondary text-light">Mother Name</th>
                    <td><?= $student['mother_name'];?></td>
                </tr>
                <tr>
                    <th width="300" class="bg-secondary text-light">Contact No</th>
                    <td><?= $student['contact_no'];?></td>
                </tr>
                <tr>
                    <th width="300" class="bg-secondary text-light">Address</th>
                    <td><?= $student['address'];?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
<?php
include('footer.php');
?>