<?php

class database{
    /*
     * Database variables
     */
    private $host = "localhost";
    private $user = "root";
    private $password = "";
    private $DB = "00167690_SureshRawal";

    private $connect;

    /*
     * Database connection
     */
    public function __construct()
    {
        $this->connect = new mysqli($this->host, $this->user, $this->password,$this->DB);
        if($this->connect->connect_error){
            die("Database is not connected:" .$this->connect->connect_error);

        }
    }

    /*
     * A function that will be used for inserting
     */
    public function insert($sql){
        $this->connect->query($sql);
    }

    /*
     * A function that will be used for checking rows
     */
    public function checkRows($sql){
        $resultSet = $this->connect->query($sql);
        $rows = $resultSet->num_rows;
        if($rows > 0){
            return $rows;

        }else{
            return false;
        }
    }

    /*
     * A function that will be used for selecting rows
     */
    public function select($sql){
        $data = [];
        $fetchData = $this->connect->query($sql);

        if($fetchData->num_rows > 0){
            while($rows = $fetchData->fetch_assoc())
                $data[] = $rows;
        }else{
            return false;
        }
        return $data;

    }

    /*
     * A function that will be used for updating
     */
    public function update($sql){
        $this->connect->query($sql);

    }

    /*
     * A function that will be used for deleting
     */
    public function delete($sql){
        $this->connect->query($sql);

    }

    /*
     * A function that will be used for aggregate functions
     */
    public function aggFunc($sql){
        $sum=0;
        $selectData = $this->connect->query($sql);
        while($row = $selectData->fetch_assoc()){
            $value = $row['count'];
            $sum += $value;
        }
        return $sum;
    }
}