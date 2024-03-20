<?php
// declare(strict_types=1);
// ini_set('error_reporting', E_ALL);
// ini_set('display_errors', 1);
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, quoteization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Quote.php';

// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate blog quote object
$quote = new Quote($db);

// Get raw posted data
$data = json_decode(file_get_contents("php://input"));
// echo "id isi : ".$data->id;
//Set ID to update
$quote->id = $data->id?? null;

// Create quote
if ($quote->delete()) {
    echo json_encode(
        array('message' => 'quote Deleted')
    );
} else {
    echo json_encode(
        
        array("message" => "No Quotes Found")
        
    );
}