<?php
session_start();
error_reporting(0);
include('includes/config.php');
?>
<!DOCTYPE HTML>
<html>
<head>
	<title>Dream Travel</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<script type="applijewelleryion/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<link href="css/bootstrap.css" rel='stylesheet' type='text/css' />
<link href="css/style.css" rel='stylesheet' type='text/css' />
<link href='//fonts.googleapis.com/css?family=Open+Sans:400,700,600' rel='stylesheet' type='text/css'>
<link href="css/homepage-enhancements.css" rel='stylesheet' type='text/css' />
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

</head>
<body>
<?php include('includes/header.php');?>
<div class="banner">
	<div class="container">

		        <div class="hero-copy wow zoomIn animated animated" data-wow-delay=".5s" style="visibility: visible; animation-delay: 0.5s; animation-name: zoomIn;">
            <h1>DREAM TRAVEL</h1>
            <p>Zbuloni destinacione te paharrueshme me paketa te zgjedhura per cdo udhetim.</p>
            <a href="package-list.php" class="hero-cta">Shiko paketat</a>
        </div>
	</div>
</div>

</div>

<div class="container">
	<div class="holiday">
	
	<h3>Lista e Paketave</h3>

					
<?php $sql = "SELECT * from tbltourpackages order by rand() limit 6";
$query = $dbh->prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{	?>
			<div class="rom-btm">
				<div class="col-md-3 room-left wow fadeInLeft animated" data-wow-delay=".5s">
					<img src="admin/pacakgeimages/<?php echo htmlentities($result->PackageImage);?>" class="img-responsive" alt="">
				</div>
				<div class="col-md-6 room-midle wow fadeInUp animated" data-wow-delay=".5s">
					<h4>Emri i Paketes: <?php echo htmlentities($result->PackageName);?></h4>
					<h6>Tipi i Paketes : <?php echo htmlentities($result->PackageType);?></h6>
					<p><b>Vendodhja e Paketes:</b> <?php echo htmlentities($result->PackageLocation);?></p>
					<p><b>Te dhena te tjera : </b> <?php echo htmlentities($result->PackageFetures);?></p>
				</div>
				<div class="col-md-3 room-right wow fadeInRight animated" data-wow-delay=".5s">
					<h5>&euro; <?php echo htmlentities($result->PackagePrice);?></h5>
					<a href="package-details.php?pkgid=<?php echo htmlentities($result->PackageId);?>" class="view">Detaje</a>
				</div>
				<div class="clearfix"></div>
			</div>

<?php }} ?>
			
		
		<div class="packages-grid">
<?php $sql = "SELECT * from tbltourpackages order by rand() limit 6";
$query = $dbh->prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{	?>
			<div class="package-card wow fadeInUp animated" data-wow-delay=".<?php echo ($cnt * 2); ?>s">
				<div class="package-image">
					<img src="admin/pacakgeimages/<?php echo htmlentities($result->PackageImage);?>" alt="<?php echo htmlentities($result->PackageName);?>">
					<div class="package-badge"><?php echo htmlentities($result->PackageType);?></div>
				</div>
				<div class="package-content">
					<h4><?php echo htmlentities($result->PackageName);?></h4>
					<div class="package-type">Tour Package</div>
					<div class="package-location"><?php echo htmlentities($result->PackageLocation);?></div>
					<p class="package-features"><?php echo htmlentities($result->PackageFetures);?></p>
					<div class="package-footer">
						<div class="package-price"><?php echo htmlentities($result->PackagePrice);?></div>
						<a href="package-details.php?pkgid=<?php echo htmlentities($result->PackageId);?>" class="view">Detaje</a>
					</div>
				</div>
			</div>

<?php $cnt++; }} ?>
		</div>
		<div class="package-more">
			<a href="package-list.php" class="view">Shiko Paketa te Tjera</a>
		</div>
</div>
			<div class="clearfix"></div>
	</div>


<div class="routes">
	<div class="container">
		
		<div class="col-md-4 routes-left">
			
		</div>
		<div class="clearfix"></div>
	</div>
</div>

<?php include('includes/footer.php');?>

<?php include('includes/signup.php');?>			

<?php include('includes/signin.php');?>			

<?php include('includes/write-us.php');?>			

</body>
</html>


