<?php
// declare(strict_types=1);
// ini_set('error_reporting', E_ALL);
// ini_set('display_errors', 1);
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Author.php';

//Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate blog author object
$author = new Author($db);

//Blog author query
$result = $author->read();
//Get Row Count
$num = $result->rowCount();

// Check if any authors
if ($num > 0) {
    // author array
    $authors_arr = array();
    // $authors_arr['data'] = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $author_item = array(
            'id' => $id,
            'author' => $author,
        );

        // Push to "data"
        array_push($authors_arr, $author_item);
        // array_push($authors_arr['data'], $author_item);
    }

    // Turn to JSON & output
    echo json_encode($authors_arr);

} else {
    // No authors
    echo json_encode(
        array('message' => 'No authors Found')
    );
}
