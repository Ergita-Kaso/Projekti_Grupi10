<?php 
require_once("includes/config.php");
include_once("includes/validation-helper.php");

// Vlefshmeria e email-it per regjistrimin e userit
if(!empty($_POST["emailid"])) {
	$email= dreamCleanInput($_POST["emailid"]);
	if (!dreamValidEmail($email)) {

		echo "Gabim! Vendosni nje email te vlefshem!";
	}
	else {
		$sql ="SELECT EmailId FROM tblusers WHERE EmailId=:email";
$query= $dbh -> prepare($sql);
$query-> bindParam(':email', $email, PDO::PARAM_STR);
$query-> execute();
$results = $query -> fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query -> rowCount() > 0)
{
echo "<span style='color:red'> Emaili ekziston! .</span>";
 echo "<script>$('#submit').prop('disabled',true);</script>";
} else{
	
	echo "<span style='color:green'> Email i disponueshem per regjistrim! </span>";
 echo "<script>$('#submit').prop('disabled',false);</script>";
}
}
}

?>
