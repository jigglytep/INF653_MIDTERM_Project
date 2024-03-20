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

// Instantiate blog category object
$category = new Category($db);


//GET ID
$category->id = isset($_GET['id']) ? $_GET['id'] : die();

//Get category
$category->read_single();

//Create array



if (is_null($category->id)){
    $category_arr = array(
        'message'=> 'category_id Not Found'
    );
}else{
    $category_arr = array(
        'id' => $category->id,
        'category' => $category->category
    
    );
}
//Make JSON
print_r(json_encode($category_arr));
