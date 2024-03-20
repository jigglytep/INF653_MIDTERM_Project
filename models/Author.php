<?php
// declare(strict_types=1);
// ini_set('error_reporting', E_ALL);
// ini_set('display_errors', 1);
class Author
{
    private $conn;
    private $table = "authors";
    public $id;
    public $author;

    //Constructor with DB
    public function __construct($db)
    {
        $this->conn = $db;
    }

    //Get Posts
    public function read()
    {
        //Create query
        $query = 'SELECT id, author FROM "'.$this->table. '" ORDER BY id ;';


        //Prepared statements
        $stmt = $this->conn->prepare($query);

        //Execute query
        $stmt->execute();
        return $stmt;
    }

    public function read_single()
    {
        $query = 'SELECT id, author FROM "' . $this->table . '" WHERE id = :id LIMIT 1;';



        //Prepared statements
        $stmt = $this->conn->prepare($query);

        //Bind ID
        $stmt->bindParam(':id', $this->id);

        //Execute query
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        //set properties
        $this->author = $row['author'] ?? null;
        $this->id = $row['id'] ?? null;
        return $stmt;

    }

    public function create()
    {
        try {
            $query = 'INSERT INTO public.authors (author)
        VALUES (:author)';

        //Prepare Statement
        $stmt = $this->conn->prepare($query);

        //Clean Data
        $this->author = htmlspecialchars(strip_tags($this->author));
        // echo $this->category_id;
        //Bind Data
        if (is_null($this->author)){
            return false;
        }

        $stmt->bindParam(':author', $this->author);
        
        //Execute query
        if ($stmt->execute()) {
            return true;
        }
        //code...
        } catch (Throwable $th) {
        //throw $th;
            return false;
        }
        
        // Print Error
        printf("Error: %s.\n", $stmt->error);

        return false;



    }

    public function update()
    {

        $query = 'UPDATE ' . $this->table . ' SET 
                    author=:author WHERE id = :id;';

        //Prepare Statement
        $stmt = $this->conn->prepare($query);

        //Clean Data
        $this->author = htmlspecialchars(strip_tags($this->author));
        $this->id = htmlspecialchars(strip_tags($this->id));
        if (is_null($this->author)){
            return false;
        }
        if (is_null($this->id)){
            return false;
        }

        //Bind Data
        $stmt->bindParam(':author', $this->author);
        $stmt->bindParam(':id', $this->id);
        //Execute query
        try {
            $stmt->execute();
            return true;
        } catch (Throwable $th) {
            printf("Error: %s.\n", $stmt->error);
        }
        // Print Error

        return false;



    }

    //Delete Post
    public function delete()
    {
        //Create query
        $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';
        
        //Prepare Statement
        $stmt = $this->conn->prepare($query);
        //Clean Data
        $this->id = htmlspecialchars(strip_tags($this->id));
        $result = $this->read();
            $result->rowCount();
            if($result == 0){
                return false;
            }
            
        //Bind Data
        $stmt->bindParam(':id', $this->id);
        //Execute Query
        if ($stmt->execute()) {
            return true;
        }
        printf('Error: %s. \n', $stmt->error);
        return false;
    }
}//class