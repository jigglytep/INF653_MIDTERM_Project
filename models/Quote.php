<?php
// declare(strict_types=1);
// ini_set('error_reporting', E_ALL);
// ini_set('display_errors', 1);
class Quote
{
    private $conn;
    private $table = "quotes";
    public $id;
    public $category_id;
    public $author_id;
    public $quote;

    //Constructor with DB
    public function __construct($db)
    {
        $this->conn = $db;
    }

    //Get Posts
    public function read()
    {
        //Create query
        $query = 'SELECT q.id, quote, a.author, cat.category
                        FROM '.$this->table.' q
                    LEFT JOIN 
                        authors a ON q.author_id = a.id
                    LEFT JOIN
                        categories cat ON q.category_id = cat.id;';



        //Prepared statements
        $stmt = $this->conn->prepare($query);

        //Execute query
        $stmt->execute();
        return $stmt;
    }

    public function read_single()
    {
        $query = 'SELECT q.id, quote, a.author, cat.category
                    FROM '.$this->table.' q
                LEFT JOIN 
                    authors a ON q.author_id = a.id
                LEFT JOIN
                    categories cat ON q.category_id = cat.id
                    WHERE q.id = :id LIMIT 1;';

        //Prepared statements
        $stmt = $this->conn->prepare($query);

        //Bind ID
        $stmt->bindParam(':id', $this->id);

        //Execute query
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        //set properties
        $this->category_id = $row['category'] ?? null;
        
        $this->author_id= $row['author']?? null;
        $this->quote= $row['quote']?? null;
        $this->id = $row['id']?? null;
        return $stmt;
    }

    public function create()
    {
        try {
            $query = 'INSERT INTO public.quotes( quote, author_id, category_id)	VALUES 
        (:quote,:author,:category) ;';

        //Prepare Statement
        $stmt = $this->conn->prepare($query);
        
        //Clean Data
        $this->category = htmlspecialchars(strip_tags($this->quote))?? null;
        $this->author = htmlspecialchars(strip_tags($this->author))?? null;
        $this->category= htmlspecialchars(strip_tags($this->category))?? null;
        echo $this->category_id;

        if (is_null($this->category)) {
            return false;
            }
            elseif (is_null($this->author)) {
                return false;
                }

                elseif (is_null($this->quote)) {
                    return false;
                    }


        echo $this->category_id;
        //Bind Data
        // echo($this->category);
        
        $stmt->bindParam(':quote', $this->quote);
        $stmt->bindParam(':author', $this->author);
        $stmt->bindParam(':category', $this->category);
        
        
        //Execute query
        if ($stmt->execute()) {
            return true;
        }
        return false;
            //code...
        } catch (\Throwable $th) {
            //throw $th;
            return false;
        }
        
        // Print Error
        printf("Error: %s.\n", $stmt->error);




    }

    public function update()
    {

        $query = 'UPDATE ' . $this->table . ' SET 
                quote= :quote, 
                author_id= :author_id, 
                category_id= :category_id
                WHERE id = :id;';
        //Prepare Statement
        $stmt = $this->conn->prepare($query);


        //Clean Data
        $this->id= htmlspecialchars(strip_tags($this->id));
        $this->quote = htmlspecialchars(strip_tags($this->quote));
        $this->author = htmlspecialchars(strip_tags($this->author));
        $this->category= htmlspecialchars(strip_tags($this->category));

        echo ":category ".$this->category;
        echo ":author ".$this->author;

        //Bind Data
        $stmt->bindParam(':id',         $this->id);
        $stmt->bindParam(':quote',      $this->quote);
        $stmt->bindParam(':author',     $this->author);
        $stmt->bindParam(':category',   $this->category);
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
        try {
            //Create query
            $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';
            
            //Prepare Statement
            $stmt = $this->conn->prepare($query);
            $this->id = htmlspecialchars(strip_tags($this->id));
            $result = $this->read();
            $result->rowCount();
            if($result ==0){
                return false;
            }

            //Bind Data
            $stmt->bindParam(':id', $this->id);
            //Execute Query
            $x = $stmt->execute();
            if ($stmt->execute()) {
                return true;
            }
            return false;
        } catch (\Throwable $th) {
            return false;
            //throw $th;
        }
        return false;

    }
}//class