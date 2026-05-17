<?php
include '../../db_connection.php';

// Function to upload an image and return the filename
function upload_image($input_name) {
    $filename = $_FILES[$input_name]["name"];
    $tempname = $_FILES[$input_name]["tmp_name"];
    $folder = "../../porcshe/images" . $filename;

    
    if (move_uploaded_file($tempname, $folder)) {
        return $filename; 
    } else {
        echo "<h3>&nbsp; Failed to upload image!</h3>";
        return null;
    }
}
?>