<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

require_once('Class.php');

class RoomsController extends BaseController
{
	private $rooms, $room_types, $room_count;

	private function sql_select()
	{
		$this->rooms = DB::select(
			'SELECT `r`.`id`, `r`.`seats`, `r`.`pc`, `r`.`projectors`, `r`.`room_type_id`, 
				`r`.`created_at`, `r`.`updated_at`, `r`.`deleted_at`, 
				`t`.`title_en`, `t`.`title_ru`, `t`.`title_kk`
			 FROM `rooms` `r`, `room_types` `t` 
			 WHERE `r`.`room_type_id` = `t`.`id` 
			 ORDER BY `r`.`id` ASC', [1]
		);
		
		$this->room_types = DB::select(
			'SELECT * FROM room_types', [1]
		);

		$this->room_count = DB::table(
			'rooms', [1]
		)->count();
	}

 	private function sql_insert($room)
	{
		DB::insert(
			'INSERT INTO `rooms` 
				(`id`, `seats`, `pc`, `projectors`, `room_type_id`, `created_at`, `updated_at`, `deleted_at`) 
			 VALUES (?, ?, ?, ?, ?, current_timestamp(), current_timestamp(), NULL) ', 
			[$room->id, $room->seats, $room->pc, $room->projectors, $room->type]
		);
	}

	public function show()
	{
		$this->sql_select();
	    	
		return view('rooms', [
			'rooms' => $this->rooms,
    			'room_types' => $this->room_types,
    			'room_count' => $this->room_count
			]);
	}

	private function sql_update($room)
	{
		DB::update(
			'UPDATE `rooms` 
			 SET `id`= ?, 
				`seats`= ?, 
				`pc`= ?, 
				`projectors`= ?, 
				`room_type_id`= ?, 
				`updated_at`= current_timestamp() 
			 WHERE `rooms`.`id` = ?', 
			[$room->id, $room->seats, $room->pc, $room->projectors, $room->type, $room->id]
		);
	}

	private function sql_delete($rmlist)
	{
		foreach ($rmlist as $room_id) {
			DB::delete(
				'DELETE FROM `rooms` WHERE `id` = ?', [$room_id]
			);
		}
	}

	public function add(Request $request)
	{
		$room = new Room(
			$request->input('number'),
			$request->input('seats'),
			$request->input('pc'),
			$request->input('projectors'),
			$request->input('type')
		);

		$this->sql_insert($room);

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
		$room = new Room(
			$request->input('number'),
			$request->input('seats'),
			$request->input('pc'),
			$request->input('projectors'),
			$request->input('type')
		);

		$this->sql_update($room);	

		return $this->show();
	}
}
