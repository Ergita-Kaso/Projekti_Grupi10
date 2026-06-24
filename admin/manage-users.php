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
$uid=intval($_GET['del']);
$sqlUser = "SELECT EmailId from tblusers where id=:uid";
$queryUser = $dbh->prepare($sqlUser);
$queryUser->bindParam(':uid',$uid,PDO::PARAM_STR);
$queryUser->execute();
$userResult = $queryUser->fetch(PDO::FETCH_OBJ);

if($userResult) {
    $uemail = $userResult->EmailId;

    $sqlBookings = "DELETE FROM tblbooking WHERE UserEmail=:uemail";
    $queryBookings = $dbh->prepare($sqlBookings);
    $queryBookings->bindParam(':uemail',$uemail,PDO::PARAM_STR);
    $queryBookings->execute();

    $sqlIssues = "DELETE FROM tblissues WHERE UserEmail=:uemail";
    $queryIssues = $dbh->prepare($sqlIssues);
    $queryIssues->bindParam(':uemail',$uemail,PDO::PARAM_STR);
    $queryIssues->execute();

    $sql = "DELETE FROM tblusers WHERE id=:uid";
    $query = $dbh->prepare($sql);
    $query->bindParam(':uid',$uid,PDO::PARAM_STR);
    $query->execute();
    $msg="Perdoruesi u fshi me sukses.";
} else {
    $error="Perdoruesi nuk u gjet.";
}
}

	?>
<!DOCTYPE HTML>
<html>
<head>
<title>Dream Travel | Admin Menaxho Perdoruesit</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- Bootstrap CSS -->
<link href="css/bootstrap.min.css" rel='stylesheet' type='text/css' />
<!-- Custom CSS -->
<link href="css/style.css" rel='stylesheet' type='text/css' />
<link rel="stylesheet" href="css/morris.css" type="text/css"/>
<!-- Graph CSS -->
<link href="css/font-awesome.css" rel="stylesheet"> 
<!-- jQuery -->
<script src="js/jquery-2.1.4.min.js"></script>
<!-- tabelat -->
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
                <li class="breadcrumb-item"><a href="dashboard.php">Home</a><i class="fa fa-angle-right"></i>Menaxho Perdoruesit</li>
            </ol>
<div class="agile-grids">	
				
				
				<div class="agile-tables">
					<div class="w3l-table-info">
					  <h2>Menaxho Perdoruesit</h2>
					  <?php if($error){?><div class="errorWrap"><strong>Gabim!</strong> <?php echo htmlentities($error); ?> </div><?php } else if($msg){?><div class="succWrap"><strong>Sukses!</strong> <?php echo htmlentities($msg); ?> </div><?php }?>
					    <table id="table">
						<thead>
						  <tr>
						  <th>#</th>
							<th>Emri</th>
							<th>Nr telefonit</th>
							<th>Email </th>
							<th>Data e Regjistrimit </th>
							<th>Data e Perditesimit</th>
							<th>Veprimi</th>
						  </tr>
						</thead>
						<tbody>
<?php $sql = "SELECT * from tblusers";
$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{				?>		
						  <tr>
							<td><?php echo htmlentities($cnt);?></td>
							<td><?php echo htmlentities($result->FullName);?></td>
							<td><?php echo htmlentities($result->MobileNumber);?></td>
							<td><?php echo htmlentities($result->EmailId);?></td>
							<td><?php echo htmlentities($result->RegDate);?></td>
							<td><?php echo htmlentities($result->UpdationDate);?></td>
							<td class="package-actions"><a href="manage-users.php?del=<?php echo htmlentities($result->id);?>" onclick="return confirm('Jeni te sigurt qe doni ta fshini kete perdorues? Rezervimet dhe ceshtjet e tij do te fshihen gjithashtu.');" class="btn btn-danger btn-sm">Fshi</a></td>
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