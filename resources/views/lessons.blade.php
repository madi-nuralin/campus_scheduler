@extends('layouts.app')

@section('table_title')
	Учебный план	
@endsection

@section('count')
	{{$count}}
@endsection

@section('thead')
	<tr>
		<th>
			<input class="checkbox" type="checkbox" onclick="tbSetAllRow('myTable', this)">
		</th>
		<th>Title</th>
		<th>Created at</th>
		<th>Updated at</th>
		<th>Edit</th>
	</tr>
@endsection

@section('tbody')
	@foreach($academic_plans as $ap)
	<tr>
		<td>
			<input class="checkbox" type="checkbox" onclick="tbSetRow('myTable', this)">
		</td>
		<td>{{$ap->title_en}}</td>
		<td>{{$ap->created_at}}</td>
		<td>{{$ap->updated_at}}</td>
		<td>
			<button class="btn btn-type-circle btn-hover-2" onclick="_view('myTable', '{{$ap->id}}' )">
				<i class="fa">&#xf044;</i>
			</button>
		</td>
	</tr>
	@endforeach
@endsection

@section('form_add')
<form id="form_add" method="post" action="{{ url('/lessons/add') }}" onsubmit="return isValidAddForm()">
	<p>New plan</p>

	<div class="row">
		<div class="col-30">
			<label>Название</label>
		</div>	
		<div class="col-70">
			<input type="text" name="title" placeholder="Название">
		</div>
	</div>
	
	<div class="row">
		<div class="col-30">
			<label>Список групп</label>
		</div>
		<div class="col-70">
			<select name="study_group_id[]" multiple="">
				<option value="0" disabled selected>Not selected</option>
				@foreach($groups as $group)
				<option value="{{$group->id}}">{{$group->name}}</option>
				@endforeach
			</select>
			<!--div class="dropdown" id="dropdown" onclick="drop_down(this)">
			  <div class="dropbtn" onclick="drop_down(this)">Список групп: <span></span></div>
			  <ul class="dropdown_content">
			    @foreach ($groups as $group)
					<li>
						<input type="checkbox" name="" onclick="dropdown_update(this, 'study_group_id[]')">
						<span>{{$group->name}}</span>	
						<input type="hidden" name="hidden_id[]" value="{{$group->id}}">
					</li>
					@endforeach
			  </ul>
			</div-->
		</div>
	</div>

	<br>
	<div class="row" style="display: block; height: 200px; overflow-y: scroll;">
		<table class="" id="subjects_table" style="font-size: 14px;">
			<thead>
				<tr>
					<td>Предмет</td>
					<td>Лекция</td>
					<td>Лаб.</td>
					<td>Практика</td>
					<td>Преподователь лекции</td>
					<td>Преподователь лаб.</td>
					<td>Преподователь практики</td>
					<td>Удалить</td>
				</tr>
			</thead>
			<tbody>
			</tbody>
		</table>
	</div>
	<div class="row">
		<div class="col-40">
			
		</div>
		<div class="col-20">
			<button class="btn btn-type-rounded btn-hover-1" type="button" onclick="addRow('subjects_table', getTr())">Добавить урок</button>	
		</div>
		<div class="col-40"></div>
	</div>
	<div class="row">
		<pre class="form-msg-error"></pre>
		<input type="submit" class="btn btn-type-rounded btn-hover-2 col-10" value="Добавить">
	</div>
</form>
@endsection

@section('form_remove')
<form id="form_remove" method="post" action="{{ url('/lessons/remove') }}" onsubmit="return isValidRemoveForm()"><form>
	<p>Remove selected items?</p>
	<ul id="removeList"></ul>
	<input type="submit" class="btn btn-type-rounded btn-hover-2 col-20" value="Remove">
</form>
@endsection

@section('form_edit')
<form id="form_edit" method="post" action="{{ url('/lessons/edit') }}" onsubmit="return">
	<p>Edit course</p>
		<div class="row">
		<div class="col-30">
			<label>Название</label>
		</div>	
		<div class="col-70">
			<input type="text" name="title" placeholder="Название">
		</div>
	</div>
	
	<div class="row">
		<div class="col-30">
			<label>Список групп</label>
		</div>
		<div class="col-70">
			<select name="study_group_id[]" multiple="">
				<option value="0" disabled selected>Not selected</option>
				@foreach($groups as $group)
				<option value="{{$group->id}}">{{$group->name}}</option>
				@endforeach
			</select>
			<!--div class="dropdown" id="dropdown" onclick="drop_down(this)">
			  <div class="dropbtn" onclick="drop_down(this)">Список групп: <span></span></div>
			  <ul class="dropdown_content">
			    @foreach ($groups as $group)
					<li>
						<input type="checkbox" name="" onclick="dropdown_update(this, 'study_group_id[]')">
						<span>{{$group->name}}</span>	
						<input type="hidden" name="hidden_id[]" value="{{$group->id}}">
					</li>
					@endforeach
			  </ul>
			</div-->
		</div>
	</div>

	<br>
	<div class="row" style="display: block; height: 200px; overflow-y: scroll;">
		<table class="" id="subjects_table" style="font-size: 14px;">
			<thead>
				<tr>
					<td>Предмет</td>
					<td>Лекция</td>
					<td>Лаб.</td>
					<td>Практика</td>
					<td>Преподователь лекции</td>
					<td>Преподователь лаб.</td>
					<td>Преподователь практики</td>
					<td>Удалить</td>
				</tr>
			</thead>
			<tbody>
			</tbody>
		</table>
	</div>
	<div class="row">
		<div class="col-40">
			
		</div>
		<div class="col-20">
			<button class="btn btn-type-rounded btn-hover-1" type="button" onclick="addRow('subjects_table', getTr())">Добавить урок</button>	
		</div>
		<div class="col-40"></div>
	</div>
	<div class="row">
		<pre class="form-msg-error"></pre>
		<input type="submit" class="btn btn-type-rounded btn-hover-2 col-10" value="Добавить">
	</div>
</form>
@endsection

@section('script')
	@parent
<script type="text/javascript">
	window.onload = function ()
	{
		var links = document.getElementsByClassName("link");
		links[2].className = "link active";
	}

	var attrList=[@foreach ($academic_plans as $ap)"{{ $ap->id }}",@endforeach];
	var attrList2=[@foreach ($academic_plans as $ap)"{{ $ap->title_en }}",@endforeach];

	var rmList=attrList, 
			rmName=[
				@foreach ($academic_plans as $ap)
				"{{ $ap->title_en }}",
				@endforeach];

	function getTr() {
		var tr = document.createElement("tr");
		tr.innerHTML = 
		"<td>\
			<select class=\"select-small\" name=\"subject_id[]\">\
				<option value=\"0\" disabled selected>Not selected</option>\
				@foreach ($subjects as $subject)\
				<option value=\"{{$subject->id}}\">\
					{{$subject->title_en}}\
				</option>\
				@endforeach\
			</select>\
		</td>\
		<td>\
			<input class=\"input-small\" type=\"number\" name=\"lection[]\" min=\"0\" max=\"5\">\
		</td>\
		<td>\
			<input class=\"input-small\" type=\"number\" name=\"laboratory[]\" min=\"0\" max=\"10\">\
		</td>\
		<td>\
			<input class=\"input-small\" type=\"number\" name=\"practice[]\" min=\"0\" max=\"10\">\
		</td>\
		<td>\
			<select class=\"select-small\" name=\"teacher_lection_id[]\">\
				<option value=\"0\" disabled selected>Not selected</option>\
				@foreach ($teachers as $teacher)\
				<option value=\"{{$teacher->id}}\">\
					{{$teacher->firstname}} {{$teacher->lastname}} {{$teacher->patronymic}}\
				</option>\
				@endforeach\
			</select>\
		</td>\
		<td>\
			<select class=\"select-small\" name=\"teacher_laboratory_id[]\">\
				<option value=\"0\" disabled selected>Not selected</option>\
				@foreach ($teachers as $teacher)\
				<option value=\"{{$teacher->id}}\">\
					{{$teacher->firstname}} {{$teacher->lastname}} {{$teacher->patronymic}}\
				</option>\
				@endforeach\
			</select>\
		</td>\
		<td>\
			<select class=\"select-small\" name=\"teacher_practice_id[]\">\
				<option value=\"0\" disabled selected>Not selected</option>\
				@foreach ($teachers as $teacher)\
				<option value=\"{{$teacher->id}}\">\
					{{$teacher->firstname}} {{$teacher->lastname}} {{$teacher->patronymic}}\
				</option>\
				@endforeach\
			</select>\
		</td>\
		<td>\
			<button class=\"btn btn-type-circle btn-hover-2\" type=\"button\" onclick=\"delRow(this)\">\
				<i class=\"fa\">&#xf1f8;</i>\
			</button>\
		</td>";
		return tr;
	}

	function addRow(id, tr) {
		var table = document.getElementById(id);
		table.tBodies[0].appendChild(tr);
	}

	function delRow(btn) {
		var tr = btn.parentNode.parentNode;
		tr.remove();
	}

	function isValidAddForm() {
		var fm = document.getElementById("form_add"),
			fmError = fm.getElementsByClassName("form-msg-error")[0];
			
		var fmInput = [
			[fm.querySelector("[name='title']"), "* Please insert title\n"],
			[fm.querySelector("[name='study_group_id[]']"), "* Please select groups\n"]
		];

		fmError.innerHTML="\n";
		
		if (attrList2.includes(fmInput[0][0].value)) {
			fmError.innerHTML = "* The inserted room number is already exists\n";
			fmInput[0][0].style = "border-bottom:solid 1px red";
			return false;
		}

		for (var i = 0; i < fmInput.length; i++) {
			fmInput[i][0].style = "border-bottom:solid 1px #ccc";

			if (parseInt(fmInput[i][0].value) <= 0 || fmInput[i][0].value.length == 0) {
				fmError.innerHTML = fmInput[i][1];
				fmInput[i][0].style = "border-bottom:solid 1px red";
				return false;
			}
		}

		var table = document.getElementById("subjects_table");
		var tr = table.tBodies[0].rows;
		var fmTextInput = [
			["[name='subject_id[]']", "* Please insert room PC\n"],
			["[name='lection[]']", "* Please insert room projectors\n"],
			["[name='laboratory[]']", "* Please insert room projectors\n"],
			["[name='practice[]']", "* Please insert room projectors\n"],
			["[name='teacher_lection_id[]']", "* Please insert room projectors\n"],
			["[name='teacher_laboratory_id[]']", "* Please insert room projectors\n"],
			["[name='teacher_practice_id[]']", "* Please insert room projectors\n"]
		];
		for (var i = 0; i < tr.length; i++) {
			for (var j = 0; j < fmTextInput.length; j++) {
				var item = tr[i].querySelector(fmTextInput[j][0]);
				item.style = "border-bottom:solid 1px #ccc";

				if (parseInt(item.value) < 0 || item.value.length == 0) {			
					fmError.innerHTML = fmTextInput[j][1];
					item.style = "border-bottom:solid 1px red";
					return false;
				}

				if (item.tagName == "SELECT" && parseInt(item.value) == 0) {
					fmError.innerHTML = fmTextInput[j][1];
					item.style = "border-bottom:solid 1px red";
					return false;
				}
			}
		}

		return true;
	}

	/*function _view(tid, id) {
		var apd = [@foreach ($academic_plans_detailed as $apd) "{{$apd->id}}", @endforeach];
		var groups = [@foreach ($academic_plans_detailed as $apd) "{{$apd->group_name}}", @endforeach];

		for (var i = 0; i < apd.length)
	}*/
</script>
@endsection
