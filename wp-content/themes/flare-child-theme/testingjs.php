<?php 

// Template name: testing JS!!!

?>

<?php //get_header(); ?>



<?php 

echo '

<!doctype html>

<html lang="en">

<head>

	<meta charset="utf-8">

	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

	<title>VanillaJS • TodoMVC</title>

	<link rel="stylesheet" href="/wp-content/themes/flare-child-theme/assets/base.css">

	<!--[if IE]>

	<script src="/wp-content/themes/flare-child-theme/assets/ie.js"></script>

	<![endif]-->

</head>

<body>

	<section id="todoapp">

		<header id="header">

			<h1>todos</h1>

			<input id="new-todo" placeholder="What needs to be done?" autofocus>

		</header>

		<section id="main">

			<input id="toggle-all" type="checkbox">

			<label for="toggle-all">Mark all as complete</label>

			<ul id="todo-list"></ul>

		</section>

		<footer id="footer">

			<span id="todo-count"></span>

			<button id="clear-completed">Clear completed</button>

		</footer>

	</section>

	<footer id="info">

		<p>Double-click to edit a todo</p>

		<p>Template by <a href="http://github.com/sindresorhus">Sindre Sorhus</a></p>

		<p>Created by <a href="http://twitter.com/ffesseler">Florian Fesseler</a></p>

		<p>Cleanup, edits by <a href="http://github.com/boushley">Aaron Boushley</a></p>

	</footer>

	<script src="/wp-content/themes/flare-child-theme/assets/base.js"></script>

	<script src="/wp-content/themes/flare-child-theme/js/app.js"></script>

</body>

</html>';

?>



<?php //get_footer(); ?>