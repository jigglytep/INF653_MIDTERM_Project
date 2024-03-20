<?php
// declare(strict_types=1);
// ini_set('error_reporting', E_ALL);
// ini_set('display_errors', 1);
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Quote.php';

//Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate blog quote$quote object
$quote = new Quote($db);

//Blog quote$quote query
$result = $quote->read();
//Get Row Count
$num = $result->rowCount();

// Check if any quote$quotes
if ($num > 0) {
    // quote$quote array
    $quotes_arr = array();
    // $quotes_arr['data'] = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $quote_item = array(
            'id' => $id,
            'quote' => $quote,
            'author'=>$author,
            'category'=>$category
        );

        // Push to "data"
        array_push($quotes_arr, $quote_item);
        // array_push($quotes_arr['data'], $quote_item);
    }

    // Turn to JSON & output
    echo json_encode($quotes_arr);

} else {
    // No quote$quotes
    echo json_encode(
        array('message' => 'No Quotes Found')
    );
}
