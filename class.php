<?php
    $title = "Class";
    $class = "active";
    include('admin_header.php');
    if(!isset($_SESSION['role']) || $_SESSION['role'] != 1) {
        header('location: index.php');
    }
    
    if(isset($_POST['className'])){
        $class = strtoupper(trim($_POST['className']));
        $insert_class = "INSERT INTO class (class_name) VALUES ('$class')";
        $insert = create($conn,$insert_class);
    }

    $get_class_qry = "SELECT * FROM class";
    $getClass = select($conn,$get_class_qry);
    
?>
<!-- Main Content Here -->
<div class="container-fluid " style="position: relative; z-index: 10;">
    <div class="row">
        <div class="col-9 ms-3">
            <div class="form mt-3">
                <form action="" method="POST" name="classAdd">
                    <label for="className" class="me-2">Class Name</label>
                    <div class="d-flex align-items-start  col-12">
                        <div>
                            <input type="text" name="className" id="className" class="form-control me-2 p-1" placeholder="Enter Class Name" style="width: 300px;"/>
                        </div>
                        <input type="submit" value="Add Class" class="btn btn-sm btn-info ms-2"> 
                    </div>
                </form>
            </div>
            <hr>
            <div class="mt-5">
                <table id="dataTable" class="table row-border text-start">
                    <thead>
                        <tr>
                            <th>S.no</th>
                            <th>Class name</th>
                            <th>No of students</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if(count($getClass) > 0) {
                                $i=1;
                                foreach ($getClass as $class) {
                                
                        ?>
                        <tr>
                            <td><?php echo $i++; ?></td>
                            <td><?php echo $class['class_name']; ?></td>
                            <td><?php $id = $class['id']; echo getStdCount($conn,$id); ?></td>
                        </tr>
                        
                        <?php
                            }}else{
                        ?>
                        <tr>
                            <td colspan="3">No record found.</td>
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
</script>
<?php
    include('footer.php');
?>