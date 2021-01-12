@extends('layouts.app')

@section('table_title')
	Список преподавателей
@endsection

@section('count')
	{{$teacher_count}}
@endsection

@section('thead')
	@parent
	<tr>
		<th>
			<input class="checkbox" type="checkbox" onclick="tbSetAllRow('myTable', this)">
		<th>First name</th>
		<th>Last name</th>
		<th>Patronymic</th>
		<th>Degree</th>
		<th>Rank</th>
		<th>Depatrment</th>
		<th>Created at</th>
		<th>Updated at</th>
		<th>Edit</th>
	</tr>
@endsection

@section('tbody')
	@foreach ($teachers as $teacher)
	<tr>
		<td>
			<input class="checkbox" type="checkbox" onclick="tbSetRow('myTable', this)">
		</td>
		<td>{{ $teacher->firstname }}</td>
		<td>{{ $teacher->lastname }}</td>
		<td>{{ $teacher->patronymic }}</td>
		<td>{{ $teacher->academic_degree }}</td>
		<td>{{ $teacher->academic_rank }}</td>
		<td>{{ $teacher->department }}</td>
		<td>{{ $teacher->created_at }}</td>
		<td>{{ $teacher->updated_at }}</td>
		<td>
			<button class="btn btn-type-circle btn-hover-2" onclick="tbMkRow('myTable', this, mkArgs, [
					'{{$teacher->firstname}}', '{{$teacher->lastname}}', '{{$teacher->patronymic}}', '{{$teacher->gender}}', '{{$teacher->nationality_id}}', '{{$teacher->birthdate}}', '{{$teacher->iin}}', '{{$teacher->email}}', '{{$teacher->tel}}', '{{$teacher->login}}', '{{$teacher->password}}', '{{$teacher->academic_degree_id}}', '{{$teacher->academic_rank_id}}', '{{$teacher->department_id}}', '{{$teacher->id}}', '{{$teacher->user_id}}'
			])">
				<i class="fa">&#xf044;</i>
			</button>
		</td>
	</tr>
	@endforeach

@endsection

@section('form_add')
<form id="form_add" method="post" action="{{ url('/teachers/add') }}" onsubmit="return isValidAddForm()">
	<p>New teacher profile</p>
	<div style="display: table;">
		<div style="display: table; float: left;">
			
			<div class="row">
				<div class="col-30">
					<label>Firstname</label>
				</div>
				<div class="col-70">
					<input type="text" name="firstname" placeholder="Firstname">
				</div>
			</div>

			<div class="row">
				<div class="col-30">
					<label>Lastname</label>
				</div>
				<div class="col-70">
					<input type="text" name="lastname" placeholder="Lastname">
				</div>
			</div>

			<div class="row">
				<div class="col-30">
					<label>Patronymic</label>
				</div>
				<div class="col-70">
					<input type="text" name="patronymic" placeholder="Patronymic">
				</div>
			</div>

			<div class="row">
				<div class="col-30">
					<label>Gender</label>
				</div>
				<div class="col-70">
					<select name="gender">
						<option value="0" disabled selected>Not selected</option>
						@foreach ($genders as $gender)
						<option value="{{$gender->id}}">{{ $gender->description_en}}</option>
						@endforeach
					</select>
				</div>
			</div>

			<div class="row">
				<div class="col-30">
					<label>Nationality</label>
				</div>
				<div class="col-70">
					<select name="nationality">
						<option value="0" disabled selected>Not selected</option>
						@foreach ($nationalities as $nationality)
						<option value="{{$nationality->id}}">{{ $nationality->name_en}}</option>
						@endforeach
					</select>
				</div>
			</div>

			<div class="row">
				<div class="col-30">
					<label>Bithrdate</label>
				</div>
				<div class="col-70">
					<input type="date" name="birthdate" required>
				</div>
			</div>

			<div class="row">
				<div class="col-30">
					<label>iin</label>
				</div>
				<div class="col-70">
					<input type="text" name="iin" placeholder="iin">
				</div>
			</div>
		</div>

		<div style="display: table; float: right; padding-left:20px;">
			<div class="row">
				<div class="col-30">
					<label>Email</label>
				</div>
				<div class="col-70">
					<input type="text" name="email" placeholder="Email">
				</div>
			</div>

			<div class="row">
				<div class="col-30">
					<label>Phone number</label>
				</div>
				<div class="col-70">
					<input type="text" name="tel" placeholder="tel">
				</div>
			</div>

			<div class="row">
				<div class="col-30">
					<label>Login</label>
				</div>
				<div class="col-70">
					<input type="text" name="login" placeholder="Login">
				</div>
			</div>

			<div class="row">
				<div class="col-30">
					<label>Password</label>
				</div>
				<div class="col-70">
					<input type="password" name="password" placeholder="Password">
				</div>
			</div>

			<div class="row">
				<div class="col-30">
					<label>Academic degree</label>
				</div>
				<div class="col-70">
					<select name="academic_degree">
						<option value="0" disabled selected>Not selected</option>
						@foreach ($academic_degrees as $academic_degree)
						<option value="{{$academic_degree->id}}">{{ $academic_degree->title_en}}</option>
						@endforeach
					</select>
				</div>
			</div>

			<div class="row">
				<div class="col-30">
					<label>Academic rank</label>
				</div>
				<div class="col-70">
					<select name="academic_rank">
						<option value="0" disabled selected>Not selected</option>
						@foreach ($academic_ranks as $academic_rank)
						<option value="{{$academic_rank->id}}">{{$academic_rank->description_en}}</option>
						@endforeach
					</select>
				</div>
			</div>

			<div class="row">
				<div class="col-30">
					<label>Department</label>
				</div>
				<div class="col-70">
					<select name="department">
						<option value="0" disabled selected>Not selected</option>
						@foreach ($departments as $department)
						<option value="{{$department->id}}">{{ $department->title_en}}</option>
						@endforeach
					</select>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<pre class="form-msg-error"></pre>
		<input type="hidden" name="id" value="">
		<input type="hidden" name="user_id" value="">
		<input type="submit" class="btn btn-type-rounded btn-hover-2 col-10" value="Add">
	</div>
</form>
@endsection

@section('form_remove')
<form id="form_remove" method="post" action="{{ url('/teachers/remove') }}" onsubmit="return isValidRemoveForm()">
	<p>Remove selected items?</p>
	<ul id="removeList" style="background-color: transparent;float: none;"></ul>
	<input type="submit" class="btn btn-type-rounded btn-hover-2 col-20" value="Remove">
</form>
@endsection

@section('form_edit')
<form id="form_edit" method="post" action="{{ url('/teachers/edit') }}" onsubmit="return isValidEditForm()">
	<p>Edit teacher profile</p>
	<div style="display: table;">
		<div style="display: table; float: left;">
			
			<div class="row">
				<div class="col-30">
					<label>Firstname</label>
				</div>
				<div class="col-70">
					<input type="text" name="firstname" placeholder="Firstname">
				</div>
			</div>

			<div class="row">
				<div class="col-30">
					<label>Lastname</label>
				</div>
				<div class="col-70">
					<input type="text" name="lastname" placeholder="Lastname">
				</div>
			</div>

			<div class="row">
				<div class="col-30">
					<label>Patronymic</label>
				</div>
				<div class="col-70">
					<input type="text" name="patronymic" placeholder="Patronymic">
				</div>
			</div>

			<div class="row">
				<div class="col-30">
					<label>Gender</label>
				</div>
				<div class="col-70">
					<select name="gender">
						<option value="0" disabled selected>Not selected</option>
						@foreach ($genders as $gender)
						<option value="{{$gender->id}}">{{ $gender->description_en}}</option>
						@endforeach
					</select>
				</div>
			</div>

			<div class="row">
				<div class="col-30">
					<label>Nationality</label>
				</div>
				<div class="col-70">
					<select name="nationality">
						<option value="0" disabled selected>Not selected</option>
						@foreach ($nationalities as $nationality)
						<option value="{{$nationality->id}}">{{ $nationality->name_en}}</option>
						@endforeach
					</select>
				</div>
			</div>

			<div class="row">
				<div class="col-30">
					<label>Bithrdate</label>
				</div>
				<div class="col-70">
					<input type="date" name="birthdate" required>
				</div>
			</div>

			<div class="row">
				<div class="col-30">
					<label>iin</label>
				</div>
				<div class="col-70">
					<input type="text" name="iin" placeholder="iin">
				</div>
			</div>
		</div>

		<div style="display: table; float: right; padding-left:20px;">
			<div class="row">
				<div class="col-30">
					<label>Email</label>
				</div>
				<div class="col-70">
					<input type="text" name="email" placeholder="Email">
				</div>
			</div>

			<div class="row">
				<div class="col-30">
					<label>Phone number</label>
				</div>
				<div class="col-70">
					<input type="text" name="tel" placeholder="tel">
				</div>
			</div>

			<div class="row">
				<div class="col-30">
					<label>Login</label>
				</div>
				<div class="col-70">
					<input type="text" name="login" placeholder="Login">
				</div>
			</div>

			<div class="row">
				<div class="col-30">
					<label>Password</label>
				</div>
				<div class="col-70">
					<input type="password" name="password" placeholder="Password">
				</div>
			</div>

			<div class="row">
				<div class="col-30">
					<label>Academic degree</label>
				</div>
				<div class="col-70">
					<select name="academic_degree">
						<option value="0" disabled selected>Not selected</option>
						@foreach ($academic_degrees as $academic_degree)
						<option value="{{$academic_degree->id}}">{{ $academic_degree->title_en}}</option>
						@endforeach
					</select>
				</div>
			</div>

			<div class="row">
				<div class="col-30">
					<label>Academic rank</label>
				</div>
				<div class="col-70">
					<select name="academic_rank">
						<option value="0" disabled selected>Not selected</option>
						@foreach ($academic_ranks as $academic_rank)
						<option value="{{$academic_rank->id}}">{{$academic_rank->description_en}}</option>
						@endforeach
					</select>
				</div>
			</div>

			<div class="row">
				<div class="col-30">
					<label>Department</label>
				</div>
				<div class="col-70">
					<select name="department">
						<option value="0" disabled selected>Not selected</option>
						@foreach ($departments as $department)
						<option value="{{$department->id}}">{{ $department->title_en}}</option>
						@endforeach
					</select>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<pre class="form-msg-error"></pre>
		<input type="hidden" name="id" value="">
		<input type="hidden" name="user_id" value="">
		<input type="submit" class="btn btn-type-rounded btn-hover-2 col-10" value="Edit">
	</div>
</form>
@endsection

@section('script')
<script type="text/javascript">
	window.onload = function ()
	{
		var links = document.getElementsByClassName("link");
		links[4].className = "link active";
	}

	var _type=["text", "select", "date", "hidden"]; 
	var _name=[
		"firstname", "lastname", "patronymic", "gender", "nationality", 
		"birthdate", "iin", "email", "tel", "login", "password", "academic_degree", 
		"academic_rank", "department", "id", "user_id"
	];

	var attrList=[@foreach ($teachers as $teacher)"{{ $teacher->id }}",@endforeach];

	var rmList=attrList, 
	    rmName=[
		@foreach ($teachers as $teacher)
		"{{ $teacher->firstname }}" + " {{ $teacher->lastname }}" + " {{ $teacher->patronymic }}",
		@endforeach
	];

	var mkArgs = [
		[_type[0], _name[0]],
		[_type[0], _name[1]],
		[_type[0], _name[2]],
		[_type[1], _name[3],
			[@foreach ($genders as $gender)"{{ $gender->description_en }}",@endforeach],
			[@foreach ($genders as $gender)"{{ $gender->id }}",@endforeach 0]
		], 
		[_type[1], _name[4],
			[@foreach ($nationalities as $nationality)"{{ $nationality->name_en }}",@endforeach],
			[@foreach ($nationalities as $nationality)"{{ $nationality->id }}",@endforeach 0]
		],
		[_type[2], _name[5]],
		[_type[0], _name[6]],
		[_type[0], _name[7]],
		[_type[0], _name[8]],
		[_type[0], _name[9]],
		[_type[0], _name[10]],
		[_type[1], _name[11],
			[@foreach ($academic_degrees as $academic_degree)"{{ $academic_degree->title_en }}",@endforeach],
			[@foreach ($academic_degrees as $academic_degree)"{{ $academic_degree->id }}",@endforeach 0]
		],
		[_type[1], _name[12],
			[@foreach ($academic_ranks as $academic_rank)"{{ $academic_rank->description_en }}",@endforeach],
			[@foreach ($academic_ranks as $academic_rank)"{{ $academic_rank->id }}",@endforeach 0]
		],
		[_type[1], _name[13],
			[@foreach ($departments as $department)"{{ $department->title_en }}",@endforeach],
			[@foreach ($departments as $department)"{{ $department->id }}",@endforeach 0]
		],
		[_type[3], _name[14]],
		[_type[3], _name[15]]
	];

	function isValidAddForm() 
	{
		var fm = document.getElementById("form_add"),
		    fmError = fm.getElementsByClassName("form-msg-error")[0];
			
		var fmInput = [
			[fm.querySelector("[name='firstname']"), "* Please insert firstname\n"],
			[fm.querySelector("[name='lastname']"), "* Please insert lastname\n"],
			[fm.querySelector("[name='patronymic']"), "* Please insert patronymic\n"],
			[fm.querySelector("[name='gender']"), "* Please select gender\n"],
			[fm.querySelector("[name='nationality']"), "* Please select nationality\n"],
			[fm.querySelector("[name='birthdate']"), "* Please select birthdate\n"],
			[fm.querySelector("[name='iin']"), "* Please insert iin\n"],
			[fm.querySelector("[name='email']"), "* Please insert email\n"],
			[fm.querySelector("[name='tel']"), "* Please insert phone number\n"],
			[fm.querySelector("[name='login']"), "* Please insert login\n"],
			[fm.querySelector("[name='password']"), "* Please insert password\n"],
			[fm.querySelector("[name='academic_degree']"), "* Please select academic degree\n"],
			[fm.querySelector("[name='academic_rank']"), "* Please select academic rank\n"],
			[fm.querySelector("[name='department']"), "* Please select department\n"]
		];

		fmError.innerHTML="\n";
		
		/*if (attrList.includes(fmInput[6][0].value)) {
			fmError.innerHTML = "* The inserted iin is already exists\n";
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

	function isValidRemoveForm() {return true;}

	function isValidEditForm() 
	{
		var fm = document.getElementById("form_edit"),
			fmError = fm.getElementsByClassName("form-msg-error")[0];
			
		var fmInput = [
			[fm.querySelector("[name='firstname']"), "* Please insert firstname\n"],
			[fm.querySelector("[name='lastname']"), "* Please insert lastname\n"],
			[fm.querySelector("[name='patronymic']"), "* Please insert patronymic\n"],
			[fm.querySelector("[name='gender']"), "* Please select gender\n"],
			[fm.querySelector("[name='nationality']"), "* Please select nationality\n"],
			[fm.querySelector("[name='birthdate']"), "* Please select birthdate\n"],
			[fm.querySelector("[name='iin']"), "* Please insert iin\n"],
			[fm.querySelector("[name='email']"), "* Please insert email\n"],
			[fm.querySelector("[name='tel']"), "* Please insert phone number\n"],
			[fm.querySelector("[name='login']"), "* Please insert login\n"],
			[fm.querySelector("[name='password']"), "* Please insert password\n"],
			[fm.querySelector("[name='academic_degree']"), "* Please select academic degree\n"],
			[fm.querySelector("[name='academic_rank']"), "* Please select academic rank\n"],
			[fm.querySelector("[name='department']"), "* Please select department\n"]
		];

		fmError.innerHTML="\n";
		
		/*if (attrList.includes(fmInput[6][0].value)) {
			fmError.innerHTML = "* The inserted iin is already exists\n";
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
