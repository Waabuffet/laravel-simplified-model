<?php

class DB{

    private static $username = "";
    private static $password = "";
    private static $pdo_string = "mysql:host=localhost;dbname=njam";

    
    public static function select($what, $tables, $conditions = '', $filters = ''){

        $conn = new PDO(DB::$pdo_string, DB::$username, DB::$password);

        $query = 'SELECT '.$what.' FROM '.$tables.' WHERE 0=0';
        if(strlen($conditions) > 0){
            $query .= ' AND '.$conditions;
        }
        $query .= ' '.$filters;

        $data = [];

        foreach($conn->query($query) as $row){
            array_push($data, $row);
        }

        switch(sizeof($data)){
            case 0: return null;
            // case 1: return $data[0];
            default: return $data;
        }
    }

    public static function insert($table, $params){
        
        $conn = new PDO(DB::$pdo_string, DB::$username, DB::$password);

        $columns = '';
        $values = '';

        // print_r($params);

        foreach($params as $key => $value){
            // if(is_null(Model::$fillable[$key])){
            //     return false;
            // }
            if(is_string($value)){
                $values .= '"'.$value.'",';
            }else{
                $values .= $value.',';
            }
            $columns .= $key.',';
        }

        $columns = rtrim($columns, ", ");
        $values = rtrim($values, ", ");

        $query = 'INSERT INTO '.$table.' ('.$columns.') VALUES ('.$values.');';

        $conn->query($query);
        return true;
    }

    public static function update($model, $params){
        $conn = new PDO(DB::$pdo_string, DB::$username, DB::$password);
        $query = 'UPDATE '.$model->getTableName().' SET ';

        foreach($params as $key => $value){
            $query .= $key.' = ';
            if(is_string($value)){
                $query .= '"'.$value.'",';
            }else{
                $query .= $value.',';
            }
        }

        $query = rtrim($query, ", ");
        $query .= ' WHERE '.$model->getIDAttribute().' = '.$model->getID();

        $conn->query($query);

        $newly_added_model = 'SELECT * FROM '.$model->getTableName().' WHERE '.$model->getIDAttribute().'='.$model->getID();

        foreach($conn->query($newly_added_model) as $row){
            return $row;
        }
    }

    public static function delete($model){
        $conn = new PDO(DB::$pdo_string, DB::$username, DB::$password);
        $query = 'DELETE FROM '.$model->getTableName().' WHERE '.$model->getIDAttribute().' = '.$model->getID();
        $conn->query($query);
        return true;
    }
}