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
$error="Ndodhi nje problem, provoni perseri!";
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
		<h3 class="wow fadeInDown animated animated" data-wow-delay=".5s" style="visibility: visible; animation-delay: 0.5s; animation-name: fadeInDown;">Dergoni nje mesazh</h3>
		<form name="enquiry" method="post">
		 <?php if($error){?><div class="errorWrap"><strong>Gabim!</strong> <?php echo htmlentities($error); ?> </div><?php } 
				else if($msg){?><div class="succWrap"><strong>Me sukses!</strong> <?php echo htmlentities($msg); ?> </div><?php }?>
	<p style="width: 350px;">
		
			<b>Vendosni Emrin</b>  <input type="text" name="fname" class="form-control" id="fname" placeholder="Emri i plote" minlength="2" maxlength="80" required="">
	</p> 
<p style="width: 350px;">
<b>E-mail</b>  <input type="email" name="email" class="form-control" id="email" placeholder="Email i vlefshem" maxlength="120" required="">
	</p> 

	<p style="width: 350px;">
<b>Numri i Telefonit</b>  <input type="tel" name="mobileno" class="form-control" id="mobileno" minlength="7" maxlength="20" pattern="[0-9+()\-\s]{7,20}" placeholder="Numri i telefonit" required="">
	</p> 

	<p style="width: 350px;">
<b>Titulli</b>  <input type="text" name="subject" class="form-control" id="subject"  placeholder="Subjekti" minlength="3" maxlength="120" required="">
	</p> 
	<p style="width: 350px;">
<b>Mesazhi</b>  <textarea name="description" class="form-control" rows="6" cols="50" id="description"  placeholder="Pershkrimi" minlength="10" maxlength="1000" required=""></textarea> 
	</p> 

			<p style="width: 350px;">
<button type="submit" name="submit1" class="btn-primary btn">Dergo</button>
			</p>
			</form>

		
	</div>
</div>

<?php include('includes/footer.php');?>

<?php include('includes/signup.php');?>			

<?php include('includes/signin.php');?>			

<?php include('includes/write-us.php');?>
</body>
</html>
