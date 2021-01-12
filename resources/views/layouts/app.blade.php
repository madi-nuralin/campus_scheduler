<!DOCTYPE html>
<html>
	<head>
	@section('head')
		<title>Campus Scheduler</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="icon" href="/img/iitu.ico">
		<link rel="stylesheet" type="text/css" href="/css/styles.css">
		<link rel="stylesheet" type="text/css" href="/css/table.css">
		<link rel="stylesheet" type="text/css" href="/css/modal.css">
		<link rel="stylesheet" type="text/css" href="/icons/font-awesome-4.7.0/css/font-awesome.min.css">
		<script src="/js/jquery-3.5.0.js"></script>
		<script src="/js/navbar.js"></script>
		<script src="/js/table.js"></script>
		<script src="/js/modal.js"></script>
	@show
	</head>

	<body>
	@section('body')
		<header id="nav-container">
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
			<div class="main">
			@section('main')
				<div class="row" id="myToolbar" style="padding: 0 0 15px 0">
					<div class="col-20">
						<div>@yield('table_title')</div>
					</div>
					<div class="col-20">
						<div>@yield('count') элементов</div>
					</div>
					<div class="col-20">
						<div class="btn btn-hover-1" onclick="tbAddRow('myTable')">
							<!--i class="fa">&#xf271;</i-->Добавить
						</div>
					</div>
					<div class="col-20">
						<div class="btn btn-hover-1" onclick="tbRmRow('myTable', rmList, rmName)">
							<!--i class="fa">&#xf1f8;</i-->Удалить
						</div>
					</div>
					<div class="col-20">
						<div class="btn btn-hover-1">
							<!--i class="fa">&#xf1f8;</i-->Экспорт
						</div>
					</div>
				</div>
				<div>
					<table class="table" id="myTable">
						<thead>
							@yield('thead')
						</thead>
						<tbody>
							@yield('tbody')
						</tbody>
					</table>	
				</div>
			@show
			</div>
		</main>
		<div class="modal">
			<div class="modalWindow">
				@yield('form_add')
			</div>
			<div class="modalWindow">
				@yield('form_remove')
			</div>
			<div class="modalWindow">
				@yield('form_edit')
			</div>
		</div>
	@show
	@section('script')
	@show
	</body>
</html>
