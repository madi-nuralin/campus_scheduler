@extends('layouts.app')

@section('table_title')
	Schdedule list
@endsection

@section('thead')
	<tr>
		<th>
			<input class="checkbox" type="checkbox" onclick="tbSetAllRow('myTable', this)">
		</th>
		<th>Title</th>
		<th>Start at</th>
		<th>Expires at</th>
		<th>Created at</th>
		<th>Updated at</th>
		<th>View</th>
	</tr>
@endsection

@section('tbody')
	@foreach($schedules as $schedule)
	<tr>
		<td>
			<input class="checkbox" type="checkbox" onclick="tbSetRow('myTable', this)">
		</td>
		<td>{{$schedule->title_en}}</td>
		<td>{{$schedule->start_at}}</td>
		<td>{{$schedule->expires_at}}</td>
		<td>{{$schedule->created_at}}</td>
		<td>{{$schedule->updated_at}}</td>
		<td>
			<a class="btn btn-type-circle btn-hover-2" href="{{ url('schedule_view') }}" onclick="tbMkRow('myTable', this, /*mkArgs*/0, [''])">
				<i class="fa">&#xf08e;</i>
			</a>
		</td>
	</tr>	
	@endforeach
@endsection

@section('form_add')
<form id="form_add" method="post" action="{{ url('/schedule/add') }}" onsubmit="return isValidAddForm()">
	<p>New schedule</p>
	
	<div class="row">
		<div class="col-30">
			<label>Название</label>
		</div>
		<div class="col-70">
			<input type="text" name="schedule_title" placeholder="Название">
		</div>
	</div>
	<div class="row">
		<div class="col-30">
			<label>Список планов</label>
		</div>
		<div class="col-70">
			<select name="academic_plan_id[]" multiple="">
				<option value="0" disabled selected>Not selected</option>
				@foreach($academic_plans as $ap)
				<option value="{{$ap->id}}">{{$ap->title_en}}</option>
				@endforeach
			</select>
			<!--div class="dropdown" onclick="drop_down(this)">
			  <div class="dropbtn" onclick="drop_down(this)">Academic plans: <span></span></div>
			  <ul class="dropdown_content">
			    @foreach ($academic_plans as $ap)
					<li>
						<input type="checkbox" name="" onclick="dropdown_update(this, 'academic_plan_id[]')">
						<span>{{$ap->title_en}}</span>	
						<input type="hidden" name="hidden_id[]" value="{{$ap->id}}">
					</li>
					@endforeach
			  </ul>
			</div-->
		</div>
	</div>

	<div class="row">
		<div class="col-30">
			<label>Дата начала</label>
		</div>
		<div class="col-70">
			<input type="date" name="start_at">
		</div>
	</div>
	<div class="row">
		<div class="col-30">
			<label>Дата завершения</label>
		</div>
		<div class="col-70">
			<input type="date" name="expires_at">
		</div>
	</div>
	<div class="row">
		<div class="col-30">
			<label>Время</label>
		</div>
		<div class="col-70">
			<select name="timeslot_id[]" multiple="">
				<option value="0" disabled selected>Not selected</option>
				@foreach($timeslots as $ts)
				<option value="{{$ts->id}}">{{$ts->start_at}}-{{$ts->end_at}}</option>
				@endforeach
			</select>
			<!--div class="dropdown" onclick="drop_down(this)">
			  <div class="dropbtn" onclick="drop_down(this)">Timeslots: <span></span></div>
			  <ul class="dropdown_content">
			    @foreach ($timeslots as $ts)
					<li>
						<input type="checkbox" name="" onclick="dropdown_update(this, 'timeslot_id[]')">
						<span>{{$ts->start_at}}-{{$ts->end_at}}</span>	
						<input type="hidden" name="hidden_id[]" value="{{$ts->id}}">
					</li>
					@endforeach
			  </ul>
			</div-->
		</div>
	</div>
	<div class="row">
		<pre class="form-msg-error"></pre>
		<input type="submit" class="btn btn-type-rounded btn-hover-2 col-25" value="Создать">
	</div>
	
</form>
@endsection

@section('form_remove')
<form id="form_remove" method="post" action="{{ url('/schedule/remove') }}" onsubmit="return isValidRemoveForm()">
	<p>Remove selected items?</p>
	<ul id="removeList" style="background-color: transparent;float: none;"></ul>
	<input type="submit" class="btn btn-type-rounded btn-hover-2 col-20" value="Remove">
</form>
@endsection

@section('form_edit')
<form>
	<p>Edit course</p>

</form>
@endsection

@section('script')
	@parent
<script type="text/javascript">
	window.onload = function () 
	{
		var links = document.getElementsByClassName("link");
		links[1].className = "link active";
	}

	var attrList=[@foreach ($schedules as $schedule)"{{ $schedule->title_en }}",@endforeach];

	var rmList=attrList, 
		rmName=attrList;

	function isValidAddForm() {
		var fm = document.getElementById("form_add"),
			fmError = fm.getElementsByClassName("form-msg-error")[0];
			
		var fmInput = [
			[fm.querySelector("[name='schedule_title'"), "* Please insert schedule title\n"],
			[fm.querySelector("[name='academic_plans[]']"), "* Please select academic plans\n"],
			[fm.querySelector("[name='start_at']"), "* Please select start date\n"],
			[fm.querySelector("[name='end_at']"), "* Please select end date\n"],
			[fm.querySelector("[name='timeslots[]']"), "* Please select timeslots\n"]
		];

		fmError.innerHTML="\n";

		if (attrList.includes(fmInput[0][0].value)) {
			fmError.innerHTML = "* The inserted schedule title is already exists\n";
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

	function isValidRemoveForm() {return true;}
</script>
@endsection
