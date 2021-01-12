@extends('layouts.app')

@section('table_title')
	Список предметов	
@endsection

@section('count')
	{{$subject_count}}
@endsection

@section('thead')
	<tr>
		<th>
			<input class="checkbox" type="checkbox" onclick="tbSetAllRow('myTable', this)">
		</th>
		<th>Subject</th>
		<th>Code</th>
		<th>Department</th>
		<th>Hours</th>
		<th>Language</th>
		<th>Credits</th>
		<th>Updated at</th>
		<th>Edit</th>
	</tr>
@endsection

@section('tbody')
	@foreach ($subjects as $subject)
	<tr>
		<td>
			<input class="checkbox" type="checkbox" onclick="tbSetRow('myTable', this)">
		</td>
		<td>{{ $subject->title_en }}</td>
		<td>{{ $subject->subject_code_en }}</td>
		<td>{{ $subject->department }}</td>
		<td>{{ $subject->lection }},{{ $subject->lab }},{{ $subject->practice }}</td>
		<td>NULL</td>
		<td>{{ $subject->ects_credits }}</td>
		<td>{{ $subject->updated_at }}</td>
		<td>
			<button class="btn btn-type-circle btn-hover-2" onclick="tbMkRow('myTable', this, mkArgs, [
					'{{$subject->title_kk}}', '{{$subject->title_ru}}', '{{$subject->title_en}}', '{{$subject->subject_code_kk}}', '{{$subject->subject_code_ru}}', '{{$subject->subject_code_en}}', '{{$subject->description_kk}}', '{{$subject->description_ru}}', '{{$subject->description_en}}', '{{$subject->degree_id}}', '{{$subject->department_id}}', '{{$subject->lection}}', '{{$subject->lab}}', '{{$subject->practice}}', '{{$subject->is_additional}}', '{{$subject->is_language_discipline}}', '{{$subject->is_multilingual}}', '{{$subject->is_research}}', '{{$subject->is_practice}}', '{{$subject->ects_credits}}', '{{$subject->id}}'
			])">
				<i class="fa">&#xf044;</i>
			</button>
		</td>
	</tr>
	@endforeach
@endsection

@section('form_add')
<form id="form_add" method="post" action="{{ url('/subjects/add') }}" onsubmit="return isValidAddForm()">
	<p>New subject</p>
	<div class="row">
		<div class="col-45">
			<div class="row">
				<div class="col-30">
					<label>Title</label>	
				</div>
				<div class="col-70">
					<div class="row">
						<div class="col-100">
							<input type="text" name="title_kk" placeholder="kk">
						</div>
					</div>
					<div class="row">
						<div class="col-100">
							<input type="text" name="title_ru" placeholder="ru">
						</div>
					</div>
					<div class="row">
						<div class="col-100">
							<input type="text" name="title_en" placeholder="en">
						</div>
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-30">
					<label>Code</label>	
				</div>
				<div class="col-70">
					<div class="row">
						<div class="col-100">
							<input type="text" name="subject_code_kk" placeholder="kk">
						</div>
					</div>
					<div class="row">
						<div class="col-100">
							<input type="text" name="subject_code_ru" placeholder="ru">
						</div>
					</div>

					<div class="row">
						<div class="col-100">
							<input type="text" name="subject_code_en" placeholder="en">
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-30">
					<label>Description</label>
				</div>
				<div class="col-70">
					<div class="row">
						<div class="col-100">
							<textarea name="description_kk" placeholder="kk"></textarea>
						</div>
					</div>
					<div class="row">
						<div class="col-100">
							<textarea name="description_ru" placeholder="ru"></textarea>	
						</div>
					</div>

					<div class="row">
						<div class="col-100">
							<textarea name="description_en" placeholder="en"></textarea>	
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="col-55" style="padding-left: 20px">
			<div class="row">
				<div class="col-30">
					<label>Degree</label>	
				</div>
				<div class="col-70">
					<select name="degree_id">
						<option value="0" disabled selected>Not selected</option>
						@foreach ($academic_degrees as $academic_degree)
						<option value="{{$academic_degree->id}}">
							{{ $academic_degree->title_en}}
						</option>
						@endforeach
					</select>	
				</div>
			</div>

			<div class="row">
				<div class="col-30">
					<label>Department</label>
				</div>
				<div class="col-70">
					<select name="department_id">
						<option value="0" disabled selected>Not selected</option>
						@foreach ($departments as $department)
						<option value="{{$department->id}}">
							{{ $department->title_en}}
						</option>
						@endforeach
					</select>
				</div>
			</div>

			<div class="row">
				<div class="col-30">
					<label>Lection</label>	
				</div>
				<div class="col-70">
					<input type="number" name="lection" placeholder="Lection" min="0">
				</div>
			</div>

			<div class="row">
				<div class="col-30">
					<label>Lab</label>
				</div>
				<div class="col-70">
					<input type="number" name="lab" placeholder="Lab" min="0">
				</div>
			</div>

			<div class="row">
				<div class="col-30">
					<label>Practice</label>
				</div>
				<div class="col-70">
					<input type="number" name="practice" placeholder="Practice" min="0">
				</div>
			</div>

			<div class="row">
				<div class="col-30">
					<label>Additional</label>	
				</div>
				
				<div class="col-70">
					<div class="row">
						<input type="checkbox" id="is_additional" name="is_additional">
						<label for="is_additional">additional</label>
					</div>
					<div class="row">
						<input type="checkbox" id="is_language_discipline" name="is_language_discipline">
						<label for="is_language_discipline">language discipline</label>
					</div>
					<div class="row">
						<input type="checkbox" id="is_multilingual" name="is_multilingual">
						<label for="is_multilingual">multilingual</label>
					</div>
					<div class="row">
						<input type="checkbox" id="is_research" name="is_research">
						<label for="is_research">research</label>
					</div>
					<div class="row">
						<input type="checkbox" id="is_practice" name="is_practice">
						<label for="is_practice">practice</label>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-30">
					<label>Credits</label>	
				</div>
				<div class="col-70">
					<input type="number" name="ects_credits" placeholder="Credits" min="0">	
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<pre class="form-msg-error"></pre>
		<input type="submit" class="btn btn-type-rounded btn-hover-2 col-10" value="Add">
	</div>
</form>
@endsection

@section('form_remove')
<form id="form_remove" method="post" action="{{ url('/subjects/remove') }}" onsubmit="return isValidRemoveForm()"><form>
	<p>Remove selected items?</p>
	<ul id="removeList" style="background-color: transparent;float: none;"></ul>
	<input type="submit" class="btn btn-type-rounded btn-hover-2 col-20" value="Remove">
</form>
@endsection

@section('form_edit')
<form id="form_edit" method="post" action="{{ url('/subjects/edit') }}" onsubmit="return isValidEditForm()">
	<p>Edit subject</p>
	<div class="row">
		<div class="col-45">
			<div class="row">
				<div class="col-30">
					<label>Title</label>	
				</div>
				<div class="col-70">
					<div class="row">
						<div class="col-100">
							<input type="text" name="title_kk" placeholder="kk" readonly>
						</div>
					</div>
					<div class="row">
						<div class="col-100">
							<input type="text" name="title_ru" placeholder="ru" readonly>
						</div>
					</div>
					<div class="row">
						<div class="col-100">
							<input type="text" name="title_en" placeholder="en" readonly>
						</div>
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-30">
					<label>Code</label>	
				</div>
				<div class="col-70">
					<div class="row">
						<div class="col-100">
							<input type="text" name="subject_code_kk" placeholder="kk" readonly>
						</div>
					</div>
					<div class="row">
						<div class="col-100">
							<input type="text" name="subject_code_ru" placeholder="ru" readonly>
						</div>
					</div>

					<div class="row">
						<div class="col-100">
							<input type="text" name="subject_code_en" placeholder="en" readonly>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-30">
					<label>Description</label>
				</div>
				<div class="col-70">
					<div class="row">
						<div class="col-100">
							<textarea name="description_kk" placeholder="kk"></textarea>
						</div>
					</div>
					<div class="row">
						<div class="col-100">
							<textarea name="description_ru" placeholder="ru"></textarea>	
						</div>
					</div>

					<div class="row">
						<div class="col-100">
							<textarea name="description_en" placeholder="en"></textarea>	
						</div>
					</div>
				</div>
			</div>		
		</div>

		<div class="col-55" style="padding-left: 20px">
			<div class="row">
				<div class="col-30">
					<label>Degree</label>	
				</div>
				<div class="col-70">
					<select name="degree_id">
						<option value="0" disabled selected>Not selected</option>
						@foreach ($academic_degrees as $academic_degree)
						<option value="{{$academic_degree->id}}">
							{{ $academic_degree->title_en}}
						</option>
						@endforeach
					</select>	
				</div>
			</div>

			<div class="row">
				<div class="col-30">
					<label>Department</label>
				</div>
				<div class="col-70">
					<select name="department_id">
						<option value="0" disabled selected>Not selected</option>
						@foreach ($departments as $department)
						<option value="{{$department->id}}">
							{{ $department->title_en}}
						</option>
						@endforeach
					</select>
				</div>
			</div>

			<div class="row">
				<div class="col-30">
					<label>Lection</label>	
				</div>
				<div class="col-70">
					<input type="number" name="lection" placeholder="Lection" min="0">
				</div>
			</div>

			<div class="row">
				<div class="col-30">
					<label>Lab</label>
				</div>
				<div class="col-70">
					<input type="number" name="lab" placeholder="Lab" min="0">
				</div>
			</div>

			<div class="row">
				<div class="col-30">
					<label>Practice</label>
				</div>
				<div class="col-70">
					<input type="number" name="practice" placeholder="Practice" min="0">
				</div>
			</div>

			<div class="row">
				<div class="col-30">
					<label>Additional</label>	
				</div>
				
				<div class="col-70">
					<div class="row">
						<input type="checkbox" id="is_additional" name="is_additional">
						<label for="is_additional">additional</label>
					</div>
					<div class="row">
						<input type="checkbox" id="is_language_discipline" name="is_language_discipline">
						<label for="is_language_discipline">language discipline</label>
					</div>
					<div class="row">
						<input type="checkbox" id="is_multilingual" name="is_multilingual">
						<label for="is_multilingual">multilingual</label>
					</div>
					<div class="row">
						<input type="checkbox" id="is_research" name="is_research">
						<label for="is_research">research</label>
					</div>
					<div class="row">
						<input type="checkbox" id="is_practice" name="is_practice">
						<label for="is_practice">practice</label>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-30">
					<label>Credits</label>	
				</div>
				<div class="col-70">
					<input type="number" name="ects_credits" placeholder="Credits" min="0">	
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<pre class="form-msg-error"></pre>
		<input type="hidden" name="id">
		<input type="submit" class="btn btn-type-rounded btn-hover-2 col-10" value="Edit">
	</div>
</form>
@endsection

@section('script')
@parent
<script type="text/javascript">
	window.onload = function () 
	{
		var links = document.getElementsByClassName("link");
		links[3].className = "link active";
	}

	var _type=["text", "select", "date", "hidden", "number", "textarea", "checkbox"]; 
	var _name=["title_kk", "title_ru", "title_en", "subject_code_kk", "subject_code_ru", "subject_code_en", "description_kk", "description_ru", "description_en", "degree_id", "department_id", "lection", "lab", "practice", "is_additional", "is_language_discipline", "is_multilingual", "is_research", "is_practice", "ects_credits", "id"];

	var attrList=[@foreach ($subjects as $subject)"{{ $subject->id }}",@endforeach];

	var rmList=attrList, 
		rmName=[
			@foreach ($subjects as $subject)
			"{{ $subject->title_en }}" + " {{ $subject->subject_code_en }}",
			@endforeach
		];

  var mkArgs = [
		[_type[0], _name[0]],
		[_type[0], _name[1]],
		[_type[0], _name[2]],
		[_type[0], _name[3]],
		[_type[0], _name[4]],
		[_type[0], _name[5]],
		[_type[5], _name[6]],
		[_type[5], _name[7]],
		[_type[5], _name[8]],
		[_type[1], _name[9],
			[@foreach ($academic_degrees as $academic_degree)"{{ $academic_degree->title_en }}",@endforeach],
			[@foreach ($academic_degrees as $academic_degree)"{{ $academic_degree->id }}",@endforeach 0]
		], 
		[_type[1], _name[10],
			[@foreach ($departments as $department)"{{ $department->title_en }}",@endforeach],
			[@foreach ($departments as $department)"{{ $department->id }}",@endforeach 0]
		], 
		[_type[4], _name[11]],
		[_type[4], _name[12]],
		[_type[4], _name[13]],

		[_type[6], _name[14]],
		[_type[6], _name[15]],
		[_type[6], _name[16]],
		[_type[6], _name[17]],
		[_type[6], _name[18]],
		[_type[4], _name[19]],
		[_type[3], _name[20]]
	];

	function isValidAddForm() 
	{
		var fm = document.getElementById("form_add"),
			fmError = fm.getElementsByClassName("form-msg-error")[0];
			
		var fmInput = [
			[fm.querySelector("[name='title_kk']"), "* Please insert title in kk\n"],
			[fm.querySelector("[name='title_ru']"), "* Please insert title in ru\n"],
			[fm.querySelector("[name='title_en']"), "* Please insert title in en\n"],
			[fm.querySelector("[name='subject_code_kk']"), "* Please insert subject code in kk\n"],
			[fm.querySelector("[name='subject_code_ru']"), "* Please insert subject code in ru\n"],
			[fm.querySelector("[name='subject_code_en']"), "* Please insert subject code in en\n"],
			[fm.querySelector("[name='description_kk']"), "* Please insert description in kk\n"],
			[fm.querySelector("[name='description_ru']"), "* Please insert description in ru\n"],
			[fm.querySelector("[name='description_en']"), "* Please insert description in en\n"],
			[fm.querySelector("[name='degree_id']"), "* Please select degree\n"],
			[fm.querySelector("[name='department_id']"), "* Please select department\n"],
			[fm.querySelector("[name='lection']"), "* Please insert lection hours\n"],
			[fm.querySelector("[name='lab']"), "* Please insert lab hours\n"],
			[fm.querySelector("[name='practice']"), "* Please insert practice hours\n"],
			[fm.querySelector("[name='ects_credits']"), "* Please insert credits\n"],
		];

		fmError.innerHTML="\n";
		
		for (var i = 0; i < 6; i++) {
			if (attrList.includes(fmInput[i][0].value)) {
				fmError.innerHTML = "* The inserted value is already exists\n";
				fmInput[i][0].style = "border-bottom:solid 1px red";
				return false;
			}
		}
			

		for (var i = 0; i < fmInput.length; i++) {
			fmInput[i][0].style = "border-bottom:solid 1px #ccc";

			if (parseInt(fmInput[i][0].value) < 0 || fmInput[i][0].value.length == 0) {
				fmError.innerHTML = fmInput[i][1];
				fmInput[i][0].style = "border-bottom:solid 1px red";
				return false;
			}
		}
		return true;
	}

	function isValidEditForm() {return true;}

	function isValidEditForm() 
	{
		var fm = document.getElementById("form_edit"),
			fmError = fm.getElementsByClassName("form-msg-error")[0];
			
		var fmInput = [
			[fm.querySelector("[name='title_kk']"), "* Please insert title in kk\n"],
			[fm.querySelector("[name='title_ru']"), "* Please insert title in ru\n"],
			[fm.querySelector("[name='title_en']"), "* Please insert title in en\n"],
			[fm.querySelector("[name='subject_code_kk']"), "* Please insert subject code in kk\n"],
			[fm.querySelector("[name='subject_code_ru']"), "* Please insert subject code in ru\n"],
			[fm.querySelector("[name='subject_code_en']"), "* Please insert subject code in en\n"],
			[fm.querySelector("[name='description_kk']"), "* Please insert description in kk\n"],
			[fm.querySelector("[name='description_ru']"), "* Please insert description in ru\n"],
			[fm.querySelector("[name='description_en']"), "* Please insert description in en\n"],
			[fm.querySelector("[name='degree_id']"), "* Please select degree\n"],
			[fm.querySelector("[name='department_id']"), "* Please select department\n"],
			[fm.querySelector("[name='lection']"), "* Please insert lection hours\n"],
			[fm.querySelector("[name='lab']"), "* Please insert lab hours\n"],
			[fm.querySelector("[name='practice']"), "* Please insert practice hours\n"],
			[fm.querySelector("[name='ects_credits']"), "* Please insert credits\n"],
		];

		fmError.innerHTML="\n";
		/*
		for (var i = 0; i < 6; i++) {
			if (attrList.includes(fmInput[i][0].value)) {
				fmError.innerHTML = "* The inserted value is already exists\n";
				fmInput[i][0].style = "border-bottom:solid 1px red";
				return false;
			}
		}*/
			

		for (var i = 0; i < fmInput.length; i++) {
			fmInput[i][0].style = "border-bottom:solid 1px #ccc";

			if (parseInt(fmInput[i][0].value) < 0 || fmInput[i][0].value.length == 0) {
				fmError.innerHTML = fmInput[i][1];
				fmInput[i][0].style = "border-bottom:solid 1px red";
				return false;
			}
		}
		return true;
	}
</script>
@endsection
