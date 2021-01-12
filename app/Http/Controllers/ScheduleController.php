<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

require_once('Class.php');

class ScheduleController extends BaseController
{
	private $subjects, $departments, $teachers, $groups, $academic_plans, $timeslots, $schedules;

	private function sql_select()
	{
		$this->schedules = DB::select(
			'SELECT * FROM `schedules`'
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
		$this->timeslots = DB::select(
			'SELECT `id`, time_format(`start_at`, "%H:%i") as `start_at`, `duration` as `end_at`  FROM `timeslots`'
		);
	}
	
	public function show()
	{
		$this->sql_select();

	    	return view('schedule', [
    			'schedules' => $this->schedules,
    			'academic_plans' => $this->academic_plans,
	    		'subjects' => $this->subjects,
	    		'teachers' => $this->teachers,
	    		'groups' => $this->groups,
	    		'timeslots' => $this->timeslots
	    	]);
	}

	private function sql_insert($schedule)
	{
		DB::insert(
			'INSERT INTO `schedules` (`title_kk`, `title_ru`, `title_en`, `start_at`, `expires_at`, `created_at`, `updated_at`, `deleted_at`) 
			VALUES (?, ?, ?, ?, ?, current_timestamp(), current_timestamp(), NULL) ', 
			[$schedule->title_kk, $schedule->title_ru, $schedule->title_en, $schedule->start_at, $schedule->expires_at]
		);

		$schedule->id = DB::select(
			'SELECT `id` FROM `schedules` WHERE `title_en` = ?', 
			[$schedule->title_en]
		)[0]->id;

		foreach ($schedule->academic_plan_id as $academic_plan_id) {
			DB::update(
				'UPDATE `academic_plans`
				 SET `schedule_id` = ?, `updated_at` = current_timestamp()
				 WHERE `id` = ?',
				 [$schedule->id, $academic_plan_id]
			);
		}
		//*/////////////////////////////////////////////////////
		
		$new_list = DB::select(
			'SELECT `l`.`id`, `l`.`teacher_id`, `l`.`study_group_id`, l.`timeslot_id`, `l`.`week_day_id`, `l`.`room_id` 
			FROM `lessons` `l`, `academic_plans` `a`
			WHERE `l`.`academic_plan_id` = `a`.`id` AND
				`a`.`schedule_id` = ?', 
			[$schedule->id]
		);

		$prev_list = DB::select(
			'SELECT `l`.`id`, `l`.`teacher_id`, `l`.`study_group_id`, l.`timeslot_id`, `l`.`week_day_id`, `l`.`room_id`  
			FROM `lessons` `l`, `academic_plans` `a`, `schedules` `s`
			WHERE `l`.`academic_plan_id` = `a`.`id` AND
				`a`.`schedule_id` = `s`.`id` AND
				`a`.`schedule_id` <> ? AND
				((`s`.`start_at` < ?) OR (? < `s`.`expires_at`))', 
			[$schedule->id, $schedule->expires_at, $schedule->start_at]
		);

		$rooms = DB::select(
			'SELECT * FROM rooms'
		);

		$timeslots = DB::select(
			'SELECT * FROM timeslots'
		);

		$week_days = DB::select(
			'SELECT * FROM week_days'
		);

		$parsed_list = [];

		foreach ($new_list as $new) {
			foreach ($week_days as $w) {
				foreach ($timeslots as $t) {
					if (!in_array($t->id, $schedule->timeslot_id)) {
						continue;
					}
					foreach ($rooms as $r) {
						$flag = 1;
						foreach ($prev_list as $prev) {
							if (
								($w->id == $prev->week_day_id && 
								 $t->id == $prev->timeslot_id &&
								 $r->id == $prev->room_id)
							) {
								$flag = 0;
								break;
							}							
						}
						
						if ($flag) {
							foreach ($prev_list as $p) {
								if ($new->teacher_id == $p->teacher_id ||
									$new->study_group_id == $p->study_group_id ||
									$new->room_id == $p->room_id) 
								{
									if ($w->id == $p->week_day_id && 
									 	$t->id == $p->timeslot_id) {
										$flag=0; break;
									}
								}
							}
							if (!$flag)
								continue;

							foreach ($parsed_list as $parsed) {
								if ($new->teacher_id == $parsed->teacher_id ||
									$new->study_group_id == $parsed->study_group_id ||
									$new->room_id == $parsed->room_id) 
								{
									if ($w->id == $parsed->week_day_id && 
									 	$t->id == $parsed->timeslot_id) {
										$flag=0; break;
									}
								}
							}
							if (!$flag)
								continue;

							$new->week_day_id = $w->id;
							$new->timeslot_id = $t->id;
							$new->room_id = $r->id;

							array_push($parsed_list, $new);
							goto end;
						}
					}
				}
			}
			end:;
		}

		foreach ($new_list as $new) {
			DB::insert(
				'UPDATE `lessons`
				SET `week_day_id` = ?,
					`timeslot_id` = ?,
					`room_id` = ?,
					`updated_at` = current_timestamp()
				WHERE `id` = ?',
				[$new->week_day_id, $new->timeslot_id, $new->room_id, $new->id]
			);
		}
	}

	private function sql_update($subject)
	{
		DB::update(
			'UPDATE `subjects`
			 SET title_kk = ?, title_ru = ?, title_en = ?, 
			     subject_code_kk = ?, subject_code_ru = ?, subject_code_en = ?, 
			     description_kk = ?, description_ru = ?, description_en = ?, 
			     degree_id = ?, department_id = ?, lection = ?, lab = ?, practice = ?, 
			     is_additional = ?, is_language_discipline = ?, is_multilingual = ?, 
			     is_research = ?, is_practice = ?, ects_credits = ?, updated_at = current_timestamp() 
			 WHERE `id` = ?', [
			$subject->title_kk, $subject->title_ru, $subject->title_en, 
			$subject->subject_code_kk, $subject->subject_code_ru, $subject->subject_code_en, 
			$subject->description_kk, $subject->description_ru, $subject->description_en, 
			$subject->degree_id, $subject->department_id, $subject->lection, $subject->lab, 
			$subject->practice, $subject->is_additional, $subject->is_language_discipline, 
			$subject->is_multilingual, $subject->is_research, $subject->is_practice, 
			$subject->ects_credits, $subject->id
		]);
	}

	private function sql_delete($rmlist)
	{
		foreach ($rmlist as $title_en) {
			DB::delete(
				'DELETE FROM `schedules` WHERE `title_en` = ?', [$title_en]
			);
		}
	}

	public function add(Request $request)
	{
		$schedule = new Schedule(
			null,
			$request->input('schedule_title'),
			$request->input('schedule_title'),
			$request->input('schedule_title'),
			$request->input('start_at'),
			$request->input('expires_at'),
			$request->input('academic_plan_id'),
			$request->input('timeslot_id')
		);

		$this->sql_insert($schedule);

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
