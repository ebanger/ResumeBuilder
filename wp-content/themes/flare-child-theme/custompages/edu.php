<html>
<body>
<?php
$current_user = wp_get_current_user();

$link = mysql_connect('localhost', 'themaro0_dev1', 'buildaresume!1');

if (!link) {
    die('Could not connect: ' . mysql_error());
}

$db_selected = mysql_select_db('themaro0_dev1', $link);

if (!db_selected){
    die('Cant use DB: ' . mysql_error());
}

$query = sprintf("SELECT userID from users where email='" . $current_user->user_login ."'");
$result = mysql_query($query);
$current_ID = mysql_result($result, 0);

$query = sprintf("SELECT schoolName, gradyear, degreeType, degree, gpa, honors, city, state FROM education WHERE userID='" . $current_ID . "'");
$result = mysql_query($query);

while($row = mysql_fetch_assoc($result)){
    $schoolName = $row['schoolName'];
    $gradyear = $row['gradyear'];
    $degreeType = $row['degreeType'];
    $degree = $row['degree'];
    $gpa = $row['gpa'];
    $honors = $row['honors'];
    $city = $row['city'];
    $state = $row['state'];
    }


if($_POST){

    $schoolName = $_POST['schoolName'];
    $gradyear = $_POST['gradyear'];
    $degreeType = $_POST['degreeType'];
    $degree = $_POST['degree'];
    $gpa = $_POST['gpa'];
    $honors = $_POST['honors'];
    $city = $_POST['city'];
    $state = $_POST['state'];

if($num > 0){
    $query = "UPDATE education SET schoolName = '$schoolName', gradyear = '$gradyear', degreeType = '$degreeType', degree = '$degree', gpa = '$gpa', honors = '$honors', city = '$city', state = '$state' WHERE userID = '$current_ID'";
} elseif($num == 0) {
    $query = "INSERT INTO education(userID, schoolName, gradyear, degreeType, degree, gpa, honors, city, state)VALUES('$current_ID', '$schoolName', '$gradyear', '$degreeType', '$degree', '$gpa', '$honors','$city', '$state')";
}

mysql_query ($query);
mysql_close($link);
}
?>

<form method="post" action="<?php $_PHP_SELF ?>">
<p><strong> School: </strong> <br/> <input type="text" name="schoolName" maxlength="30" size="30" value=<?php echo $schoolName ?> /> <br/> <br/> </p>
<p><strong> City: </strong><br/>  <input type="text"name="city"  maxlength="20" size="20" value=<?php echo "'" . $city . "'" ?> /> <br/>  <br/> </p>
<p><strong> State: </strong> <br/> <input type="text" name="state"  maxlength="30" size="30" value=<?php echo $state ?> /> <br/> <br/> </p>
<p><strong> Degree: </strong> <br/> <input type="text" name="degreeType" maxlength="30" size="30" value=<?php echo $degreeType?> /> <br/> <br/> </p>
<p><strong> Major: </strong> </br>  <input type="text" name="degree" maxlength="20" size="20" value=<?php echo $degree?> /> <br/> <br/> </p>
<p><strong> Graduated Year: </strong> </br>  <input type="text" name="gradyear" maxlength="20" size="20" value=<?php echo $gradyear ?> /> <br/> <br/> </p>
<p><strong> GPA: </strong> </br>  <input type="text" name="gpa" maxlength="4" size="4" value=<?php echo $gpa ?> /> <br/> <br/> </p>
<p><strong> Honors: </strong> </br>  <input type="text" name="honors" maxlength="20" size="20" value=<?php echo "'" . $honors . "'" ?> /> <br/> <br/> </p>
<p><input type="submit" name = "Submit" value = "Submit" /></p>    <br/> <br/>

</form>
</body>
</html>