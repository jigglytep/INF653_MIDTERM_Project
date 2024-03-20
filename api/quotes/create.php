<?php
declare(strict_types=1);
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, quotesization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Quote.php';

// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate blog post object
$quote = new Quote($db);

// Get raw quotesed data
$data = json_decode(file_get_contents("php://input"));


$quote->quote = $data->quote ?? null;
$quote->author = $data->author_id ?? null;
$quote->category = $data->category_id ?? null;



// Create quote
if ($quote->create()) {
    echo json_encode(
        array('message' => 'Quote Created')
    );
} else {
    echo json_encode(
        array('message' => 'Missing Required Parameters' )
    );
}