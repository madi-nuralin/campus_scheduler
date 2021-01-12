<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

require_once('Class.php');

class TeachersController extends BaseController
{
	private $teachers, $users, $nationalities, $departments, $academic_degrees, $academic_ranks, $genders, $teacher_count;

	private function sql_select()
	{
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
			 WHERE  `t`.`user_id` = `u`.`id` AND
				`t`.`department_id` = `d`.`id` AND
			 	`t`.`academic_degree_id` = `ad`.`id` AND
			 	`t`.`academic_rank_id` = `ar`.`id` AND
			 	`u`.`nationality_id` = `n`.`id`
			 ORDER BY `u`.`firstname`'
		);
		$this->users = DB::select(
			'SELECT * FROM `users`'
		);
		$this->departments = DB::select(
			'SELECT * FROM `departments`'
		);
		$this->academic_degrees = DB::select(
			'SELECT * FROM `academic_degrees`'
		);
		$this->academic_ranks = DB::select(
			'SELECT * FROM `academic_ranks`'
		);
		$this->nationalities = DB::select(
			'SELECT * FROM `nationalities` ORDER BY name_en'
		);
		$this->genders = DB::select(
			'SELECT * FROM `genders`'
		);
		$this->teacher_count = DB::table(
			'teachers', [1]
		)->count();
	}

	private function sql_insert($teacher)
	{
		DB::insert(
			'INSERT INTO `users` (`firstname`, `lastname`, `patronymic`, `login`, `password`, `gender`, 
				`nationality_id`, `email`, `tel`, `birthdate`, `registration_address`, `residential_address`, 
				`iin`, `created_at`, `updated_at`, `deleted_at`) 
			 VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NULL, NULL, ?, current_timestamp(), current_timestamp(), NULL)', 
			[$teacher->firstname, $teacher->lastname, $teacher->patronymic, $teacher->login, 
			$teacher->password, $teacher->gender, $teacher->nationality, $teacher->email, 
			$teacher->tel, $teacher->birthdate, $teacher->iin]
		);

		$user = DB::select(
			'SELECT `id` FROM `users`
			 WHERE `firstname` = ? AND
			 	`lastname` = ? AND 
			 	`patronymic` = ? AND 
			 	`login` = ? AND
			 	`password` = ? AND 
			 	`gender` = ? AND
			 	`nationality_id` = ? AND
			 	`email` = ? AND
			 	`tel` = ? AND 
			 	`birthdate` = ? AND
			 	`iin` = ?', [
			$teacher->firstname, $teacher->lastname, $teacher->patronymic, $teacher->login, 
			$teacher->password, $teacher->gender, $teacher->nationality, $teacher->email, 
			$teacher->tel, $teacher->birthdate, $teacher->iin
		])[0];
		
		DB::insert(
			'INSERT INTO `teachers` (`user_id`, `is_foreign`, `english_level_id`, 
				`academic_degree_id`, `academic_rank_id`, `department_id`, `created_at`, `updated_at`, `deleted_at`) 
			VALUES (?, 0, 1, ?, ?, ?, current_timestamp(), current_timestamp(), NULL) ', [
			$user->id, $teacher->academic_degree, $teacher->academic_rank, $teacher->department
		]);
	}

	private function sql_update($teacher)
	{
		DB::update(
			'UPDATE `users`
			 SET `firstname` = ?, 
			     `lastname` = ?, 
			     `patronymic` = ?, 
			     `login` = ?, 
			     `password` = ?, 
			     `gender` = ?, 
			     `nationality_id` = ?, 
			     `email` = ?, 
			     `tel` = ? , 
			     `birthdate` = ?, 
			     `iin` = ? 
			 WHERE `id` = ?', [
			$teacher->firstname, $teacher->lastname, $teacher->patronymic, 
			$teacher->login, $teacher->password, $teacher->gender, $teacher->nationality, 
			$teacher->email, $teacher->tel, $teacher->birthdate, $teacher->iin, $teacher->user_id 
		]);

		DB::update(
			'UPDATE `teachers` 
			 SET `academic_degree_id` = ?, 
			     `academic_rank_id` = ?, 
			     `department_id` = ?, 
			     `updated_at` = current_timestamp()
			WHERE `id` = ?', 
			[$teacher->academic_degree, $teacher->academic_rank, $teacher->department, $teacher->id]
		);
	}

	private function sql_delete($rmlist)
	{
		foreach ($rmlist as $teacher_id) {
			$user_id = DB::select(
				'SELECT `user_id` FROM `teachers` WHERE `id` = ?',
				[$teacher_id]
			)[0]->user_id;

			DB::delete(
				'DELETE FROM `teachers` WHERE `id` = ?', [$teacher_id]
			);

			DB::delete(
				'DELETE FROM `users` WHERE `id` = ?', [$user_id]
			);
		}
	}

	public function show()
	{
		$this->sql_select();

		return view('teachers', [
			'teachers' => $this->teachers,
	    		'users' => $this->users, 
    			'nationalities' => $this->nationalities,
    			'departments' => $this->departments,
    			'academic_degrees' => $this->academic_degrees,
	    		'academic_ranks' => $this->academic_ranks,
    			'genders' => $this->genders,
    			'teacher_count' => $this->teacher_count
		]);
	}

	public function add(Request $request)
	{
		$teacher = new Teacher(
			null,
			null,
			$request->input('firstname'),
			$request->input('lastname'),
			$request->input('patronymic'),
			$request->input('gender'),
			$request->input('nationality'),
			$request->input('birthdate'),
			$request->input('iin'),
			$request->input('email'),
			$request->input('tel'),
			$request->input('login'),
			$request->input('password'),
			$request->input('academic_degree'),
			$request->input('academic_rank'),
			$request->input('department')
		);

		$this->sql_insert($teacher);

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
		$teacher = new Teacher(
			$request->input('id'),
			$request->input('user_id'),
			$request->input('firstname'),
			$request->input('lastname'),
			$request->input('patronymic'),
			$request->input('gender'),
			$request->input('nationality'),
			$request->input('birthdate'),
			$request->input('iin'),
			$request->input('email'),
			$request->input('tel'),
			$request->input('login'),
			$request->input('password'),
			$request->input('academic_degree'),
			$request->input('academic_rank'),
			$request->input('department')
		);

		$this->sql_update($teacher);

		return $this->show();
	}
}
