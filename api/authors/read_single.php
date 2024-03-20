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


//GET ID
$author->id = isset($_GET['id']) ? $_GET['id'] : die();

//Get author
$author->read_single();

//Create array
if (is_null($author->id)){
    $author_arr = array(
        'message'=> 'author_id Not Found'
    );
}else{
    $author_arr = array(
        'id' => $author->id,
        'author' => $author->author
    
    );
}

//Make JSON
print_r(json_encode($author_arr));
