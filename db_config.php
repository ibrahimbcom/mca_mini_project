<?php
    session_start();
    $server = "localhost";
    $username = "root";
    $password = "";
    $database = "mca_mini_project_sms";

    $conn = new mysqli($server,$username,$password,$database);
    if($conn->connect_error){
        echo "connection error : ".$conn->connect_error;
    }else{
        function create($conn,$query){
            $result = $conn->query($query);
            if($result){
                return 1;
            }else{
                return 0;
            }
        }
        function select($conn,$query){
            $result = $conn->query($query);
            if($result){
                $data = $result->fetch_all(MYSQLI_ASSOC);
                return $data;
            }else{
                return 0;
            }
        }

        function selectUserIdFromTeacher($conn,$id){
            $query = "SELECT user_id FROM teachers WHERE id = $id";
            $result = $conn->query($query);
            if($result){
                $data = $result->fetch_all(MYSQLI_ASSOC);
                return $data;
            }else{
                return 0;
            }
        }
     
        function selectUserIdFromStudent($conn,$id){
            $query = "SELECT user_id FROM students WHERE id = $id";
            $result = $conn->query($query);
            if($result){
                $data = $result->fetch_all(MYSQLI_ASSOC);
                return $data;
            }else{
                return 0;
            }
        }

        function checkExist($conn,$query){
            $result = $conn->query($query);
            if($result){
                $data = $result->num_rows;
                return $data;
            }else{
                return 0;
            }
        }
        
        function update($conn,$query)
        {
            $data = $conn->query($query);
            if($data)
                return 1;
            else
                return 0;
        }
        
        function delete($conn,$query)
        {
            $data = $conn->query($query);
            if($data)
                return 1;
            else
                return 0;
        }
        
        function getStdCount($conn,$class){
            $query = "SELECT s.id FROM students AS s,users AS u WHERE class = $class AND u.id = s.user_id AND u.role = 3 AND u.status = 1";
            $result = $conn->query($query);
            if($result){
                $data = $result->num_rows;
                return $data;
            }else{
                return 0;
            }
        }
        
        function getClass($conn,$class){
            $query = "SELECT class_name FROM class WHERE id IN($class)";
            $result = $conn->query($query);
            if($result){
                $data = $result->fetch_all(MYSQLI_ASSOC);
                $classes = '';
                foreach ($data as $cls) {
                    $classes .=", ".$cls['class_name'];
                }
                return trim($classes, ", ");
            }else{
                return 0;
            }
        }
    }
?>