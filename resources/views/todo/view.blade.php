@extends('layouts.main')

@section('content')
	<div class="mb20">
		<a href="{!!route('todo/index')!!}" class="btn btn-block">Вернуться назад</a>
	</div>

	<div id="todo"></div>
@endsection

@section('scripts')
	<?='<script type="text/template" id="todo-tpl">'?>
		<div>
			<div class="mb20">
				<label class="form-label">Название:</label>
				<input type="text" value="<%-data.todo.name%>" class="form-input" todo-name />
			</div>
			<section class="todoapp">
				<header class="header">
					<input class="new-todo" placeholder="What needs to be done?" autofocus todo-item-add>
				</header>
				<!-- This section should be hidden by default and shown when there are todos -->
				<section class="main">
					<input class="toggle-all" type="checkbox">
					<label for="toggle-all">Mark all as complete</label>
					<ul class="todo-list" todo-items>
						<!-- These are here just to show the structure of the list items -->
						<!-- List items should get the class `editing` when editing and `completed` when marked as completed -->
<!--						<li class="completed">
							<div class="view">
								<input class="toggle" type="checkbox" checked>
								<label>Taste JavaScript</label>
								<button class="destroy"></button>
							</div>
							<input class="edit" value="Create a TodoMVC template">
						</li>
						<li>
							<div class="view">
								<input class="toggle" type="checkbox">
								<label>Buy a unicorn</label>
								<button class="destroy"></button>
							</div>
							<input class="edit" value="Rule the web">
						</li>-->
					</ul>
				</section>
				<!-- This footer should hidden by default and shown when there are todos -->
				<footer class="footer">
					<!-- This should be `0 items left` by default -->
					<span class="todo-count"><strong todo-items-count><%=itemsCount()%></strong> item left</span>
					<!-- Remove this if you don't implement routing -->
					<ul class="filters">
						<li>
							<a <%=(data.filter === 'all') ? 'class="selected"' : ''%> href="#/" todo-filter="all">All</a>
						</li>
						<li>
							<a <%=(data.filter === 'active') ? 'class="selected"' : ''%> href="#/active" todo-filter="active">Active</a>
						</li>
						<li>
							<a <%=(data.filter === 'completed') ? 'class="selected"' : ''%> href="#/completed" todo-filter="completed">Completed</a>
						</li>
					</ul>
					<!-- Hidden if no completed items are left ↓ -->
					<button class="clear-completed" todo-clear-completed>Clear completed</button>
				</footer>
			</section>
		</div>
	<?='</script>'?>

	<?='<script type="text/template" id="todo-item-tpl">'?>
		<li class="<%=(data.item.completed) ? 'completed' : ''%>" style="display: <%=(visible()) ? 'block' : 'none'%>;">
			<div class="view">
				<input class="toggle" type="checkbox" <%=(data.item.completed) ? 'checked' : ''%> todo-item-completed />
				<label><%-data.item.description%></label>
				<button class="destroy" todo-item-delete></button>
			</div>
			<input class="edit" value="Rule the web">
		</li>
	<?='</script>'?>
@endsection