<?php

include_once('./Model.php');
include_once('./StudentSession.php');
include_once('./Student.php');

class Teacher extends Model{
    protected $fillable = ['id', 'firstName', 'lastName', 'phone_number', 'address', 'email', 'payment', 'active', 'password', 'starting_date', 'added_by'];
    protected $table = 'teachers';

    public function sessions(){
        return $this->hasMany(StudentSession::class);
    }

    public function scheduleStudents(){
        return $this->belongsToMany(Student::class, StudentSession::class);
    }
}