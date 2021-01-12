<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

require_once('Class.php');

class GroupsController extends BaseController
{
	private $groups, $edu_programs, $departments, $group_count;

	private function sql_select()
	{
		$this->groups = DB::select(
			'SELECT `sg`.`id`, `sg`.`name`, `sg`.`edu_program_id`, `sg`.`department_id`, `sg`.`course`, `sg`.`created_at`, `sg`.`updated_at`, `sg`.`deleted_at`,
				`ep`.`title_en` as `edu_title_en`, `d`.`title_en` as `dep_title_en`
			 FROM `study_groups` `sg`, `edu_programs` `ep`, `departments` `d` 
			 WHERE `sg`.`edu_program_id` = `ep`.`id` AND
			 	   `sg`.`department_id` = `d`.`id`'
		);
		$this->edu_programs = DB::select(
			'SELECT * FROM `edu_programs`'
		);
		$this->departments = DB::select(
			'SELECT * FROM `departments`'
		);
		$this->group_count = DB::table(
			'study_groups', [1]
		)->count();
	}

	private function sql_insert($group)
	{
		DB::insert(
			'INSERT INTO `study_groups` 
				(`name`, `edu_program_id`, `department_id`, `course`, `created_at`, `updated_at`, `deleted_at`) 
			 VALUES (?, ?, ?, ?, current_timestamp(), current_timestamp(), NULL) ', 
			[$group->name, $group->edu_program, $group->department, $group->course]
		);
	}

	private function sql_update($group)
	{
		DB::update(
			'UPDATE `study_groups` 
			SET `name`= ?, 
				`edu_program_id`= ?, 
				`department_id`= ?, 
				`course`= ?, 
				`updated_at`= current_timestamp() 
			WHERE `study_groups`.`name` = ?', 
			[$group->name, $group->edu_program, $group->department, $group->course, $group->name]
		);
	}

	private function sql_delete($rmlist)
	{
		foreach ($rmlist as $group_name) {
			DB::delete(
				'DELETE FROM `study_groups` WHERE `name` = ?', [$group_name]
			);
		}
	}

	public function show()
    {
		$this->sql_select();
    	return view('groups', 
    		['groups' => $this->groups, 
    		 'edu_programs' => $this->edu_programs,
    		 'departments' => $this->departments,
    		 'group_count' => $this->group_count]
    		);
	}

	public function add(Request $request)
	{
		$group = new Group(
			$request->input('name'),
			$request->input('edu_programs'),
			$request->input('departments'),
			$request->input('courses')
		);

		$this->sql_insert($group);

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
		$group = new Group(
			$request->input('name'),
			$request->input('edu_programs'),
			$request->input('departments'),
			$request->input('courses')
		);

		$this->sql_update($group);

		return $this->show();
	}
}
