<?php

if(isset($_FILES['file1'])){
	move_uploaded_file( $_FILES['file1']['tmp_name'], "files/" . 	basename($_FILES['file1']['name']));
    
    if(isset($_FILES['file2']))
        move_uploaded_file( $_FILES['file2']['tmp_name'], "files/" . 	basename($_FILES['file2']['name']));
	
    echo "success";
}

else
    header("location:/");

?>