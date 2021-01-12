@extends('layouts.app')

@section('table_title')
	Cписок групп
@endsection

@section('count')
	{{$group_count}}
@endsection

@section('thead')
	<tr>
		<th>
			<input class="checkbox" type="checkbox" onclick="tbSetAllRow('myTable', this)">
		</th>
		<th>Name</th>
		<th>Edu program</th>
		<th>Department</th>
		<th>Course</th>
		<th>Students</th>
		<th>Created at</th>
		<th>Updated at</th>
		<th>Edit</th>
	</tr>
@endsection

@section('tbody')
	@foreach ($groups as $group)
	<tr>
		<td>
			<input class="checkbox" type="checkbox" onclick="tbSetRow('myTable', this)">
		</td>
		<td>{{ $group->name }}</td>
		<td>{{ $group->edu_title_en }}</td>
		<td>{{ $group->dep_title_en }}</td>
		<td>{{ $group->course }}</td>
		<td>NULL</td>
		<td>{{ $group->created_at }}</td>
		<td>{{ $group->updated_at }}</td>
		<td>
			<button class="btn btn-type-circle btn-hover-2" onclick="tbMkRow('myTable', this, mkArgs, [
				'{{$group->name}}','{{$group->edu_program_id}}', '{{$group->department_id}}','{{$group->course}}'
			])">
				<i class="fa">&#xf044;</i>
			</button>
		</td>
	</tr>
	@endforeach
@endsection

@section('form_add')
<form id="form_add" method="post" action="{{ url('/groups/add') }}" onsubmit="return isValidAddForm()">
	<p>New group</p>
	<div class="row">
		<div class="col-30">
			<label>Name</label>
		</div>
		<div class="col-70">
			<input type="text" name="name" placeholder="Name" required>
		</div>
	</div>

	<div class="row">
		<div class="col-30">
			<label>Educational program</label>
		</div>
		<div class="col-70">
			<select name="edu_programs">
				<option value="0" disabled selected>Not selected</option>
				@foreach ($edu_programs as $edu_program)
				<option value="{{$edu_program->id}}">{{ $edu_program->title_ru}}</option>
				@endforeach
			</select>	
		</div>
	</div>

	<div class="row">
		<div class="col-30">
			<label>Department</label>
		</div>
		<div class="col-70">
			<select name="departments">
				<option value="0" disabled selected>Not selected</option>
				@foreach ($departments as $department)
				<option value="{{$department->id}}">{{ $department->title_en}}</option>
				@endforeach
			</select>
		</div>
	</div>
	<div class="row">
		<div class="col-30">
			<label>Course</label>
		</div>
		<div class="col-70">
			<select name="courses">
				<option value="0" disabled selected>Not selected</option>
				<option value="1">1</option>
				<option value="2">2</option>
				<option value="3">3</option>
				<option value="4">4</option>
			</select>
		</div>
	</div>
	<div class="row">
		<pre class="form-msg-error"></pre>
		<input type="submit" class="btn btn-type-rounded btn-hover-2 col-10" value="Add">
	</div>
</form>
@endsection

@section('form_remove')
<form id="form_remove" method="post" action="{{ url('/groups/remove') }}" onsubmit="return isValidRemoveForm()">
	<p>Remove selected items?</p>
	<ul id="removeList" style="background-color: transparent;float: none;"></ul>
	<input type="submit" class="btn btn-type-rounded btn-hover-2 col-20" value="Remove">
</form>
@endsection

@section('form_edit')
<form id="form_edit" method="post" action="{{ url('/groups/edit') }}" onsubmit="return isValidEditForm()">
	<p>Edit group</p>
	<div class="row">
		<div class="col-30">
			<label>Name</label>
		</div>
		<div class="col-70">
			<input type="text" name="name" placeholder="Name" required readonly>
		</div>
	</div>

	<div class="row">
		<div class="col-30">
			<label>Educational program</label>
		</div>
		<div class="col-70">
			<select name="edu_programs">
				<option value="0" disabled selected>Not selected</option>
				@foreach ($edu_programs as $edu_program)
				<option value="{{$edu_program->id}}">{{ $edu_program->title_ru}}</option>
				@endforeach
			</select>	
		</div>
	</div>

	<div class="row">
		<div class="col-30">
			<label>Department</label>
		</div>
		<div class="col-70">
			<select name="departments">
				<option value="0" disabled selected>Not selected</option>
				@foreach ($departments as $department)
				<option value="{{$department->id}}">{{ $department->title_en}}</option>
				@endforeach
			</select>
		</div>
	</div>
	<div class="row">
		<div class="col-30">
			<label>Course</label>
		</div>
		<div class="col-70">
			<select name="courses">
				<option value="0" disabled selected>Not selected</option>
				<option value="1">1</option>
				<option value="2">2</option>
				<option value="3">3</option>
				<option value="4">4</option>
			</select>
		</div>
	</div>
	<div class="row">
		<pre class="form-msg-error"></pre>
		<input type="submit" class="btn btn-type-rounded btn-hover-2 col-10" value="Save">
	</div>
</form>
@endsection

@section('script')
	@parent
<script type="text/javascript">
	window.onload = function() 
	{
		var links = document.getElementsByClassName("link");
		links[5].className = "link active";
	}

	var _type=["text", "select"]; 
	var _name=["name", "edu_programs", "departments", "courses"];

	var attrList=[@foreach ($groups as $group)"{{ $group->name }}",@endforeach];

	var rmList=attrList, 
		rmName=attrList;
			
	var mkArgs = [
		[_type[0], _name[0]],
		[_type[1], _name[1],
			[@foreach ($edu_programs as $edu_program)"{{ $edu_program->title_ru }}",@endforeach],
			[@foreach ($edu_programs as $edu_program)"{{ $edu_program->id }}",@endforeach, 0]
		],
		[_type[1], _name[2],
			[@foreach ($departments as $department)"{{ $department->title_en }}",@endforeach],
			[@foreach ($departments as $department)"{{ $department->id }}",@endforeach, 0]
		], 
		[_type[1], _name[3],
			[1,2,3,4],
			[1,2,3,4,0]
		]
	];

	function isValidAddForm() 
	{
		var fm = document.getElementById("form_add"),
			fmError = fm.getElementsByClassName("form-msg-error")[0];
			
		var fmInput = [
			[fm.querySelector("[name='name']"), "* Please insert group name\n"],
			[fm.querySelector("[name='edu_programs']"), "* Please select educational program\n"],
			[fm.querySelector("[name='departments']"), "* Please select department\n"],
			[fm.querySelector("[name='courses']"), "* Please select course\n"]
		];

		fmError.innerHTML="\n";
		
		if (attrList.includes(fmInput[0][0].value)) {
			fmError.innerHTML = "* The inserted group name is already exists\n";
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
		return true;
	}

	function isValidRemoveForm() {
		return true;	
	}

	function isValidEditForm() 
	{
		var fm = document.getElementById("form_edit"),
			fmError = fm.getElementsByClassName("form-msg-error")[0];
			
		var fmInput = [
			[fm.querySelector("[name='name']"), "* Please insert group name\n"],
			[fm.querySelector("[name='edu_programs']"), "* Please select educational program\n"],
			[fm.querySelector("[name='departments']"), "* Please select department\n"],
			[fm.querySelector("[name='courses']"), "* Please select course\n"]
		];

		fmError.innerHTML="\n";
		
		/*if (attrList.includes(fmInput[0][0].value)) {
			fmError.innerHTML = "* The inserted group name is already exists\n";
			fmInput[0][0].style = "border-bottom:solid 1px red";
			return false;
		}*/

		for (var i = 0; i < fmInput.length; i++) {
			fmInput[i][0].style = "border-bottom:solid 1px #ccc";

			if (parseInt(fmInput[i][0].value) <= 0 || fmInput[i][0].value.length == 0) {
				fmError.innerHTML = fmInput[i][1];
				fmInput[i][0].style = "border-bottom:solid 1px red";
				return false;
			}
		}
		return true;
	}
</script>
@endsection
