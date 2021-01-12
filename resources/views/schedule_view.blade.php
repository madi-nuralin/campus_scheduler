<html>
	<head>
		<title>Campus Scheduler</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" type="text/css" href="/css/styles.css">
		<link rel="stylesheet" type="text/css" href="/css/table.css">
		<link rel="stylesheet" type="text/css" href="/css/modal.css">
		<link rel="stylesheet" type="text/css" href="/css/view.css">
		<link rel="stylesheet" type="text/css" href="/icons/font-awesome-4.7.0/css/font-awesome.min.css">
		<script src="/js/jquery-3.5.0.js"></script>
		<script src="/js/navbar.js"></script>
		<script src="/js/table.js"></script>
		<script src="/js/modal.js"></script>
	</head>

	<body>
		<header id="container">
			<ul>
				<li><a class="link" href="{{ url('/') }}"><img src="/img/iitu_logo.png" style="zoom:30%;"></a></li>
				<li><a class="link" href="{{ url('schedule') }}">Расписание</a></li>
				<li><a class="link" href="{{ url('lessons') }}">Учебный план</a></li>
				<li><a class="link" href="{{ url('subjects') }}">Предметы</a></li>
				<li><a class="link" href="{{ url('teachers') }}">Преподаватели</a></li>
				<li><a class="link" href="{{ url('groups') }}">Группы</a></li>
				<li><a class="link" href="{{ url('rooms') }}" id="active">Аудитории</a></li>
			</ul>
		</header>

		<main>
			<div class="main" style="margin: 20px 40px;">
				<div class="row">
					<div class="col-15">
						<select name="edu_programs" onchange="switchEduProgram(this)">
							<option value="0" disabled selected>Выберите образовательную программу</option>
							@foreach ($edu_programs as $edu_program)
							<option value="{{$edu_program->id}}">
								{{$edu_program->title_ru}}
							</option>
							@endforeach
						</select>
					</div>
					<div class="col-15">
						<select name="groups" onchange="switchSchedule(this)">
							<option value="0" disabled selected>Выберите группу</option>
							@foreach ($groups as $group)
							<option value="{{$group->name}}">
								{{$group->name}}
							</option>
							@endforeach
						</select>
					</div>
				</div>
				<div class="grid-container">
				</div>
			</div>
		</main>
	</body>
	<script type="text/javascript">
		function switchSchedule(select) {
			var group = select.value;

			var lsubjects = 
			[@foreach($lessons as $lesson)"{{$lesson->title_en}}",@endforeach];
			var lgroups = 
			[@foreach($lessons as $lesson)"{{$lesson->name}}",@endforeach];
			var lteachers = 
			[@foreach($lessons as $lesson)"{{$lesson->teacher_name}}",@endforeach];
			var llesson_types = 
			[@foreach($lessons as $lesson)"{{$lesson->lesson_types}}",@endforeach];
			var lrooms = 
			[@foreach($lessons as $lesson)"{{$lesson->room_id}}",@endforeach];
			var ltimeslots_id = 
			[@foreach($lessons as $lesson)"{{$lesson->timeslot_id}}",@endforeach];
			var lweek_days = 
			[@foreach($lessons as $lesson)"{{$lesson->week_day_id}}",@endforeach];
			var week_days = 
			[@foreach($week_days as $week_day)"{{$week_day->id}}",@endforeach];
			var timeslots_id = 
			[@foreach($timeslots as $timeslot)"{{$timeslot->id}}",@endforeach];
			var timeslots_at = 
			[@foreach($timeslots as $timeslot)"{{$timeslot->start_at}} {{$timeslot->end_at}}",@endforeach];
			var week_day_titles = 
			[@foreach($week_days as $week_day)"{{$week_day->title_en}}",@endforeach];

			var grid = document.getElementsByClassName("grid-container")[0];
				grid.innerHTML = "";

			var str="<div class=\"grid-item\"></div>";
			for (var i = 0; i < week_day_titles.length; i++) {
				str += "<div class=\"grid-item\">" + week_day_titles[i] + "</div>";
			}

			for (var i = 0; i < timeslots_id.length; i++) {
				str += "<div class=\"grid-item\">" + timeslots_at[i] + "</div>";
				//*
				for (var j = 0; j < week_days.length; j++) {
					var match=false;
					for (var k = 0; k < ltimeslots_id.length; k++) {
						if (ltimeslots_id[k] == timeslots_id[i] &&
							lweek_days[k] == week_days[j] && group == lgroups[k]) {
							str += 
							"<div class=\"grid-item filled\">" +
								"<div>" + lsubjects[k] + "</div>" +
								"<div>" + llesson_types[k] + "</div>" +
								"<div>" + "<i class=\"fa\">	&#xf007;</i> " + lteachers[k] + "</div>" +
								"<div>" + "<i class=\"fa\">	&#xf124;</i> " + lrooms[k] + "</div>" +
							"</div>";
							match = true;
							break;
						}
					}
					if (!match) {str += "<div class=\"grid-item\"></div>";}
				}
			}
			grid.innerHTML = str;
		}

		function switchEduProgram(selectEduProgram)
		{
			var selectGroup = document.getElementsByName("groups")[0];
			var newInnerHTML = "<option value=\"0\" disabled selected>Выберите группу</option>";
			var groups_edu_program = [@foreach($groups as $group)"{{$group->edu_program_id}}", @endforeach 0];
			var groups_name = [@foreach($groups as $group)"{{$group->name}}", @endforeach 0];
			selectGroup.innerHTML = "";
			
			for (var i = 0; i < groups_edu_program.length; ++i) {

				if (selectEduProgram.value == groups_edu_program[i]) {
					newInnerHTML += 
						"<option value=\"" + groups_name[i] + "\">" +
							 + "" + groups_name[i] +
						"</option>";
				}
			}
			
			selectGroup.innerHTML = newInnerHTML;
		}
	</script>
</html>
