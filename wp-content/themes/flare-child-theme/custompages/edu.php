<html>
<body>
<?php
if($_POST){
$link = mysql_connect('localhost', 'themaro0_dev1', 'buildaresume!1');
if (!link) {
die('Could not connect: ' . mysql_error());
}
 
$db_selected = mysql_select_db('themaro0_dev1', $link);

if (!db_selected){
die('Cant use DB: ' . mysql_error());
}

$school = $_POST['school'];
$city = $_POST['city'];
$state = $_POST['state'];
$country = $_POST['Country'];
$degree = $_POST['Dname'];
$major = $_POST['major'];
$Gyear = $_POST['Gyear'];
$Gpa = $_POST['Gpa'];
$honors = $_POST['honors'];

$query = "INSERT INTO education(schoolName,gradyear, degreeType, degree, gpa, honors)VALUES('$school','$Gyear','$degree','$major','$Gpa','$honors')";

mysql_query ($query);
mysql_close($link);
}
?>

<form method="post" action="<?php $_PHP_SELF ?>">
<p><strong> School: </strong> <br/> <input type="text" name="school" maxlength="30" size="30"/> <br/> <br/> </p>
<p><strong> City: </strong><br/>  <input type="text" name="city" maxlength="20" size="20"/> <br/>  <br/> </p>
<strong> State: </strong></br>

<select name="State" style="width:150px;>

<option value="" selected="selected">Select a State</option>

<option value="AL">Alabama</option>

<option value="AK">Alaska</option>

<option value="AZ">Arizona</option>

<option value="AR">Arkansas</option>

<option value="CA">California</option>

<option value="CO">Colorado</option>

<option value="CT">Connecticut</option>

<option value="DE">Delaware</option>

<option value="DC">District Of Columbia</option>

<option value="FL">Florida</option>

<option value="GA">Georgia</option>

<option value="HI">Hawaii</option>

<option value="ID">Idaho</option>

<option value="IL">Illinois</option>

<option value="IN">Indiana</option>

<option value="IA">Iowa</option>

<option value="KS">Kansas</option>

<option value="KY">Kentucky</option>

<option value="LA">Louisiana</option>

<option value="ME">Maine</option>

<option value="MD">Maryland</option>

<option value="MA">Massachusetts</option>

<option value="MI">Michigan</option>

<option value="MN">Minnesota</option>

<option value="MS">Mississippi</option>

<option value="MO">Missouri</option>

<option value="MT">Montana</option>

<option value="NE">Nebraska</option>

<option value="NV">Nevada</option>

<option value="NH">New Hampshire</option>

<option value="NJ">New Jersey</option>

<option value="NM">New Mexico</option>

<option value="NY">New York</option>

<option value="NC">North Carolina</option>

<option value="ND">North Dakota</option>

<option value="OH">Ohio</option>

<option value="OK">Oklahoma</option>

<option value="OR">Oregon</option>

<option value="PA">Pennsylvania</option>

<option value="RI">Rhode Island</option>

<option value="SC">South Carolina</option>

<option value="SD">South Dakota</option>

<option value="TN">Tennessee</option>

<option value="TX">Texas</option>

<option value="UT">Utah</option>

<option value="VT">Vermont</option>

<option value="VA">Virginia</option>

<option value="WA">Washington</option>

<option value="WV">West Virginia</option>

<option value="WI">Wisconsin</option>

<option value="WY">Wyoming</option>

</select> <br/>


<br/>


    
<strong> Degree:</strong> <br/> 
<select name="Dname" id = "Dname">
 <option value = "Bachelors"> Bachelors</option>
<option value = "Masters"> Masters</option>
<option value = "Ph.D."> Ph.D.</option>
<option value = "Professional Doctoral Degree"> Professional Doctoral Degree</option>
  </select> <br/> <br/>
<p><strong> Major: </strong> </br>  <input type="text" name="major" maxlength="20" size="20"/> <br/> <br/> </p>
<p><strong> Graduated Year: </strong> </br>  <input type="text" name="Gyear" maxlength="20" size="20"/> <br/> <br/> </p>
<p><strong> GPA: </strong> </br>  <input type="text" name="Gpa" maxlength="4" size="4"/> <br/> <br/> </p>
<p><strong> Honors: </strong> </br>  <input type="text" name="honors" maxlength="20" size="20"/> <br/> <br/> </p>
<p><input type="submit" name = "Submit" value = "Submit" /></p>    <br/> <br/>

</form>
</body>
</html>
