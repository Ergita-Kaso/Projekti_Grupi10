<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
	{	
header('location:index.php');
}
else{ 
if(isset($_GET['del']))
{
$pid=intval($_GET['del']);
$sqlImg = "SELECT PackageImage from TblTourPackages where PackageId=:pid";
$queryImg = $dbh->prepare($sqlImg);
$queryImg->bindParam(':pid',$pid,PDO::PARAM_STR);
$queryImg->execute();
$imageResult = $queryImg->fetch(PDO::FETCH_OBJ);

$sqlBookings = "DELETE FROM tblbooking WHERE PackageId=:pid";
$queryBookings = $dbh->prepare($sqlBookings);
$queryBookings->bindParam(':pid',$pid,PDO::PARAM_STR);
$queryBookings->execute();

$sql = "DELETE FROM TblTourPackages WHERE PackageId=:pid";
$query = $dbh->prepare($sql);
$query->bindParam(':pid',$pid,PDO::PARAM_STR);
$query->execute();

if($imageResult && !empty($imageResult->PackageImage)) {
    $imagePath = __DIR__ . DIRECTORY_SEPARATOR . 'pacakgeimages' . DIRECTORY_SEPARATOR . $imageResult->PackageImage;
    if(is_file($imagePath)) {
        unlink($imagePath);
    }
}
$msg="Paketa u fshi me sukses.";
}

	?>
<!DOCTYPE HTML>
<html>
<head>
<title>Dream Travel | Menaxhimi i paketave - Admin</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- Bootstrap Core CSS -->
<link href="css/bootstrap.min.css" rel='stylesheet' type='text/css' />
<!-- Custom CSS -->
<link href="css/style.css" rel='stylesheet' type='text/css' />
<link rel="stylesheet" href="css/morris.css" type="text/css"/>
<!-- Graph CSS -->
<link href="css/font-awesome.css" rel="stylesheet"> 
<!-- jQuery -->
<script src="js/jquery-2.1.4.min.js"></script>
<!-- //jQuery -->
<!-- tables -->
<link rel="stylesheet" type="text/css" href="css/table-style.css" />
<link rel="stylesheet" type="text/css" href="css/basictable.css" />
<script type="text/javascript" src="js/jquery.basictable.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
      $('#table').basictable();

      $('#table-breakpoint').basictable({
        breakpoint: 768
      });

      $('#table-swap-axis').basictable({
        swapAxis: true
      });

      $('#table-force-off').basictable({
        forceResponsive: false
      });

      $('#table-no-resize').basictable({
        noResize: true
      });

      $('#table-two-axis').basictable();

      $('#table-max-height').basictable({
        tableWrapper: true
      });
    });
</script>

<link href='//fonts.googleapis.com/css?family=Roboto:700,500,300,100italic,100,400' rel='stylesheet' type='text/css'/>
<link href='//fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>

<link rel="stylesheet" href="css/icon-font.min.css" type='text/css' />

</head> 
<body>
   <div class="page-container">

<div class="left-content">
	   <div class="mother-grid-inner">
         
				<?php include('includes/header.php');?>
				     <div class="clearfix"> </div>	
				</div>

<ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="dashboard.php">Home</a><i class="fa fa-angle-right"></i>Menaxho paketat</li>
            </ol>
<div class="agile-grids">	
				<!-- tabelat -->
				
				<div class="agile-tables">
					<div class="w3l-table-info">
					  <h2>Menaxhimi i paketave</h2>
					  <?php if($error){?><div class="errorWrap"><strong>Gabim!</strong> <?php echo htmlentities($error); ?> </div><?php } else if($msg){?><div class="succWrap"><strong>Sukses!</strong> <?php echo htmlentities($msg); ?> </div><?php }?>
					    <table id="table">
						<thead>
						  <tr>
						  <th>#</th>
							<th >Emri</th>
							<th>Tipi</th>
							<th>Vendndodhja</th>
							<th>Cmimi</th>
							<th>Data e krijimit</th>
							<th>Veprimi</th>
						  </tr>
						</thead>
						<tbody>
<?php $sql = "SELECT * from TblTourPackages";
$query = $dbh -> prepare($sql);
//$query -> bindParam(':city', $city, PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{				?>		
						  <tr>
							<td><?php echo htmlentities($cnt);?></td>
							<td><?php echo htmlentities($result->PackageName);?></td>
							<td><?php echo htmlentities($result->PackageType);?></td>
							<td><?php echo htmlentities($result->PackageLocation);?></td>
							<td>Euro:<?php echo htmlentities($result->PackagePrice);?></td>
							<td><?php echo htmlentities($result->Creationdate);?></td>
							<td class="package-actions"><a href="update-package.php?pid=<?php echo htmlentities($result->PackageId);?>" class="btn btn-primary btn-sm">Shih detaje</a> <a href="manage-packages.php?del=<?php echo htmlentities($result->PackageId);?>" onclick="return confirm('Jeni te sigurt qe doni ta fshini kete pakete?');" class="btn btn-danger btn-sm">Fshi</a></td>
						  </tr>
						 <?php $cnt=$cnt+1;} }?>
						</tbody>
					  </table>
					</div>
				  </table>

				
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