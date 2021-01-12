<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

require_once('Class.php');

class LessonsController extends BaseController
{
	private $subjects, $departments, $teachers, $groups, $academic_plans, $count, $academic_plans_detailed;

	private function sql_select()
	{
		$this->academic_plans = DB::select(
			'SELECT `a`.`id`, `a`.`title_kk`, `a`.`title_ru`, `a`.`title_en`, `a`.`schedule_id`, `a`.`created_at`, `a`.`updated_at`, `a`.`deleted_at`
			 FROM `academic_plans` `a`'
		);

		$this->academic_plans_detailed = DB::select(
			'SELECT `a`.`id`, `a`.`title_kk`, `a`.`title_ru`, `a`.`title_en`, `a`.`schedule_id`, `a`.`created_at`, `a`.`updated_at`, `a`.`deleted_at`, `g`.`name` as group_name, CONCAT(`u`.`lastname`, " ", LEFT(`u`.`firstname`, 1), ".", LEFT(`u`.`patronymic`, 1), ".") as `teacher_name`, `s`.`title_en` as subject
			 FROM `academic_plans` `a`, `study_groups` `g`, `teachers` `t`, `users` `u`, `subjects` `s`, `lessons` `l`
			 WHERE `a`.`id` = `l`.`academic_plan_id` AND
			 	`l`.`study_group_id` = `g`.`id` AND
			 	`l`.`teacher_id` = `t`.`id` AND
			 	`l`.`subject_id` = `s`.`id` AND
			 	`t`.`user_id` = `u`.`id`'
		);
		$this->departments = DB::select(
			'SELECT * FROM `departments`'
		);
		$this->subjects = DB::select(
			'SELECT * FROM `subjects`'
		);
		$this->teachers = DB::select(
			'SELECT `t`.`id`, `t`.`user_id`, `t`.`is_foreign`, `t`.`english_level_id`, `t`.`academic_degree_id`, `t`.`academic_rank_id`, `t`.`department_id`, `t`.`created_at`, `t`.`updated_at`, `t`.`deleted_at`,
				`u`.`firstname`, `u`.`lastname`, `u`.`patronymic`, `u`.`login`, `u`.`password`, `u`.`gender`, `u`.`nationality_id`, `u`.`email`, `u`.`tel`, `u`.`birthdate`,`u`.`registration_address`, `u`.`residential_address`, `u`.`iin`, `d`.`title_en` as department, `ad`.`title_en` as `academic_degree`, `ar`.`description_en` as `academic_rank`, `n`.`name_en` as nationality
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
		$this->count = DB::table(
			'academic_plans', [1]
		)->count();
	}

    public function show()
    {
		$this->sql_select();
    	return view('lessons', [
    			'academic_plans' => $this->academic_plans,
	    		'subjects' => $this->subjects,
	    		'teachers' => $this->teachers,
	    		'groups' => $this->groups,
	    		'count' => $this->count,
	    		'academic_plans_detailed' => $this->academic_plans_detailed
	    	]);
	}

	private function sql_insert($academic_plan)
	{
		DB::insert(
			'INSERT INTO `academic_plans` (`title_kk`, `title_ru`, `title_en`, `schedule_id`, `created_at`, `updated_at`, `deleted_at`) 
			VALUES (?, ?, ?, NULL, current_timestamp(), current_timestamp(), NULL) ', 
			[$academic_plan->title, $academic_plan->title, $academic_plan->title]
		);

		$academic_plan->id = DB::select('SELECT `id` FROM `academic_plans` WHERE `title_en` = ?', 
			[$academic_plan->title])[0]->id;

		$len = count($academic_plan->subject_id);

		for ($i = 0; $i < $len; ++$i) {
			foreach ($academic_plan->study_group_id  as $study_group_id) {
				$lesson_type = [
					$academic_plan->lecture[$i],
					$academic_plan->laboratory[$i],
					$academic_plan->practice[$i]
				];
				$teacher_id = [
					$academic_plan->teacher_lecture_id[$i],
					$academic_plan->teacher_laboratory_id[$i],
					$academic_plan->teacher_practice_id[$i]	
				];
				for ($k = 0; $k < count($teacher_id); $k++) { 
					for ($j = 0; $j < $lesson_type[$i]; ++$j) { 
						DB::insert(
							'INSERT INTO `lessons` (`subject_id`, `teacher_id`, `study_group_id`, `room_id`, `timeslot_id`, `week_day_id`, `lesson_type_id`, `academic_plan_id`, `created_at`, `updated_at`, `deleted_at`) VALUES (?, ?, ?, NULL, NULL, NULL, ?, ?, current_timestamp(), current_timestamp(), NULL) ',
							[$academic_plan->subject_id[$i], $teacher_id[$k], $study_group_id, $k+1, $academic_plan->id]
						);
					}
				}
			}	
		}
	}

	private function sql_update($argument)
	{
		
	}

	private function sql_delete($rmlist)
	{
		foreach ($rmlist as $id) {
			DB::delete(
				'DELETE FROM `lessons` WHERE `academic_plan_id` = ?', [$id]
			);
			DB::delete(
				'DELETE FROM `academic_plans` WHERE `id` = ?', [$id]
			);
		}
	}

	public function add(Request $request)
	{
		$academic_plan = new AcademicPlan(
			null,
			$request->input('title'),
			$request->input('study_group_id'),
			$request->input('subject_id'),
			$request->input('lection'),
			$request->input('laboratory'),
			$request->input('practice'),
			$request->input('teacher_lection_id'),
			$request->input('teacher_laboratory_id'),
			$request->input('teacher_practice_id')
		);

		$this->sql_insert($academic_plan);

		return $this->show();
	}

	public function remove(Request $request)
	{
		$rmlist = $request->input('rmList');
		
		if ($rmlist)
			$this->sql_delete($rmlist);

		return $this->show();
	}

	public function edit(Request $request)
	{
		return $this->show();
	}

}
