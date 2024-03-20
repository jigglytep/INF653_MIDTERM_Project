<?php
// Headers
// declare(strict_types=1);
// ini_set('error_reporting', E_ALL);
// ini_set('display_errors', 1);
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Author.php';

// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate blog post object
$author = new Author($db);

// Get raw authored data
$data = json_decode(file_get_contents("php://input"));


$author->author = $data->author ?? null;
$nullTest = $data->author ?? null;

if (is_null($nullTest)){
    echo json_encode(
        array('message' => "Missing Required Parameters")
    );
}else{
    $result = $author->create();
    if ($result) {
        echo json_encode(
            array(
                'message' => 'create author ('.$db->lastInsertId().' , '.$author->author.')'
                    )
            );
    } else {
        echo json_encode(
            array('message' => "Missing Required Parameters")
        );
    }
}