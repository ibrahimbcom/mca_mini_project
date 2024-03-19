<?php
    $title = "Teacher";
    $teacher = "active";
    include('admin_header.php');

    if($role != 3){
        $get_teacher_qry = "SELECT t.*,u.status FROM teachers AS t INNER JOIN users AS u ON t.user_id = u.id WHERE u.role = 2";
        $getTeacher = select($conn,$get_teacher_qry);
    }else{
        $getStdCls = select($conn, "SELECT class FROM students WHERE user_id = $user_id");
        $std_class = $getStdCls[0]['class'];
        $get_teacher_qry = "SELECT t.*,u.status FROM teachers AS t INNER JOIN users AS u ON t.user_id = u.id WHERE FIND_IN_SET($std_class, t.class_taking) > 0 AND u.role = 2 AND u.status = 1";
        $getTeacher = select($conn,$get_teacher_qry);
    }
?>
<!-- Main Content Here -->
<div class="container-fluid " style="position: relative; z-index: 10;">
    <div class="row">
        <div class="col-9 ms-3">
            <div class="mt-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><?= ($role != 3) ? "Manage" : "My Class "?> Teachers</h5>
                <?php if($role == 1){ ?>
                <a href="teacher_add.php" class="btn btn-primary">+ Add Teacher</a>
                <?php }?>
            </div>
            <hr class="my-2">
            <div class="mt-3">
                <table id="dataTable" class="table row-border text-start">
                    <thead>
                        <tr>
                            <th>S.no</th>
                            <th>Teacher name</th>
                            <th>Class taken</th>
                            <th>Gender</th>
                            <th>Contact no</th>
                            <th>Address</th>
                            <th>Status</th>
                            <?php if($role == 1){ ?>
                                <th>Action</th>
                            <?php }?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if(count($getTeacher) > 0) {
                                $i=1;
                                foreach ($getTeacher as $teacher) {
                                
                        ?>
                        <tr>
                            <td><?= $i++ ?></td>
                            <td><?= $teacher['teacher_name'] ?></td>
                            <td><?= getClass($conn,$teacher['class_taking']) ?></td>
                            <td><?= $teacher['gender'] ?></td>
                            <td><?= $teacher['contact_no'] ?></td>
                            <td><?= $teacher['address'] ?></td>
                            <td><?= ($teacher['status'] == 1) ? "Active" : "Inactive" ?></td>
                            <?php if($role == 1){ ?>
                            <td>
                                <a href="teacher_add.php?edit=<?= $teacher['id'] ?>" class="btn btn-sm btn-info">edit</a>
                                <?php
                                    if($teacher['status'] == 1){
                                        ?>
                                        <a href="#" data-id="<?=$teacher['user_id']?>" data-status="<?=$teacher['status']?>" class="btn btn-sm btn-danger status-change">Deactivate</a>
                                        <?php
                                    }else{
                                        ?>
                                        <a href="#" data-id="<?=$teacher['user_id']?>" data-status="<?=$teacher['status']?>" class="btn btn-sm btn-success status-change">Activate</a>
                                        <?php
                                    }
                                ?>
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
                            <?php if($role ==1){?>
                            <td></td>
                            <?php }?>
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
        $(document).on('click','.status-change', function(e){
            e.preventDefault()
            let id = $(this).data('id');
            let status = $(this).data('status');
            $.ajax({
                url: 'ajaxCall.php',
                type: 'post',
                data: {'form':'teacherStatusChange','id':id,'status':status},
                success: function(response){
                    alert(response)
                    location.reload();
                },
                error: function(error){
                    alert(error)
                }
            })
        });
    });
</script>
<?php
    include('footer.php');
?>