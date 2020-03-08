<?php

include_once('./Model.php');
include_once('./Student.php');
include_once('./Teacher.php');
include_once('./Instrument.php');
include_once('./Room.php');

class StudentSession extends Model{
    protected $fillable = ['id', 'student_id', 'teacher_id', 'instrument_id', 'room_id', 'added_by'];
    protected $table = 'sessions';

    public function student(){
        return $this->belongsTo(Student::class);
    }

    public function teacher(){
        return $this->belongsTo(Teacher::class);
    }

    public function instrument(){
        return $this->belongsTo(Instrument::class);
    }

    public function room(){
        return $this->belongsTo(Room::class);
    }
}