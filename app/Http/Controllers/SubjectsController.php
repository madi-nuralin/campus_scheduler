<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

require_once('Class.php');

class SubjectsController extends BaseController
{
	private $subjects, $departments, $academic_degrees, $subject_count;

	private function sql_select()
	{
		$this->subjects = DB::select(
			'SELECT `s`.`id`, `s`.`title_kk`, `s`.`title_ru`, `s`.`title_en`, 
					`s`.`subject_code_kk`, `s`.`subject_code_ru`, `s`.`subject_code_en`, 
					`s`.`description_kk`, `s`.`description_ru`, `s`.`description_en`, 
					`s`.`degree_id`, `s`.`department_id`, 
					`s`.`lection`, `s`.`lab`, `s`.`practice`, 
					`s`.`is_additional`, `s`.`is_language_discipline`, `s`.`is_multilingual`, 
					`s`.`is_research`, `s`.`is_practice`, `s`.`ects_credits`, 
					`s`.`created_at`, `s`.`updated_at`, `s`.`deleted_at`, `d`.`title_en` as department
			 FROM `subjects` `s`, `departments` `d`
			 WHERE `s`.`department_id` = `d`.`id`'
		);

		$this->departments = DB::select(
			'SELECT * FROM `departments`'
		);
		$this->academic_degrees = DB::select(
			'SELECT * FROM `academic_degrees`'
		);
		$this->subject_count = DB::table(
			'subjects', [1]
		)->count();
	}

	private function sql_insert($subject)
	{
		DB::insert(
			'INSERT INTO `subjects` (`title_kk`, `title_ru`, `title_en`, `subject_code_kk`, `subject_code_ru`, `subject_code_en`, `description_kk`, `description_ru`, `description_en`, `degree_id`, `department_id`, `lection`, `lab`, `practice`, `is_additional`, `is_language_discipline`, `is_multilingual`, `is_research`, `is_practice`, `ects_credits`, `created_at`, `updated_at`, `deleted_at`) 
			VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, current_timestamp(), current_timestamp(), NULL) ', 
			[$subject->title_kk, $subject->title_ru, $subject->title_en, $subject->subject_code_kk, $subject->subject_code_ru, $subject->subject_code_en, $subject->description_kk, $subject->description_ru, $subject->description_en, $subject->degree_id, $subject->department_id, $subject->lection, $subject->lab, $subject->practice, $subject->is_additional, $subject->is_language_discipline, $subject->is_multilingual, $subject->is_research, $subject->is_practice, $subject->ects_credits]
		);
	}

	private function sql_update($subject)
	{
		DB::update(
			'UPDATE `subjects`
			 SET title_kk = ?, title_ru = ?, title_en = ?, subject_code_kk = ?, subject_code_ru = ?, subject_code_en = ?, description_kk = ?, description_ru = ?, description_en = ?, degree_id = ?, department_id = ?, lection = ?, lab = ?, practice = ?, is_additional = ?, is_language_discipline = ?, is_multilingual = ?, is_research = ?, is_practice = ?, ects_credits = ?, updated_at = current_timestamp() 
			 WHERE `id` = ?',
			 	[$subject->title_kk, $subject->title_ru, $subject->title_en, $subject->subject_code_kk, $subject->subject_code_ru, $subject->subject_code_en, $subject->description_kk, $subject->description_ru, $subject->description_en, $subject->degree_id, $subject->department_id, $subject->lection, $subject->lab, $subject->practice, $subject->is_additional, $subject->is_language_discipline, $subject->is_multilingual, $subject->is_research, $subject->is_practice, $subject->ects_credits, $subject->id ]
		);
	}

	private function sql_delete($rmlist)
	{
		foreach ($rmlist as $id) {
			DB::delete(
				'DELETE FROM `subjects` WHERE `id` = ?', [$id]
			);
		}
	}

	public function show()
    {
		$this->sql_select();
    	return view('subjects', [
	    		'subjects' => $this->subjects,
	    		'departments' => $this->departments,
	    		'academic_degrees' => $this->academic_degrees,
	    		'subject_count' => $this->subject_count,
	    	]);
	}

	public function add(Request $request)
	{
		$subject = new Subject(
			null,
			$request->input('title_kk'),
			$request->input('title_ru'),
			$request->input('title_en'),
			$request->input('subject_code_kk'),
			$request->input('subject_code_ru'),
			$request->input('subject_code_en'),
			$request->input('description_kk'),
			$request->input('description_ru'),
			$request->input('description_en'),
			$request->input('degree_id'),
			$request->input('department_id'),
			$request->input('lection'),
			$request->input('lab'),
			$request->input('practice'),
			$request->input('is_additional') == 'on'? 1 : 0,
			$request->input('is_language_discipline') == 'on'? 1 : 0,
			$request->input('is_multilingual') == 'on'? 1 : 0,
			$request->input('is_research') == 'on'? 1 : 0,
			$request->input('is_practice') == 'on'? 1 : 0,
			$request->input('ects_credits'),
			null,
			null,
			null
		);

		$this->sql_insert($subject);

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
		$subject = new Subject(
			$request->input('id'),
			$request->input('title_kk'),
			$request->input('title_ru'),
			$request->input('title_en'),
			$request->input('subject_code_kk'),
			$request->input('subject_code_ru'),
			$request->input('subject_code_en'),
			$request->input('description_kk'),
			$request->input('description_ru'),
			$request->input('description_en'),
			$request->input('degree_id'),
			$request->input('department_id'),
			$request->input('lection'),
			$request->input('lab'),
			$request->input('practice'),
			$request->input('is_additional') == 'on'? 1 : 0,
			$request->input('is_language_discipline') == 'on'? 1 : 0,
			$request->input('is_multilingual') == 'on'? 1 : 0,
			$request->input('is_research') == 'on'? 1 : 0,
			$request->input('is_practice') == 'on'? 1 : 0,
			$request->input('ects_credits'),
			null,
			null,
			null
		);

		$this->sql_update($subject);

		return $this->show();
	}

}
