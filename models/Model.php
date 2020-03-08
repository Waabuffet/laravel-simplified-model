<?php

include_once('./DB.php');

class Model{
    protected $fillable = [];
    protected $attributes = [];
    protected $table = '';

    public function __construct(){}

    public function __get($key){
        return $this->getAttribute($key);
    }

    public function __set($key, $value){
        $this->setAttribute($key, $value);
    }

    protected function getAttribute($key){
        return $this->attributes[$key];
    }

    protected function setAttribute($key, $value){
        $this->attributes[$key] = $value;
    }

    public function getID(){
        return $this->attributes['id'];
    }

    //help for database access
    public static function getIDAttribute(){
        return $inst->fillable[0]; //in this example, 'id' is the first column and the primary key
    }

    public static function getTableName(){
        $child = get_called_class();
        $inst = new $child();
        return $inst->table;
    }

    //creating instances of the called class
    protected static function instanceArray($db_results){
        $data = [];
        $child = get_called_class();

        foreach($db_results as $result){
            array_push($data, $child::createInstance($result));
        }
        switch(sizeof($data)){
            case 0: return null;
            case 1: return $data[0];
            default: return $data;
        }
    }
    
    protected static function createInstance($attributes){
        $child = get_called_class();

        $instance = new $child(); //self()
        $instance->attributes = $attributes;
        return $instance;
    } 
    
    // select statements
    public static function all(){
        $child = get_called_class();
        $inst = new $child();

        return $child::instanceArray(DB::select('*', $inst->table));
    }

    public static function find($id){
        $child = get_called_class();
        $inst = new $child();

        $row = DB::select('*', $inst->table, $inst->getIDAttribute().'='.$id);
        if(is_null($row)){
            return null;
        }
        return $child::createInstance($row[0]);
    }

    public static function where($column, $operator, $value){
        $child = get_called_class();
        $inst = new $child();

        $condition = $column.' '.$operator.' "'.$value.'"';
        return $child::instanceArray(DB::select('*', $inst->table, $condition));
    }

    //insert statements
    public static function insert($params){
        $child = get_called_class();
        $inst = new $child();
        DB::insert($inst->table, $params);
        $row = DB::select('*',$inst->table, '', 'ORDER BY '.$child::getIDAttribute().' DESC limit 1');

        return $child::createInstance($row[0]);
    }

    public function save(){
        $this->insert($this->attributes);
    }

    //update statement
    public function update($params){
        $this->attributes = DB::update($this, $params);
    }

    //delete statement
    public function delete(){
        return DB::delete($this);
    }

    //relational statements
    public function hasMany($relationship_model){
        $rel_table = $relationship_model::getTableName();
        $id_col = rtrim($this->table, "s ").'_id';

        return $relationship_model::instanceArray(DB::select($rel_table.'.*', $rel_table, $id_col.' = '.$this->getID()));
    }

    public function belongsTo($relationship_model){
        $rel_table = $relationship_model::getTableName();
        $rel_id = $relationship_model::getIDAttribute();
        $id_col = rtrim($rel_table, "s ").'_id';

        return $relationship_model::createInstance(DB::select($rel_table.'.*', $rel_table.' JOIN '.$this->table.' ON '.$this->table.'.'.$id_col.' = '.$rel_table.'.'.$rel_id, $this->table.'.'.$this->getIDAttribute().'='.$this->getID()));
    }

    public function belongsToMany($relationship_model, $pivot_table_model){
        $rel_id = $relationship_model::getIDAttribute();
        $rel_table = $relationship_model::getTableName();
        $pivot_table = $pivot_table_model::getTableName();
        
        $this_id_col = rtrim($this->table, "s ").'_id';
        $rel_id_col = rtrim($rel_table, "s ").'_id';

        return $relationship_model::instanceArray(DB::select('t2.*', $this->table.' t1 JOIN '.$pivot_table.' pt ON t1.'.$this->getIDAttribute().' = pt.'.$this_id_col.' JOIN '.$rel_table.' t2 ON t2.'.$rel_id.' = pt.'.$rel_id_col, 't1.'.$this->getIDAttribute().'='.$this->getID()));
    }

}