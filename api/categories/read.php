<?php
// declare(strict_types=1);
// ini_set('error_reporting', E_ALL);
// ini_set('display_errors', 1);
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Category.php';

//Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate blog category$category object
$category = new Category($db);

//Blog category$category query
$result = $category->read();
//Get Row Count
$num = $result->rowCount();

// Check if any category$categorys
if ($num > 0) {
    // category$category array
    $categorys_arr = array();
    // $categorys_arr['data'] = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $category_item = array(
            'id' => $id,
            'category' => $category,
        );

        // Push to "data"
        array_push($categorys_arr, $category_item);
        // array_push($categorys_arr['data'], $category_item);
    }

    // Turn to JSON & output
    echo json_encode($categorys_arr);

} else {
    // No category$categorys
    echo json_encode(
        array('message' => 'No category$categorys Found')
    );
}
