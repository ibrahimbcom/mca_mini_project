<?php
    $title = "Teacher's Dashboard";
    $home = "active";
    include('admin_header.php');
    if(!isset($_SESSION['role']) || $_SESSION['role'] != 2) {
        header('location: index.php');
    }
    $get_class_qry = "SELECT * FROM class";
    $getClass = select($conn,$get_class_qry);

    $data = select($conn,"SELECT t.*,u.email FROM teachers AS t INNER JOIN users AS u ON t.user_id = u.id  WHERE t.user_id = $user_id");
    $teacher = $data[0];
?>
<!-- Main Content Here -->
<div class="container-fluid " style="position: relative; z-index: 10;">
    <div class="row">
        <div class="col-9 ms-3 mt-4">
            <div class="text-end mb-2">
                <a href="#" id="editBtn" class="btn btn-sm btn-primary">Edit</a>
            </div>
            <form action="" method="POST" name="teacher_self_update">
                <table class="table table-bordered">
                    <tr>
                        <th class="bg-secondary text-light">Teacher's Name</th>
                        <td><input type="text" name="name" class="form-control" value="<?= $teacher['teacher_name'];?>" disabled id="name"><input type="hidden" id="teacher_user_id" name="teacher_user_id" value="<?= $user_id;?>"></td>
                    </tr>
                    <tr>
                        <th class="bg-secondary text-light">Gender</th>
                        <td><input type="radio" name="gender" value="Male" id="male" <?= ($teacher['gender'] == 'Male') ? 'checked' :'';?> disabled><label for="male" class="me-2">Male</label><input type="radio" name="gender" value="Female" id="female"  <?= ($teacher['gender'] == 'Female') ? 'checked' :'';?> disabled><label for="female">Female</label></td>
                    </tr>
                    <!-- <tr>
                        <th class="bg-secondary text-light">Classes taking</th>
                        <td>
                        <select data-placeholder="Select class taken" multiple class="chosen-select form-select " name="classTaken[]" id="classTaken" disabled>
                            <?php foreach ($getClass as $class) { ?>
                                <option value="<?php echo $class['id']?>" <?php $cls =explode(',',$teacher['class_taking']); 
                                echo (in_array($class['id'],$cls) ? 'selected' : '') ?>><?php echo $class['class_name'];?></option>
                            <?php }?>
                        </select>
                        </td>
                    </tr> -->
                    <tr>
                        <th class="bg-secondary text-light">Contact No</th>
                        <td><input type="text" name="contact" id="contact" class="form-control" value="<?= $teacher['contact_no'];?>" disabled></td>
                    </tr>
                    <tr>
                        <th class="bg-secondary text-light">Address</th>
                        <td><textarea name="address" id="address" class="form-control" disabled><?= $teacher['address'];?></textarea></td>
                    </tr>
                </table>
                <div class="text-end">
                    <input type="submit" value="Update" id="updateBtn" class="btn btn-sm btn-primary" style="display: none;">
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).on('click', '#editBtn', function() {
        $(document).find('input').removeAttr('disabled');
        $(document).find('textarea').removeAttr('disabled');
        $(this).text('x cancel');
        $(this).attr('id','cancelBtn');
        $(this).removeClass('btn-primary');
        $(this).addClass('btn-danger');
        $('#updateBtn').show();
    });
    
    $(document).on('click', '#cancelBtn', function() {
        $(document).find('input').attr('disabled',true);
        $(document).find('textarea').attr('disabled',true);
        $(this).attr('id','editBtn');
        $(this).text('Edit');
        $(this).removeClass('btn-danger');
        $(this).addClass('btn-primary');
        $('#updateBtn').hide();
    });

    $(document).on('click','#updateBtn', function(e){
        e.preventDefault();
        let name = $('#name').val();
        let teacher_user_id = $('#teacher_user_id').val();
        let gender = $("input[name='gender']").val();
        let contact = $('#contact').val();
        let address = $('#address').val();

        if(confirm('Do you want to update?')){
            $.ajax({
                url: 'ajaxCall.php',
                type: 'post',
                data: {'form':'teacherUpdate','name':name,'teacher_user_id':teacher_user_id,'gender':gender,'contact':contact,'address':address},
                success: function(response){
                    alert(response)
                    location.reload();
                },
                error: function(error){
                    alert(error)
                }
            });
        }
    })

</script>
<link rel="stylesheet" href="plugins/chosen_multiselect/docsupport/prism.css">
<link rel="stylesheet" href="plugins/chosen_multiselect/chosen.css">
<script src="plugins/chosen_multiselect/chosen.jquery.js" type="text/javascript"></script>
<script>
     $(".chosen-select").chosen({no_results_text: "Oops, nothing found!"}); 
</script>
<?php
include('footer.php');
?>