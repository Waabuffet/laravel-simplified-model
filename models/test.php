<?php

include_once('./Student.php');
include_once('./StudentSession.php');
include_once('./Instrument.php');
include_once('./Room.php');
include_once('./Teacher.php');

//get all students (array of object instances)
$student = Student::all();

//if result is array, return array of instances, if 1, return jsut one object
$student = Student::where('firstName','=','dominique');

//get specific student (one object instance)
$student = Student::find(7);

//updating this instance in DB and updating the instance
$student->update([
    'lastName' => 'mir'
]);

//getting teachers based on the relationship defined in Student.php
$student_teachers = $student->scheduleTeachers();

$new_student = new Student();

$new_student->firstName = 'dominique';
$new_student->lastName = 'abou samah';
$new_student->phone_number = '123456';
$new_student->email = 'developerdoms@gmail.com';
$new_student->password = 'qwerty123';

$new_student->save();

//or insert directly
Teacher::insert([
    'firstName' => 'Georges',
    'lastName' => 'Musk',
    'phone_number' => '123123',
    'email' => 'georges@gmail.com',
    'password' => 'qweqwe123'
]);

//deleting object instance and in DB
$new_student->delete();