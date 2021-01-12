@extends('layouts.app')

@section('table_title')
	Список аудитории
@endsection

@section('count')
	{{$room_count}}
@endsection

@section('thead')
	<tr>
		<th>
			<input class="checkbox" type="checkbox" onclick="tbSetAllRow('myTable', this)">
		</th>
		<th>Number</th>
		<th>Seats</th>
		<th>PC</th>
		<th>Projectors</th>
		<th>Type</th>
		<th>Created at</th>
		<th>Updated at</th>
		<th>Edit</th>
	</tr>
@endsection

@section('tbody')
	@foreach ($rooms as $room)
	<tr>
		<td>
			<input class="checkbox" type="checkbox" onclick="tbSetRow('myTable', this)">
		</td>
		<td>{{ $room->id }}</td>
		<td>{{ $room->seats }}</td>
		<td>{{ $room->pc }}</td>
		<td>{{ $room->projectors }}</td>
		<td>{{ $room->title_ru }}</td>
		<td>{{ $room->created_at }}</td>
		<td>{{ $room->updated_at }}</td>
		<td>
			<button class="btn btn-type-circle btn-hover-2" onclick="tbMkRow('myTable', this, mkArgs, 
				['{{$room->id}}', '{{$room->seats}}', '{{$room->pc}}', '{{$room->projectors}}', '{{$room->room_type_id}}']
			)">
				<i class="fa">&#xf044;</i>
			</button>
		</td>
	</tr>
	@endforeach
@endsection

@section('form_add')
<form id="form_add" method="post" action="{{ url('/rooms/add') }}" onsubmit="return isValidAddForm()">
	<p>New room</p>
	<div class="row">
		<div class="col-30">
			<label>Number</label>
		</div>
		<div class="col-70">
			<input type="text" name="number" placeholder="Number">
		</div>
	</div>
	<div class="row">
		<div class="col-30">
			<label>Seats</label>
		</div>
		<div class="col-70">
			<input type="number" name="seats" placeholder="Seats" min="0">
		</div>
	</div>
	<div class="row">
		<div class="col-30">
			<label>PC</label>
		</div>
		<div class="col-70">
			<input type="number" name="pc" placeholder="PC" min="0">
		</div>
	</div>
	<div class="row">
		<div class="col-30">
			<label>Projectors</label>
		</div>
		<div class="col-70">
			<input type="number" name="projectors" placeholder="Projectors" min="0">
		</div>
	</div>
	<div class="row">
		<div class="col-30">
			<label>Type</label>
		</div>
		<div class="col-70">
			<select name="type">
				<option value="0" disabled selected>Not selected</option>
				@foreach ($room_types as $room_type)
				<option value="{{$room_type->id}}">{{ $room_type->title_en }}</option>
				@endforeach
			</select>
		</div>
	</div>
	<div class="row">
		<pre class="form-msg-error"></pre>
		<input type="submit" class="btn btn-type-rounded btn-hover-2 col-20" value="Add">
	</div>
</form>
@endsection

@section('form_remove')
<form id="form_remove" method="post" action="{{ url('/rooms/remove') }}" onsubmit="return isValidRemoveForm()">
	<p>Remove selected items?</p>
	<ul id="removeList" style="background-color: transparent;float: none;"></ul>
	<input type="submit" class="btn btn-type-rounded btn-hover-2 col-20" value="Remove">
</form>
@endsection

@section('form_edit')
<form id="form_edit" method="post" action="{{ url('/rooms/edit') }}"onsubmit="return isValidEditForm()">
	<p>Edit room</p>
	<div class="row">
		<div class="col-30">
			<label>Number</label>
		</div>
		<div class="col-70">
			<input type="text" name="number" placeholder="Number" readonly>
		</div>
	</div>
	<div class="row">
		<div class="col-30">
			<label>Seats</label>
		</div>
		<div class="col-70">
			<input type="number" name="seats" placeholder="Seats" min="0">
		</div>
	</div>
	<div class="row">
		<div class="col-30">
			<label>PC</label>
		</div>
		<div class="col-70">
			<input type="number" name="pc" placeholder="PC" min="0">
		</div>
	</div>
	<div class="row">
		<div class="col-30">
			<label>Projectors</label>
		</div>
		<div class="col-70">
			<input type="number" name="projectors" placeholder="Projectors" min="0">
		</div>
	</div>
	<div class="row">
		<div class="col-30">
			<label>Type</label>
		</div>
		<div class="col-70">
			<select name="type">
				<option value="0" disabled selected>Not selected</option>
				@foreach ($room_types as $room_type)
				<option value="{{$room_type->id}}">{{ $room_type->title_en }}</option>
				@endforeach
			</select>
		</div>
	</div>
	<pre class="form-msg-error"></pre>
	<input type="submit" class="btn btn-type-rounded btn-hover-2 col-20" value="Save">
</form>
@endsection

@section('script')
	@parent
<script type="text/javascript">
	window.onload = function () 
	{
		var links = document.getElementsByClassName("link");
		links[6].className = "link active";
	}

	var _type=["text", "select"]; 
	var _name=["number", "seats", "pc", "projectors", "type"];

	var attrList=[@foreach ($rooms as $room)"{{ $room->id }}",@endforeach];

	var rmList=attrList, 
		rmName=[@foreach ($rooms as $room)"Room {{ $room->id }}",@endforeach];
			
	var mkArgs = [
		[_type[0], _name[0]],
		[_type[0], _name[1]],
		[_type[0], _name[2]], 
		[_type[0], _name[3]],
		[_type[1], _name[4],
			[@foreach ($room_types as $room_type)"{{ $room_type->title_en }}",@endforeach],
			[@foreach ($room_types as $room_type)"{{ $room_type->id }}",@endforeach, 0]
		]
	];

	function isValidAddForm() 
	{
		var fm = document.getElementById("form_add"),
			fmError = fm.getElementsByClassName("form-msg-error")[0];
			
		var fmInput = [
			[fm.querySelector("[name='number']"), "* Please insert room number\n"],
			[fm.querySelector("[name='seats']"), "* Please insert room seats\n"],
			[fm.querySelector("[name='pc']"), "* Please insert room PC\n"],
			[fm.querySelector("[name='projectors']"), "* Please insert room projectors\n"],
			[fm.querySelector("[name='types']"), "* Please select room type\n"]
		];

		fmError.innerHTML="\n";
		
		if (attrList.includes(fmInput[0][0].value)) {
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
		return true;
	}

	function isValidRemoveForm() {
		return true;	
	}

	function isValidEditForm() {
		var fm = document.getElementById("form_edit"),
			fmError = fm.getElementsByClassName("form-msg-error")[0];
			
		var fmInput = [
			[fm.querySelector("[name='seats']"), "* Please insert room seats\n"],
			[fm.querySelector("[name='pc']"), "* Please insert room PC\n"],
			[fm.querySelector("[name='projectors']"), "* Please insert room projectors\n"],
			[fm.querySelector("[name='types']"), "* Please select room type\n"]
		];

		fmError.innerHTML="\n";

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
