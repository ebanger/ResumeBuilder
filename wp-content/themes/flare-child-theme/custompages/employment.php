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







$company = $_POST['company'];



$title = $_POST['title'];



$city = $_POST['city'];



$state = $_POST['state'];

$beginDate = $_POST['beginDate'];

$endDate = $_POST['endDate'];

$achievements = $_POST['achievements']; 


$reasonForLeaving = $_POST['reasonForLeaving'];



$query = "INSERT INTO employment(companyName, jobTitle, beginDate, endDate, achievements)VALUES('$company', '$title', '$beginDate', '$endDate','$achievements')";







mysql_query ($query);



mysql_close($link);



}



?>



<form method="post" action="<?php $_PHP_SELF ?>">

    

<p><strong>Company: </strong><br/>

<input type="text" name ="company" maxlength="75" size="75" /> </br>

</p>



<p><strong>Title:</strong><br/>

<input type="text" name="title" maxlength="30" size="30" /> </br>

</p>

    

<p><strong>City:</strong><br/>

<input type="text" name="city" maxlength="20" size="20" /> </br>

</p>







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

<p><strong>Begin Date: </strong><br/>

<input type="text" name ="beginDate" value="YYYY-MM-DD" maxlength="30" style="width:150px" /> </br>

</p>

<p><strong>End Date: </strong><br/>

<input type="text" name ="endDate" value="YYYY-MM-DD" maxlength="30" style="width:150px" /> </br>

</p>


<p><strong>Achievements: </strong><br/>

<input type="text" name ="achievements" maxlength="100" style="width: 500px; height:100px; " /> </br>

</p>



<p><strong>Reason for Leaving: </strong><br/>

<input type="text" name ="reasonforleaving" maxlength="100" size="100" /> </br>

</p>





<br/>

<p><input type="submit" value = "Submit"/></p>

</form>



</body>

</html>

