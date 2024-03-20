<?php
    // echo($_SERVER['REQUEST_METHOD']);

// Check the request method
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // If it's a GET request, include read.php
    if (isset($_GET['id'])) {
        // Get the value of the id parameter
        $id = $_GET['id'];
        include('read_single.php');
        
        // Now you can use $id in your logic
        // echo "ID parameter value: " . $id;
    } else {
        // Handle the case when id parameter is not present
        include('read.php');

    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include('create.php');
} elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    include('delete.php');
} elseif ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    include('update.php');
} else {
    // Handle other request methods as needed
    http_response_code(405); // Method Not Allowed
    echo "Method not allowed";
}
