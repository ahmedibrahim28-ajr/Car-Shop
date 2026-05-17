<?php

include('../db_connection.php');

// Check if 'id' and 'table' are set in the URL
if (isset($_GET["id"]) && isset($_GET["table"])) {
    
    $id = intval($_GET["id"]);  
    $table = mysqli_real_escape_string(get_db_connection(), $_GET["table"]);  
    $connection = get_db_connection();

    $allowed_tables = ['car_model', 'color', 'exterior', 'favourite_list', 'wheels', 'technology', 'interior_color','models'];

    if (in_array($table, $allowed_tables)) {
        
        $query = "DELETE FROM `$table` WHERE `id` = $id";

        // Execute the query
        $result = mysqli_query($connection, $query);

        
        if (mysqli_affected_rows($connection) > 0) {
           
            echo "<script>
                    alert('Data deleted successfully!');
                    window.history.back()
                    setTimeout(function() {
                        location.reload();  // Refresh the page after going back
                    }, 100);
                  </script>";
            exit();  
        } else {
            echo "Error: Could not delete the record or record might not exist";
        }
    } else {
        echo "Invalid table specified";
    }

    // Close the connection
    mysqli_close($connection);
} else {
    echo "Error: Missing required parameters. Please ensure 'id' and 'table' are included in the URL.";
}

?>
