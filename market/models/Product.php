<?php
include_once('./config/Database.php');

class Product extends Database
{


    private $table = 'products';

    public $id;
    public $name;
    public $description;
    public $price;
    public $user_id;
    public $image;
    public $created_at;
    public $updated_at;


    public function read()
    {
        $sql_query = 'SELECT *
            FROM
                ' . $this->table . ' p 
            ORDER BY
                p.updated_at DESC';

        $stmt = $this->conn->prepare($sql_query);

        $stmt->execute();

        //if Post Exist
        if ($stmt->rowCount() > 0) {

            $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $row;
        } else {
            return false;
        }

        // return $stmt;
    }
    public function get_myproduct($id)
    {
        $sql_query = 'SELECT *
            FROM
                ' . $this->table . ' p
            WHERE p.user_id = :user_id 
            ORDER BY
                p.updated_at DESC';

        $stmt = $this->conn->prepare($sql_query);
        // Bind ID
        $stmt->bindValue(":user_id", $id, PDO::PARAM_INT);

        $stmt->execute();

          //if Post Exist
          if ($stmt->rowCount() > 0) {

            $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $row;
        } else {
            return false;
        }

        // return $stmt;
    }


    public function read_single()
    {
        $sql_query = 'SELECT *
            FROM
                ' . $this->table . ' p
            WHERE p.id = :id
            LIMIT 0, 1';

        // Prepare Statement 
        $stmt = $this->conn->prepare($sql_query);

        // Bind ID
        $stmt->bindValue(":id", $this->id, PDO::PARAM_INT);

        // execute query
        $stmt->execute();

        //if Post Exist
        if ($stmt->rowCount() > 0) {

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // set properties
            $this->name = $row['name'];
            $this->user_id = $row['user_id'];
            $this->description = $row['description'];
            $this->price = $row['price'];
            $this->image = $row['image'];
            $this->created_at = $row['created_at'];
            $this->updated_at = $row['updated_at'];

            return $row;
        } else {
            return false;
        }
    }


    public function create()
    {
        $sql_query = 'INSERT INTO ' .
            $this->table . '
            SET
                name = :name,
                description = :description,
                price = :price,
                user_id = :user_id,
                image = :image';
        try {

            // prepare query
            $stmt = $this->conn->prepare($sql_query);

            // clean/ sanitize input       
            $this->name = htmlspecialchars(strip_tags($this->name));
            $this->description = htmlspecialchars(strip_tags($this->description));
            $this->price = htmlspecialchars(strip_tags($this->price));
            $this->user_id = htmlspecialchars(strip_tags($this->user_id));
            $this->image = htmlspecialchars(strip_tags($this->image));

            // Bind Parameters
            $stmt->bindParam(":name", $this->name, PDO::PARAM_STR);
            $stmt->bindParam(":description", $this->description, PDO::PARAM_STR);
            $stmt->bindParam(":price", $this->price, PDO::PARAM_STR);
            $stmt->bindParam(":user_id", $this->user_id, PDO::PARAM_INT);
            $stmt->bindParam(":image", $this->image, PDO::PARAM_STR);
            
            // execute statement
            $stmt->execute();

            // check if row is affected
            if ($stmt->rowCount() > 0) {

                return true;
            }
        } catch (PDOException $pex) {

            // print error if exist
            // printf("Error: %s \n", $pex->getMessage());
            return false;
        }
    }


    public function update()
    {

        $is_image = ($this->image) ? ",image = :image" : "";

        $sql_query = 'UPDATE ' .
            $this->table . '
            SET
                name = :name,
                description = :description,
                price = :price'.
                 $is_image
            .' WHERE
                id = :id';
        // prepare query
        $stmt = $this->conn->prepare($sql_query);

        // clean/ sanitize input       
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->price = htmlspecialchars(strip_tags($this->price));
        $this->image = htmlspecialchars(strip_tags($this->image));

        // Bind Parameters
        $stmt->bindParam(":name", $this->name, PDO::PARAM_STR);
        $stmt->bindParam(":description", $this->description, PDO::PARAM_STR);
        $stmt->bindParam(":price", $this->price, PDO::PARAM_STR);
        if($is_image)
            $stmt->bindParam(":image", $this->image, PDO::PARAM_STR);
        $stmt->bindParam(":id", $this->id, PDO::PARAM_INT);

        // execute query
        $stmt->execute();

        // check if row is affected
        if ($stmt->rowCount() > 0) {

            return true;
        } else {
            // print error if exist
            // printf("Error: %s \n", $stmt->error);
            return false;
        }
    }


    public function delete()
    {
        // clean id
        $this->id = htmlspecialchars(strip_tags($this->id));

        // sql query
        $sql_query = 'DELETE 
                FROM ' . $this->table . '
                WHERE
                    id = :id';

        // prepare statement 
        $stmt = $this->conn->prepare($sql_query);

        // Bind value
        $stmt->bindValue(":id", $this->id, PDO::PARAM_INT);

        // execute statement
        $stmt->execute();

         // check if row is affected
        if ($stmt->rowCount() > 0) {
            return true;
        } else {
            // printf("Error: %s ", $stmt->error);
            return false;
        }
    }
}
