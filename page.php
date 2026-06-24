<?php
session_start();
error_reporting(0);
include('includes/config.php');
include_once('includes/validation-helper.php');
if(isset($_POST['submit1']))
{
$fname=dreamCleanInput($_POST['fname']);
$email=dreamCleanInput($_POST['email']);	
$mobile=dreamCleanInput($_POST['mobileno']);
$subject=dreamCleanInput($_POST['subject']);	
$description=dreamCleanInput($_POST['description']);
if(!dreamValidName($fname)) {
$error="Vendosni nje emer te vlefshem.";
} else if(!dreamValidEmail($email)) {
$error="Vendosni nje email te vlefshem.";
} else if(!dreamValidPhone($mobile)) {
$error="Vendosni nje numer telefoni te vlefshem.";
} else if(!dreamTextLength($subject, 3, 120)) {
$error="Subjekti duhet te kete 3 deri ne 120 karaktere.";
} else if(!dreamTextLength($description, 10, 1000)) {
$error="Mesazhi duhet te kete 10 deri ne 1000 karaktere.";
} else {
$sql="INSERT INTO  tblenquiry(FullName,EmailId,MobileNumber,Subject,Description) VALUES(:fname,:email,:mobile,:subject,:description)";
$query = $dbh->prepare($sql);
$query->bindParam(':fname',$fname,PDO::PARAM_STR);
$query->bindParam(':email',$email,PDO::PARAM_STR);
$query->bindParam(':mobile',$mobile,PDO::PARAM_STR);
$query->bindParam(':subject',$subject,PDO::PARAM_STR);
$query->bindParam(':description',$description,PDO::PARAM_STR);
$query->execute();
$lastInsertId = $dbh->lastInsertId();
if($lastInsertId)
{
$msg="Mesazhi u dergua me sukses!";
}
else 
{
$error="Ndodhi nje problem.Provoni perseri!";
}
}

}

?>
<!DOCTYPE HTML>
<html>
<head>
<title>Dream Travel</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Dream Travel" />
<script type="applijewelleryion/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<link href="css/bootstrap.css" rel='stylesheet' type='text/css' />
<link href="css/style.css" rel='stylesheet' type='text/css' />
<link href="css/homepage-enhancements.css" rel='stylesheet' type='text/css' />
<link href='//fonts.googleapis.com/css?family=Open+Sans:400,700,600' rel='stylesheet' type='text/css'>
<link href='//fonts.googleapis.com/css?family=Roboto+Condensed:400,700,300' rel='stylesheet' type='text/css'>
<link href='//fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
<link href="css/font-awesome.css" rel="stylesheet">

<script src="js/jquery-1.12.0.min.js"></script>
<script src="js/bootstrap.min.js"></script>

<link href="css/animate.css" rel="stylesheet" type="text/css" media="all">
<script src="js/wow.min.js"></script>
	<script>
		 new WOW().init();
	</script>
  <style>
		.errorWrap {
    padding: 10px;
    margin: 0 0 20px 0;
    background: #fff;
    border-left: 4px solid #dd3d36;
    -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
}
.succWrap{
    padding: 10px;
    margin: 0 0 20px 0;
    background: #fff;
    border-left: 4px solid #5cb85c;
    -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
}
		</style>
</head>
<body>

<?php include('includes/header.php');?>


<div class="privacy">
	<div class="container">
<?php 
$pagetype=dreamCleanInput($_GET['type']);
if(!dreamAllowedValue($pagetype, array('terms','privacy','aboutus','contact'))) {
$pagetype='';
}
$sql = "SELECT type,detail from tblpages where type=:pagetype";
$query = $dbh -> prepare($sql);
$query->bindParam(':pagetype',$pagetype,PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{		

?>
		<h3 class="wow fadeInDown animated animated" data-wow-delay=".5s" style="visibility: visible; animation-delay: 0.5s; animation-name: fadeInDown;"></h3>
		
	<p>
	<?php echo str_replace(array('SOUL', 'Soul', 'soul'), array('DREAM', 'Dream', 'dream'), $result->detail); ?>

	</p> 
	
<?php } }?>
			
	</div>
</div>

<?php include('includes/footer.php');?>

<?php include('includes/signup.php');?>			

<?php include('includes/signin.php');?>			

<?php include('includes/write-us.php');?>
</body>
</html>
