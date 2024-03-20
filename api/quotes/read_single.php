<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Quote.php';

//Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate blog Quote object
$quote = new Quote($db);


//GET ID
$quote->id = isset($_GET['id']) ? $_GET['id'] : die();

//Get category
$quote->read_single();

//Create array



if (is_null($quote->id)){
    $quote_arr = array(
        'message'=> 'No Quotes Found'
    );
}else{
    $quote_arr = array(
        'id' => $quote->id,
        'quote' => $quote->quote,
        'author'=>$quote->author_id,
        'category'=>$quote->category_id
    );
}
//Make JSON
// print_r(json_encode($quote));
// Turn to JSON & output
echo json_encode($quote_arr);
