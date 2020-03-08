<?php

include_once('./Model.php');
include_once('./StudentSession.php');
include_once('./Teacher.php');

class Student extends Model{
    protected $fillable = ['id', 'firstName', 'lastName', 'phone_number', 'address', 'email', 'payment', 'active', 'password', 'starting_date', 'added_by'];
    protected $table = 'students';

    public function sessions(){
        return $this->hasMany(StudentSession::class);
    }

    public function scheduleTeachers(){
        return $this->belongsToMany(Teacher::class, StudentSession::class);
    }

}