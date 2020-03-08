<?php

include_once('./Model.php');
include_once('./StudentSession.php');

class Room extends Model{
    protected $fillable = ['id', 'name'];
    protected $table = 'rooms';
 
    public function sessions(){
        return $this->hasMany(StudentSession::class);
    }
}