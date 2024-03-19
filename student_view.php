<?php
    $title = "Student View";
    $student = "active";
    include('admin_header.php');
    if(isset($_GET['view'])){
        $id = $_GET['view'];
        $data = select($conn,"SELECT s.*,u.email FROM students AS s INNER JOIN users AS u ON s.user_id = u.id  WHERE s.id = $id");
    }
?>
<!-- Main Content Here -->
<div class="container-fluid " style="position: relative; z-index: 10;">
    <div class="row">
        <div class="col-9 ms-3 mt-4">
            <table class="table table-bordered" style="height: 90vh; overflow:auto;">
                <tr>
                    <th width="300" class="bg-secondary text-light text-center">Student's Image</th>
                    <td><img src="<?= $data[0]['student_image'];?>" alt="student image" style="width: 100px; height: 100px;"></td>
                </tr>
                <tr>
                    <th width="300" class="bg-secondary text-light text-center">Student's Name</th>
                    <td><?= $data[0]['student_name'];?></td>
                </tr>
                <tr>
                    <th width="300" class="bg-secondary text-light text-center">Class</th>
                    <td><?= getClass($conn,$data[0]['class']);?></td>
                </tr>
                <tr>
                    <th width="300" class="bg-secondary text-light text-center">Roll No</th>
                    <td><?= $data[0]['roll_no'];?></td>
                </tr>
                <tr>
                    <th width="300" class="bg-secondary text-light text-center">Date of Birth</th>
                    <td><?= $data[0]['dob'];?></td>
                </tr>
                <tr>
                    <th width="300" class="bg-secondary text-light text-center">Gender</th>
                    <td><?= $data[0]['gender'];?></td>
                </tr>
                <tr>
                    <th width="300" class="bg-secondary text-light text-center">Father Name</th>
                    <td><?= $data[0]['father_name'];?></td>
                </tr>
                <tr>
                    <th width="300" class="bg-secondary text-light text-center">Mother Name</th>
                    <td><?= $data[0]['mother_name'];?></td>
                </tr>
                <tr>
                    <th width="300" class="bg-secondary text-light text-center">Contact No</th>
                    <td><?= $data[0]['contact_no'];?></td>
                </tr>
                <tr>
                    <th width="300" class="bg-secondary text-light text-center">Address</th>
                    <td><?= $data[0]['address'];?></td>
                </tr>
                <tr>
                    <th width="300" class="bg-secondary text-light text-center">Annual Income</th>
                    <td><?= $data[0]['annual_income'];?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
<?php
include('footer.php');
?>