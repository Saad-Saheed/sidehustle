<?php
include_once('./config/Database.php');

class User extends Database
{


    private $table = 'users';

    public $id;
    public $name;
    public $email;
    public $phone;
    public $gender;
    protected $password;
    public $created_at;
    public $updated_at;


    public function read()
    {
        $sql_query = 'SELECT
                u.id,
                u.name,
                u.email,
                u.phone,
                u.created_at,
                u.updated_at
            FROM
                ' . $this->table . ' u 
            ORDER BY
                u.updated_at DESC';

        $stmt = $this->conn->prepare($sql_query);

        $stmt->execute();

        return $stmt;
    }


    public function read_single()
    {
        $sql_query = 'SELECT
                u.id,
                u.name,
                u.email,
                u.phone,
                u.created_at,
                u.updated_at
            FROM
                ' . $this->table . ' u
            WHERE u.id = :id
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
            // $this->body = $row['body'];
            // $this->created_at = $row['created_at'];
            // $this->updated_at = $row['updated_at'];

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
                email = :email,
                phone = :phone,
                gender = :gender,
                password = :password
                ';
        try {

            // prepare query
            $stmt = $this->conn->prepare($sql_query);

            // clean/ sanitize input       
            $this->name = htmlspecialchars(strip_tags($this->name));
            $this->email = htmlspecialchars(strip_tags($this->email));
            $this->phone = htmlspecialchars(strip_tags($this->phone));
            $this->gender = htmlspecialchars(strip_tags($this->gender));
            $this->password = htmlspecialchars(strip_tags($this->password));

            // Bind Parameters
            $stmt->bindParam(":name", $this->name, PDO::PARAM_STR);
            $stmt->bindParam(":email", $this->email, PDO::PARAM_STR);
            $stmt->bindParam(":phone", $this->phone, PDO::PARAM_STR);
            $stmt->bindParam(":gender", $this->gender, PDO::PARAM_STR);
            $stmt->bindParam(":password", $this->password, PDO::PARAM_STR);
            
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
        $sql_query = 'UPDATE ' .
            $this->table . '
            SET
                name = :name,
                email = :email,
                phone = :phone,
                gender = :gender
            WHERE
                id = :id';

        // prepare query
        $stmt = $this->conn->prepare($sql_query);

        // clean/ sanitize input       
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->phone = htmlspecialchars(strip_tags($this->phone));
        $this->gender = htmlspecialchars(strip_tags($this->gender));

        // Bind Parameters
        $stmt->bindParam(":name", $this->name, PDO::PARAM_STR);
        $stmt->bindParam(":email", $this->email, PDO::PARAM_STR);
        $stmt->bindParam(":phone", $this->phone, PDO::PARAM_STR);
        $stmt->bindParam(":gender", $this->gender, PDO::PARAM_STR);
        $stmt->bindParam(":id", $this->id, PDO::PARAM_INT);

        // execute query
        $stmt->execute();

        // check if row is affected
        if ($stmt->rowCount() > 0) {

            return true;
        } else {
            // print error if exist
            printf("Error: %s \n", $stmt->error);
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
            printf("Error: %s ", $stmt->error);
            return false;
        }
    }


    public function login()
    {
        $sql_query = 'SELECT *
            FROM
                ' . $this->table . ' u
            WHERE u.email = :email
            AND password = :password
            LIMIT 0, 1';

        // clean id
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->password = htmlspecialchars(strip_tags($this->password));

        // Prepare Statement 
        $stmt = $this->conn->prepare($sql_query);

        // Bind ID
        $stmt->bindValue(":email", $this->email, PDO::PARAM_STR);
        $stmt->bindValue(":password", $this->password, PDO::PARAM_STR);

        // execute query
        $stmt->execute();

        //if Post Exist
        if ($stmt->rowCount() > 0) {

            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row;
        } else {
            return false;
        }
    }

    public function password_reset()
    {
        $sql_query = 'UPDATE ' .
            $this->table . '
            SET
                password = :password
            WHERE
                email = :email';

        // prepare query
        $stmt = $this->conn->prepare($sql_query);

        // clean/ sanitize input       
        $this->password = htmlspecialchars(strip_tags($this->password));
        $this->email = htmlspecialchars(strip_tags($this->email));

        // Bind Parameters
        $stmt->bindParam(":password", $this->password, PDO::PARAM_STR);
        $stmt->bindParam(":email", $this->email, PDO::PARAM_STR);

        $stmt->execute();

        // execute query
        if ($stmt->rowCount() > 0) {

            return true;
        } else {
            // print error if exist
            // printf("Error: %s \n", $stmt->error);
            return false;
        }
    }
}
