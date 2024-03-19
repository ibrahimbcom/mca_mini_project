<?php
    include('db_config.php');
    if(isset($_POST['form']) && $_POST['form'] == "teacherStatusChange"){
        $id = $_POST['id'];
        $status = ($_POST['status'] == 1) ? 0 : 1;
        $upd_qry = "UPDATE users SET `status` = $status WHERE id = $id AND `role` = 2";
        $update = update($conn,$upd_qry);
        if($update){
            if($status == 1){
                echo "Teacher Activated Successfully";
            }else{
                echo "Teacher Deactivated Successfully";
            }
        }else{
            echo "Something occured. we can't update";
        }
    }

    if(isset($_POST['form']) && $_POST['form'] == "studentDelete"){
        $id = $_POST['id'];
        $upd_qry = "UPDATE users SET `status` = 0 WHERE id = $id AND `role` = 3";
        $update = update($conn,$upd_qry);
        $get_student = select($conn,"SELECT student_image FROM students WHERE user_id = $id");
        if(file_exists($get_student[0]['student_image'])){
            unlink($get_student[0]['student_image']);
        }
        $delete =  delete($conn,"DELETE FROM students WHERE user_id = $id");
        if($delete){
            echo "Student Deleted Successfully";
        }else{
            echo "Something occured. we can't delete";
        }
    }

    if(isset($_POST['form']) && $_POST['form'] == "teacherUpdate"){
        $teacher_user_id = $_POST['teacher_user_id'];
        $name = $_POST['name'];
        // $class_taken = implode(",",$classTaken);
        $gender = $_POST['gender'];
        $contact = $_POST['contact'];
        $address = $_POST['address'];

        $upd_qry = "UPDATE users SET `name` = '$name' WHERE id = $teacher_user_id AND `role` = 2";
        $update = update($conn,$upd_qry);
        
        $teacher_upd_qry = "UPDATE teachers SET `teacher_name` = '$name',`gender` = '$gender',`contact_no` = '$contact',`address` = '$address' WHERE user_id = $teacher_user_id";

        $teacher_upd = update($conn,$teacher_upd_qry);
        
        if($teacher_upd){
            echo "Teacher Updated Successfully";
        }else{
            echo "Something occured. we can't update";
        }
    }
?>