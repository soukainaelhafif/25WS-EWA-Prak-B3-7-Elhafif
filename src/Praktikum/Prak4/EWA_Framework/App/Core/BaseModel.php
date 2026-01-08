<?php

abstract class BaseModel
{
    protected readonly MySQLi $db;

    /**
     * Constructor: Initializes the database connection.
     *
     * Chooses the correct database host based on whether the hostname 'mariadb' resolves.
     * Connects to the specified database ('YOUR_DATABASE').
     *
     * @throws Exception if the database connection fails
     */
    public function __construct()
    {   
        // This code switches from the the local installation (XAMPP) to the docker installation 
        $host = gethostbyname('mariadb') !== 'mariadb' ? 'mariadb' : 'localhost';
        
        // TODO: Replace these placeholders with your actual database credentials
        $user = 'public';
        $password = 'public';
        $database = 'pizzaservice'; 

        /*
        if ($database === 'pizzaservice') {
            echo '<h2>⚠️ Please set your database credentials in BaseModel.php before continuing.</h2>';
            exit;
        }
        */

        $this->db = new MySQLi($host, $user, $password, $database);

        if ($this->db->connect_error) {
            throw new Exception('DB connection failed: ' . $this->db->connect_error);
        }

        if (!$this->db->set_charset('utf8mb4')) {
            throw new Exception('Error setting charset: ' . $this->db->error);
        }
    }

    /**
     * Destructor: Closes the database connection when the object is destroyed.
     */
    public function __destruct()
    {
        if (isset($this->db)) {
            $this->db->close();
        }
    }

    
    public function getDb(): MySQLi
    {
        return $this->db;
    }
    

}

