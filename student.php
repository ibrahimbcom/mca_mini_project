<?php
    $title = "Student";
    $student = "active";
    include('admin_header.php');

    if($role == 2)
    {
        $teacherGet = select($conn,"SELECT class_taking FROM teachers WHERE user_id = $user_id");
        $class_taking = $teacherGet[0]['class_taking'];
        $class_qry = " AND class IN($class_taking)";
    }else{
        $class_qry = '';
    }

    if($role != 3){
        $get_student_qry = "SELECT s.*,u.status FROM students AS s INNER JOIN users AS u ON s.user_id = u.id WHERE u.role = 3 $class_qry";
        $getStudent = select($conn,$get_student_qry);
    }else{
        $getStdCls = select($conn, "SELECT class FROM students WHERE user_id = $user_id");
        $std_class = $getStdCls[0]['class'];

        $get_student_qry = "SELECT s.*,u.status FROM students AS s INNER JOIN users AS u ON s.user_id = u.id WHERE FIND_IN_SET($std_class, s.class) > 0 AND u.role = 3 $class_qry";
        $getStudent = select($conn,$get_student_qry);

    }
?>
<!-- Main Content Here -->
<div class="container-fluid " style="position: relative; z-index: 10;">
    <div class="row">
        <div class="col-9 ms-3">
            <div class="mt-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><?= ($role != 3) ? "Manage" : "My Class"?> Students</h5>
                <?php
                    if($role != 3){
                ?>
                <a href="student_add.php" class="btn btn-primary">+ Add Student</a>
                <?php }?>
            </div>
            <hr class="my-2">
            <div class="mt-3">
                <table id="dataTable" class="table row-border text-start">
                    <thead>
                        <tr>
                            <th>S.no</th>
                            <th>Student name</th>
                            <th>Class</th>
                            <th>Roll no</th>
                            <th>DOB</th>
                            <th>Gender</th>
                            <?php
                                if($role != 3){
                            ?>
                            <th>Action</th>
                            <?php }?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if(count($getStudent) > 0) {
                                $i=1;
                                foreach($getStudent as $student) {
                                
                        ?>
                        <tr>
                            <td><?= $i++ ?></td>
                            <td><?= $student['student_name'] ?></td>
                            <td><?= getClass($conn,$student['class']) ?></td>
                            <td><?= $student['roll_no'] ?></td>
                            <td><?= $student['dob'] ?></td>
                            <td><?= $student['gender'] ?></td>
                            <?php
                                if($role != 3){
                            ?>
                            <td>
                                <a href="student_view.php?view=<?= $student['id'] ?>" class="btn btn-sm btn-primary">View</a>
                                <a href="student_add.php?edit=<?= $student['id'] ?>" class="btn btn-sm btn-info">edit</a>
                                <a href="#" data-id="<?=$student['user_id']?>" class="btn btn-sm btn-danger delete-student">Delete</a>
                            </td>
                            <?php }?>
                        </tr>
                        
                        <?php
                            }}else{
                        ?>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>No record found.</td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <?php
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    $('#dataTable').DataTable();
    $(document).ready(function(){
        $(document).on('click','.delete-student', function(e){
            e.preventDefault()
            if(confirm('Do you want to delete this student?')){
                let id = $(this).data('id');
                $.ajax({
                    url: 'ajaxCall.php',
                    type: 'post',
                    data: {'form':'studentDelete','id':id},
                    success: function(response){
                        alert(response)
                        location.reload();
                    },
                    error: function(error){
                        alert(error)
                    }
                })
            }
        });
    });
</script>
<?php
    include('footer.php');
?>