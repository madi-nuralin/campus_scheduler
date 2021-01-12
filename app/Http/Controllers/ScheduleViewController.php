<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

require_once('Class.php');

class ScheduleViewController extends BaseController
{
	private $subjects, $departments, $teachers, $groups, $academic_plans, $timeslots, $schedules, $week_days, $edu_programs, $lessons;

	private function sql_select()
	{
		$this->schedules = DB::select(
			'SELECT * FROM `schedules`'
		);
		$this->lessons = DB::select(
			'SELECT `l`.`id`, `s`.`title_en`, `l`.`study_group_id`, `g`.`name`, `lt`.`title_en` as `lesson_types`,
				CONCAT(`u`.`lastname`, " ", LEFT(`u`.`firstname`, 1), ".", LEFT(`u`.`patronymic`, 1), ".") as `teacher_name`, 
				`l`.`room_id`, `l`.`timeslot_id`, `l`.`week_day_id` 
			 FROM `lessons` `l`, `subjects` `s`, `study_groups` `g`, `teachers` `t`, `users` `u`, `lesson_types` `lt`
			 WHERE `l`.`subject_id` = `s`.`id` AND
			 	`l`.`study_group_id` = `g`.`id` AND
			 	`l`.`teacher_id` = `t`.`id` AND
			 	`t`.`user_id` = `u`.`id`
			 ORDER BY `l`.`week_day_id`, `l`.`timeslot_id`'
		);
		$this->edu_programs = DB::select(
			'SELECT * FROM `edu_programs`'
		);
		$this->academic_plans = DB::select(
			'SELECT `a`.`id`, `a`.`title_kk`, `a`.`title_ru`, `a`.`title_en`, 
				`a`.`created_at`, `a`.`updated_at`, `a`.`deleted_at`
			 FROM `academic_plans` `a`
			 ORDER BY `a`.`created_at` DESC'
		);
		$this->departments = DB::select(
			'SELECT * FROM `departments`'
		);
		$this->subjects = DB::select(
			'SELECT * FROM `subjects`'
		);
		$this->teachers = DB::select(
			'SELECT `t`.`id`, `t`.`user_id`, `t`.`is_foreign`, `t`.`english_level_id`, 
				`t`.`academic_degree_id`, `t`.`academic_rank_id`, `t`.`department_id`, 
				`t`.`created_at`, `t`.`updated_at`, `t`.`deleted_at`,
				`u`.`firstname`, `u`.`lastname`, `u`.`patronymic`, `u`.`login`, 
				`u`.`password`, `u`.`gender`, `u`.`nationality_id`, `u`.`email`, `u`.`tel`, 
				`u`.`birthdate`,`u`.`registration_address`, `u`.`residential_address`, `u`.`iin`, 
				`d`.`title_en` as department, `ad`.`title_en` as `academic_degree`, 
				`ar`.`description_en` as `academic_rank`, `n`.`name_en` as nationality
			 FROM `teachers` `t`, `users` `u`, `departments` `d`, `academic_degrees` `ad`, `academic_ranks` `ar`, `nationalities` `n`
			 WHERE `t`.`user_id` = `u`.`id` AND
				`t`.`department_id` = `d`.`id` AND
				`t`.`academic_degree_id` = `ad`.`id` AND
				`t`.`academic_rank_id` = `ar`.`id` AND
				`u`.`nationality_id` = `n`.`id`
			 ORDER BY `u`.`firstname`'
		);
		$this->groups = DB::select(
			'SELECT * FROM `study_groups`'
		);
		$this->week_days = DB::select(
			'SELECT * FROM `week_days`'
		);
		$this->timeslots = DB::select(
			'SELECT `id`, time_format(`start_at`, "%H:%i") as `start_at`, `duration`, `duration` as `end_at` FROM `timeslots`'
		);
	}

	public function show()
    	{
		$this->sql_select();

    		return view('schedule_view', [
    			'schedules' => $this->schedules,
    			'academic_plans' => $this->academic_plans,
	    		'subjects' => $this->subjects,
	    		'teachers' => $this->teachers,
	    		'groups' => $this->groups,
	    		'week_days' => $this->week_days,
	    		'timeslots' => $this->timeslots,
	    		'edu_programs' => $this->edu_programs,
	    		'lessons' => $this->lessons
	    	]);
	}

	private function sql_insert($argument) {}

	private function sql_update($argument) {}

	private function sql_delete($argument) {}

	public function add(Request $request)
	{
		return $this->show();
	}

	public function remove(Request $request)
	{
		return $this->show();
	}

	public function edit(Request $request)
	{
		return $this->show();
	}

}
