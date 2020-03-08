<?php

include_once('./Model.php');
include_once('./StudentSession.php');
include_once('./Student.php');

class Instrument extends Model{
    protected $fillable = ['id', 'name', 'created_by'];
    protected $table = 'instruments';

    public function sessions(){
        return $this->hasMany(StudentSession::class);
    }

    public function scheduleStudents(){
        return $this->belongsToMany(Student::class, StudentSession::class);
    }
}