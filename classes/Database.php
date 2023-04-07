<?php


class Database {

    protected $db_host;
    protected $db_name;
    protected $db_user;
    protected $db_password;
    protected $tables;

    public function __construct(){
        $this->db_host = '';
        $this->db_user = '';
        $this->db_name = '';
        $this->db_password = '';
        $this->tables = ['peliculas', 'comentarios'];
    }

    public function connection() {
        try {
            $connection = mysqli_connect($this->db_host, $this->db_user, $this->db_password, $this->db_name);
        }
        catch(Exception $err) {
            printf('Error al conectar con la base de datos: %s', $err->getMessage());
        }
        return $connection;
    }
    public function query(string $sql) {

        try {
            $connection = mysqli_connect($this->db_host, $this->db_user, $this->db_password, $this->db_name);
        }
        catch(Exception $err) {
            printf('Error al conectar con la base de datos: %s', $err->getMessage());
        }

        $query = mysqli_query($connection, $sql);
        $result  = [];
        while($data = mysqli_fetch_assoc($query)) {
            array_push($result, $data);
        }   
        mysqli_close($connection);

        
            return $result;

    }

    public function save( string $tabla, array $keys,  array $values) {
        try {
            $connection = mysqli_connect($this->db_host, $this->db_user, $this->db_password, $this->db_name);
        }
        catch(Exception $err) {
            printf('Error al conectar con la base de datos: %s', $err->getMessage());
        }
        if(!in_array($tabla, $this->tables)) {
            throw new Exception('No existe la tabla correspondiente');
        }
        else if (empty($keys) && empty($values)) {
            throw new Exception('No hay datos que guardar');
        }
        else {
            
            $keys_sql = implode(", ", $keys);
            $values_sql = implode(", ", $values);
            $sql = "INSERT INTO " . $tabla . " (" . $keys_sql . ") VALUES (" . $values_sql .  ")";
            /* print($sql);
            die(); */
            mysqli_query($connection, "SET NAMES 'utf8'");
            mysqli_query($connection, $sql);
        }
    }
}