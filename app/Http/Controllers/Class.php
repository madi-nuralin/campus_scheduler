<?php

namespace App\Http\Controllers;

class Room
{
	function __construct($number, $seats, $pc, $projectors, $type)
	{
		$this->id = $number;
		$this->seats = $seats;
		$this->pc = $pc;
		$this->projectors = $projectors;
		$this->type = $type;
	}
}

class Group
{
	function __construct($name, $edu_program, $department, $course)
	{
		$this->name = $name;
		$this->edu_program = $edu_program;
		$this->department = $department;
		$this->course = $course;
	}
}

class Teacher
{	
	function __construct(
			$id,
			$user_id,			
			$firstname,
			$lastname,
			$patronymic,
			$gender,
			$nationality,
			$birthdate,
			$iin,
			$email,
			$tel,
			$login,
			$password,
			$academic_degree,
			$academic_rank,
			$department
	)
	{
		$this->id = $id;
		$this->user_id = $user_id; 
		$this->firstname = $firstname; 
		$this->lastname = $lastname;
		$this->patronymic = $patronymic;
		$this->gender = $gender;
		$this->nationality = $nationality;
		$this->birthdate = $birthdate;
		$this->iin = $iin;
		$this->email = $email;
		$this->tel = $tel;
		$this->login = $login;
		$this->password = $password;
		$this->academic_degree = $academic_degree;
		$this->academic_rank = $academic_rank;
		$this->department = $department;
	}
}

class Subject
{
	function __construct(
		$id, 
		$title_kk, 
		$title_ru, 
		$title_en, 
		$subject_code_kk, 
		$subject_code_ru, 
		$subject_code_en, 
		$description_kk, 
		$description_ru, 
		$description_en, 
		$degree_id, 
		$department_id, 
		$lection, 
		$lab, 
		$practice, 
		$is_additional, 
		$is_language_discipline, 
		$is_multilingual, 
		$is_research, 
		$is_practice, 
		$ects_credits, 
		$created_at, 
		$updated_at, 
		$deleted_at
	)
	{
		$this->id = $id;
		$this->title_kk = $title_kk;
		$this->title_ru = $title_ru;
		$this->title_en = $title_en;
		$this->subject_code_kk = $subject_code_kk;
		$this->subject_code_ru = $subject_code_ru;
		$this->subject_code_en = $subject_code_en;
		$this->description_kk = $description_kk;
		$this->description_ru = $description_ru;
		$this->description_en = $description_en;
		$this->degree_id = $degree_id;
		$this->department_id = $department_id;
		$this->lection = $lection;
		$this->lab = $lab;
		$this->practice = $practice;
		$this->is_additional = $is_additional;
		$this->is_language_discipline = $is_language_discipline;
		$this->is_multilingual = $is_multilingual;
		$this->is_research = $is_research;
		$this->is_practice = $is_practice;
		$this->ects_credits = $ects_credits;
		$this->created_at = $created_at;
		$this->updated_at = $updated_at;
		$this->deleted_at = $deleted_at;
	}
}


class AcademicPlan
{
	
	function __construct($id, $title, 
		$study_group_id, $subject_id, $lecture, $laboratory, $practice, 
	  $teacher_lecture_id, $teacher_laboratory_id, $teacher_practice_id)
	{
		$this->id = $id;
		$this->title = $title;
		$this->study_group_id = $study_group_id;
		$this->subject_id = $subject_id;
		$this->lecture = $lecture;
		$this->laboratory = $laboratory;
		$this->practice = $practice;
		$this->teacher_lecture_id = $teacher_lecture_id;
		$this->teacher_laboratory_id = $teacher_laboratory_id;
		$this->teacher_practice_id = $teacher_practice_id;
	}
}

class Schedule
{
	
	function __construct($id, $title_kk, $title_ru, $title_en, 
		$start_at, $expires_at, $academic_plan_id, $timeslot_id)
	{
		$this->id = $id;
		$this->title_kk = $title_kk;
		$this->title_ru = $title_ru;
		$this->title_en = $title_en;
		$this->start_at = $start_at;
		$this->expires_at = $expires_at;
		$this->academic_plan_id = $academic_plan_id;
		$this->timeslot_id = $timeslot_id;
	}
}