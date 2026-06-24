<?php
session_start();
error_reporting(0);
include('includes/config.php');
include_once(__DIR__ . '/../includes/validation-helper.php');
if(strlen($_SESSION['alogin'])==0)
	{	
header('location:index.php');
}
else{
if(isset($_POST['submit']))
{
$pname=dreamCleanInput($_POST['packagename']);
$ptype=dreamCleanInput($_POST['packagetype']);	
$plocation=dreamCleanInput($_POST['packagelocation']);
$pprice=dreamCleanInput($_POST['packageprice']);	
$pfeatures=dreamCleanInput($_POST['packagefeatures']);
$pdetails=dreamCleanInput($_POST['packagedetails']);	
$pimage='';
if(!dreamTextLength($pname, 3, 120)) {
$error="Emri i paketes duhet te kete 3 deri ne 120 karaktere.";
} else if(!dreamTextLength($ptype, 3, 80)) {
$error="Tipi i paketes duhet te kete 3 deri ne 80 karaktere.";
} else if(!dreamTextLength($plocation, 2, 120)) {
$error="Destinacioni duhet te kete 2 deri ne 120 karaktere.";
} else if(!dreamValidPositivePrice($pprice)) {
$error="Cmimi duhet te jete numer pozitiv i vlefshem.";
} else if(!dreamTextLength($pfeatures, 3, 255)) {
$error="Tiparet duhet te kene 3 deri ne 255 karaktere.";
} else if(!dreamTextLength($pdetails, 10, 3000)) {
$error="Detajet duhet te kene 10 deri ne 3000 karaktere.";
} else if(!dreamValidateUploadedImage($_FILES["packageimage"], $pimage, $error)) {
} else if(!move_uploaded_file($_FILES["packageimage"]["tmp_name"],"pacakgeimages/".$pimage)) {
$error="Foto nuk u ngarkua. Provoni perseri.";
} else {
$sql="INSERT INTO TblTourPackages(PackageName,PackageType,PackageLocation,PackagePrice,PackageFetures,PackageDetails,PackageImage) VALUES(:pname,:ptype,:plocation,:pprice,:pfeatures,:pdetails,:pimage)";
$query = $dbh->prepare($sql);
$query->bindParam(':pname',$pname,PDO::PARAM_STR);
$query->bindParam(':ptype',$ptype,PDO::PARAM_STR);
$query->bindParam(':plocation',$plocation,PDO::PARAM_STR);
$query->bindParam(':pprice',$pprice,PDO::PARAM_STR);
$query->bindParam(':pfeatures',$pfeatures,PDO::PARAM_STR);
$query->bindParam(':pdetails',$pdetails,PDO::PARAM_STR);
$query->bindParam(':pimage',$pimage,PDO::PARAM_STR);
$query->execute();
$lastInsertId = $dbh->lastInsertId();
if($lastInsertId)
{
$msg="Paketa u krijua me sukses!";
}
else 
{
$error="Ndodhi nje gabim. Provoni perseri!";
}
}

}

	?>
<!DOCTYPE HTML>
<html>
<head>
<title>Dream Travel | Admin Krijimi Paketave</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Dream Travel" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<link href="css/bootstrap.min.css" rel='stylesheet' type='text/css' />
<link href="css/style.css" rel='stylesheet' type='text/css' />
<link rel="stylesheet" href="css/morris.css" type="text/css"/>
<link href="css/font-awesome.css" rel="stylesheet"> 
<script src="js/jquery-2.1.4.min.js"></script>
<link href='//fonts.googleapis.com/css?family=Roboto:700,500,300,100italic,100,400' rel='stylesheet' type='text/css'/>
<link href='//fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="css/icon-font.min.css" type='text/css' />
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
   <div class="page-container">
   <!--/content-inner-->
<div class="left-content">
	   <div class="mother-grid-inner">
         
<?php include('includes/header.php');?>
							
				     <div class="clearfix"> </div>	
				</div>
	<ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="dashboard.php">Home</a><i class="fa fa-angle-right"></i>Perditeso Paketen </li>
            </ol>
 	<div class="grid-form">
  <div class="grid-form1">
  	       <h3>Krijo Paketen</h3>
  	        	  <?php if($error){?><div class="errorWrap"><strong>Gabim! </strong>  <?php echo htmlentities($error); ?> </div><?php } 
				else if($msg){?><div class="succWrap"><strong>Sukses! </strong>  <?php echo htmlentities($msg); ?> </div><?php }?>
  	         <div class="tab-content">
						<div class="tab-pane active" id="horizontal-form">
							<form class="form-horizontal" name="package" method="post" enctype="multipart/form-data">
								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Emri Paketes</label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" name="packagename" id="packagename" placeholder="Emri paketes " minlength="3" maxlength="120" required>
									</div>
								</div>
<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Tipi Paketes</label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" name="packagetype" id="packagetype" placeholder=" Tipi paketes" minlength="3" maxlength="80" required>
									</div>
								</div>

<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label"> Destinacioni i Paketes </label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" name="packagelocation" id="packagelocation" placeholder="  Destinacioni i Paketes" minlength="2" maxlength="120" required>
									</div>
								</div>

<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Cmimi i Paketes</label>
									<div class="col-sm-8">
										<input type="number" class="form-control1" name="packageprice" id="packageprice" placeholder=" Cmimi i Paketes" min="0.01" max="999999.99" step="0.01" required>
									</div>
								</div>

<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Tiparet e Paketes</label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" name="packagefeatures" id="packagefeatures" placeholder="Tiparet e Paketes" minlength="3" maxlength="255" required>
									</div>
								</div>		


<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Detajet e Paketes</label>
									<div class="col-sm-8">
										<textarea class="form-control" rows="5" cols="50" name="packagedetails" id="packagedetails" placeholder="Detajet e Paketes" minlength="10" maxlength="3000" required></textarea> 
									</div>
								</div>															
<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Foto e Paketes</label>
									<div class="col-sm-8">
										<input type="file" name="packageimage" id="packageimage" accept="image/jpeg,image/png,image/webp,image/gif" required>
									</div>
								</div>	

								<div class="row">
			<div class="col-sm-8 col-sm-offset-2">
				<button type="submit" name="submit" class="btn-primary btn">Krijo</button>

				<button type="reset" class="btn-inverse btn">Reset</button> <a href="manage-packages.php" class="btn btn-default">Kthehu te paketat</a>
			</div>
		</div>
						
					
						
						
						
					</div>
					
					</form>

     
      

      
      <div class="panel-footer">
		
	 </div>
    </form>
  </div>
 	</div>
		<script>
		$(document).ready(function() {
			 var navoffeset=$(".header-main").offset().top;
			 $(window).scroll(function(){
				var scrollpos=$(window).scrollTop(); 
				if(scrollpos >=navoffeset){
					$(".header-main").addClass("fixed");
				}else{
					$(".header-main").removeClass("fixed");
				}
			 });
			 
		});
		</script>
<div class="inner-block">

</div>

<?php include('includes/footer.php');?>

</div>
</div>
					<?php include('includes/sidebarmenu.php');?>
							  <div class="clearfix"></div>		
							</div>
							<script>
							var toggle = true;
										
							$(".sidebar-icon").click(function() {                
							  if (toggle)
							  {
								$(".page-container").addClass("sidebar-collapsed").removeClass("sidebar-collapsed-back");
								$("#menu span").css({"position":"absolute"});
							  }
							  else
							  {
								$(".page-container").removeClass("sidebar-collapsed").addClass("sidebar-collapsed-back");
								setTimeout(function() {
								  $("#menu span").css({"position":"relative"});
								}, 400);
							  }
											
											toggle = !toggle;
										});
							</script>

<script src="js/jquery.nicescroll.js"></script>
<script src="js/scripts.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>
<?php } ?>
