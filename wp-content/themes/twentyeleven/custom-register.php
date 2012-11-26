<?php
/*
Template Name: Custom Register
*/
?>

<?php get_header(); ?>

<div id="left">
<div id="archive">

<h1><b>Please enter your information below</b> </h1>
<div id="result"></div> <!-- To hold validation results -->

<form action="" method="post">
	<label>First name</label> <br>
	<input type="text" name="fname" class="text" value="" /><br />

	<label>Last name</label> <br>
	<input type="text" name="lname" class="text" value="" /><br />
	
	<label>Email address</label> <br>
	<input type="text" name="username" class="text" value="" /><br />
	
	<label>Password</label> <br>
	<input type="text" name="email" class="text" value="" /> <br />
	<input type="submit" id="submitbtn" name="submit" value="Sign up" />
</form>

</div>
</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>

