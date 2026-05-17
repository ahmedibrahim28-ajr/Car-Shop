<?php
include('../db_connection.php');    // Include the database connection file

// Get the table name from the query string and validate it
$table = isset($_GET['table']) ? $_GET['table'] : '';  // Ensure the table is set
$table = mysqli_real_escape_string(get_db_connection(), $table);  // Sanitize table name

// Function to fetch all records from the specified table
function get_records($table)
{
    $connection = get_db_connection();

    switch ($table) {
        case 'exterior':
            $query = "SELECT e.id, e.exteriortype, e.price, ei.exterior_image AS exterior_image_id
                      FROM exterior e
                      LEFT JOIN exterior_image ei ON e.exterior_image_id = ei.id";
            break;
        case 'technology':
            $query = "SELECT t.id, t.technology_type, t.price, ti.technology_image AS technology_image_id
                      FROM technology t
                      LEFT JOIN technology_image ti ON t.technology_image_id = ti.id";
            break;
        case 'wheels':
            $query = "SELECT w.id, w.wheel_type, w.price, wi.wheel_image AS image 
                      FROM wheels w
                      LEFT JOIN wheels_image wi ON w.wheel_image_id = wi.id";
            break;
        case 'car_model':
            $query = "SELECT cm.id, cm.car_name,cm.topspeed,cm.horsepower,cm.price,cm.in_stock,cmm.model AS models_car_model_id, cmi.car_model_image AS car_model_images_id
                      FROM car_model cm
                      LEFT JOIN car_model_image cmi ON cm.car_model_images_id = cmi.id
                      LEFT JOIN models cmm ON cm.models_car_model_id = cmm.id;";

            break;
        default:
            $query = "SELECT * FROM `$table`";
            break;
    }

    $result = mysqli_query($connection, $query);
    if (!$result) {
        die("Query failed: " . mysqli_error($connection));
    }

    $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
    close_db_connection($connection);
    return $data;
}



// Function to fetch column names of the selected table
function get_columns($table)
{
    $connection = get_db_connection();
    $query = mysqli_query($connection, "DESCRIBE `$table`");
    $columns = [];
    while ($row = mysqli_fetch_assoc($query)) {
        $columns[] = $row['Field'];  // Get column names
    }
    close_db_connection($connection);
    return $columns;
}

$data = get_records($table);
$columns = get_columns($table);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit <?= $table ?></title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="container">
        <aside class="sidebar">
            <h2>Tables</h2>
            <ul>
                <li><a href="index.php">Dash Board</a></li>
                <li><a href="edit_table.php?table=car_model">Car Model</a></li>
                <li><a href="edit_table.php?table=color">Color</a></li>
                <li><a href="edit_table.php?table=exterior">Exterior</a></li>
                <li><a href="edit_table.php?table=favourite_list">Favourite List</a></li>
                <li><a href="edit_table.php?table=interior_color">Interior Color</a></li>
                <li><a href="edit_table.php?table=models">Models</a></li>
                <li><a href="edit_table.php?table=technology">Technology</a></li>
            </ul>
        </aside>
        <main class="content">
            <h1>Edit <?= $table ?></h1>
            <a href="add.php?table=<?= $table ?>">Add New</a>
            <table border="1">
                <tr>
                    <?php foreach ($columns as $column): ?>
                        <th><?= ucfirst($column) ?></th>
                    <?php endforeach; ?>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
                <?php foreach ($data as $row): ?>
                    <tr>
                        <?php foreach ($columns as $column): ?>
                            <td>
                                <?php if ($column === 'image'): ?>
                                    <img src="<?= $row[$column] ?>" alt="Image" style="width:100px; height:auto;">
                                <?php else: ?>
                                    <?= $row[$column] ?>
                                <?php endif; ?>
                            </td>
                        <?php endforeach; ?>
                        <td><a href="edit.php?id=<?= $row['id'] ?>&table=<?= $table ?>">Edit </a></td>

                        <td><a href="delete.php?id=<?= $row['id'] ?>&table=<?= $table ?>">Delete</a></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </main>
    </div>
</body>

</html>