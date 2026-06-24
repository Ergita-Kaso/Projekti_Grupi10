<?php
session_start();
error_reporting(0);
include('includes/config.php');
include_once('includes/validation-helper.php');

function getTripDate($value) {
    $date = DateTime::createFromFormat('Y-m-d', trim($value));
    if (!$date || $date->format('Y-m-d') !== trim($value)) {
        return false;
    }
    $date->setTime(0, 0, 0);
    return $date;
}

if(isset($_POST['submit2']))
{
$pid=intval($_GET['pkgid']);
$useremail=$_SESSION['login'];
$fromdate=dreamCleanInput($_POST['fromdate']);
$todate=dreamCleanInput($_POST['todate']);
$travelers=intval($_POST['travelers']);
$contactphone=dreamCleanInput($_POST['contactphone']);
$pickup=dreamCleanInput($_POST['pickup']);
$comment=dreamCleanInput($_POST['comment']);
$status=0;
$today = new DateTime('today');
$fromDateObj = getTripDate($fromdate);
$toDateObj = getTripDate($todate);

if(strlen($useremail)==0) {
$error="Ju lutemi logohuni per te bere rezervimin.";
} else if(!$fromDateObj || !$toDateObj) {
$error="Ju lutemi vendosni data te vlefshme per udhetimin.";
} else if($fromDateObj < $today) {
$error="Data e nisjes nuk mund te jete ne te kaluaren.";
} else if($toDateObj < $fromDateObj) {
$error="Data e kthimit nuk mund te jete para dates se nisjes.";
} else if($travelers < 1 || $travelers > 20) {
$error="Numri i udhetareve duhet te jete nga 1 deri ne 20.";
} else if(!dreamValidPhone($contactphone)) {
$error="Ju lutemi vendosni nje numer telefoni te vlefshem.";
} else if(!dreamTextLength($pickup, 3, 120)) {
$error="Ju lutemi vendosni vendin e nisjes ose marrjes.";
} else if($comment !== '' && !dreamTextLength($comment, 0, 500)) {
$error="Komentet nuk mund te jene me shume se 500 karaktere.";
} else {
$bookingdetails = "Udhetare: " . $travelers . "\nTelefon: " . $contactphone . "\nNisja/Marrja: " . $pickup . "\nKomente: " . $comment;
$sql="INSERT INTO tblbooking(PackageId,UserEmail,FromDate,ToDate,Comment,status) VALUES(:pid,:useremail,:fromdate,:todate,:comment,:status)";
$query = $dbh->prepare($sql);
$query->bindParam(':pid',$pid,PDO::PARAM_STR);
$query->bindParam(':useremail',$useremail,PDO::PARAM_STR);
$query->bindParam(':fromdate',$fromdate,PDO::PARAM_STR);
$query->bindParam(':todate',$todate,PDO::PARAM_STR);
$query->bindParam(':comment',$bookingdetails,PDO::PARAM_STR);
$query->bindParam(':status',$status,PDO::PARAM_STR);
$query->execute();
$lastInsertId = $dbh->lastInsertId();
if($lastInsertId)
{
$msg="Rezervimi u be me sukses";
}
else 
{
$error="Ndodhi nje problem, provoni perseri";
}
}

}
?>
<!DOCTYPE HTML>
<html>
<head>
<title>Detajet e Paketave</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
<link rel="stylesheet" href="css/jquery-ui.css" />
	<script>
		 new WOW().init();
	</script>
<script src="js/jquery-ui.js"></script>
<script>
    $(function() {
        new WOW().init();

        var todayValue = '<?php echo date('Y-m-d'); ?>';
        var fromInput = document.getElementById('datepicker');
        var toInput = document.getElementById('datepicker1');

        function openNativeCalendar(input) {
            if (input && typeof input.showPicker === 'function') {
                try {
                    input.showPicker();
                } catch (e) {}
            }
        }

        function syncReturnMin() {
            if (!fromInput || !toInput) {
                return;
            }
            toInput.min = fromInput.value || todayValue;
            if (toInput.value && fromInput.value && toInput.value < fromInput.value) {
                toInput.value = '';
            }
        }

        if (fromInput && toInput) {
            fromInput.min = todayValue;
            toInput.min = todayValue;

            $('#datepicker, #datepicker1').on('click focus', function() {
                openNativeCalendar(this);
            });

            $('#datepicker').on('change input', syncReturnMin);
            syncReturnMin();
        }

        $("form[name='book']").on("submit", function() {
            if (!fromInput || !toInput || !fromInput.value || !toInput.value) {
                alert('Ju lutemi zgjidhni datat e udhetimit.');
                return false;
            }
            if (fromInput.value < todayValue) {
                alert('Data e nisjes nuk mund te jete ne te kaluaren.');
                return false;
            }
            if (toInput.value < fromInput.value) {
                alert('Data e kthimit nuk mund te jete para dates se nisjes.');
                return false;
            }
            return true;
        });
    });
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
		
/* Package details datepicker override */
#ui-datepicker-div {
    z-index: 99999 !important;
    background: #fff !important;
    border: 1px solid #cfcfcf !important;
    border-radius: 4px !important;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.18) !important;
    padding: 0 !important;
    width: 280px !important;
}
#ui-datepicker-div .ui-datepicker-header {
    background: #f4f4f4 !important;
    border-bottom: 1px solid #d7d7d7 !important;
    color: #333 !important;
}
#ui-datepicker-div .ui-datepicker-title span,
#ui-datepicker-div th span,
#ui-datepicker-div th {
    color: #333 !important;
}
#ui-datepicker-div table {
    background: #fff !important;
    margin: 0 !important;
}
#ui-datepicker-div td span,
#ui-datepicker-div td a {
    color: #333 !important;
    background: transparent !important;
    border-radius: 3px !important;
}
#ui-datepicker-div td a:hover,
#ui-datepicker-div .ui-state-hover,
#ui-datepicker-div .ui-state-active {
    background: #ddd !important;
    color: #111 !important;
}
		
/* Trip calendar widget */
.trip-calendar {
    position: absolute;
    z-index: 100000;
    width: 280px;
    background: #fff;
    border: 1px solid #cfcfcf;
    border-radius: 4px;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.18);
    padding: 10px;
    color: #333;
}
.trip-calendar-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: #f4f4f4;
    border-bottom: 1px solid #d7d7d7;
    margin: -10px -10px 10px;
    padding: 10px;
}
.trip-calendar-head button,
.trip-calendar-grid button {
    border: 0;
    background: transparent;
    color: #333;
}
.trip-calendar-head button {
    font-weight: 700;
    font-size: 16px;
    padding: 2px 8px;
}
.trip-calendar-week,
.trip-calendar-grid {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    gap: 3px;
    text-align: center;
}
.trip-calendar-week span {
    font-size: 11px;
    font-weight: 700;
    color: #555;
    padding-bottom: 5px;
}
.trip-calendar-grid button {
    min-height: 30px;
    border-radius: 3px;
}
.trip-calendar-grid button:hover,
.trip-calendar-grid button.selected {
    background: #ddd;
}
.trip-calendar-grid button.disabled {
    color: #bbb;
    cursor: not-allowed;
}
		
/* Make trip date controls reliably clickable */
.ban-bottom,
.bnr-right {
    position: relative;
    z-index: 5;
}
#datepicker,
#datepicker1 {
    position: relative;
    z-index: 6;
    pointer-events: auto !important;
    cursor: pointer;
    background-color: #ffffff !important;
}
#datepicker::-webkit-calendar-picker-indicator,
#datepicker1::-webkit-calendar-picker-indicator {
    cursor: pointer;
    opacity: 1;
}
		</style>
</head>
<body>

<?php include('includes/header.php');?>


<div class="selectroom">
	<div class="container">	
		  <?php if($error){?><div class="errorWrap"><strong>Gabim!</strong> <?php echo htmlentities($error); ?> </div><?php } 
				else if($msg){?><div class="succWrap"><strong><?php echo htmlentities($msg);?></strong> <strong> ! </strong> </div><?php }?>
<?php 
$pid=intval($_GET['pkgid']);
$sql = "SELECT * from tbltourpackages where PackageId=:pid";
$query = $dbh->prepare($sql);
$query -> bindParam(':pid', $pid, PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{	?>


<form name="book" method="post">
		<div class="selectroom_top">
			<div class="col-md-4 selectroom_left wow fadeInLeft animated" data-wow-delay=".5s">
				<img src="admin/pacakgeimages/<?php echo htmlentities($result->PackageImage);?>" class="img-responsive" alt="">
			</div>
			<div class="col-md-8 selectroom_right wow fadeInRight animated" data-wow-delay=".5s">
				<h2><?php echo htmlentities($result->PackageName);?></h2>
				<p class="dow">#PKG-<?php echo htmlentities($result->PackageId);?></p>
				<p><b>Tipi i paketave :</b> <?php echo htmlentities($result->PackageType);?></p>
				<p><b>Vendndodhja e Paketave :</b> <?php echo htmlentities($result->PackageLocation);?></p>
					<p><b>Te Tjera</b> <?php echo htmlentities($result->PackageFetures);?></p>
					<div class="ban-bottom">
				<div class="bnr-right">
				<label class="inputLabel">Nga:</label>
				<input class="date" id="datepicker" type="date" name="fromdate" min="<?php echo date('Y-m-d'); ?>" required="">
			</div>
			<div class="bnr-right">
				<label class="inputLabel">Ne:</label>
				<input class="date" id="datepicker1" type="date" name="todate" min="<?php echo date('Y-m-d'); ?>" required="">
			</div>
			</div>
						<div class="clearfix"></div>
				
			</div>
		<h3>Detaje te Paketave</h3>
				<p style="padding-top: 1%"><?php echo htmlentities($result->PackageDetails);?> </p>	
				<div class="clearfix"></div>
		</div>
		<div class="selectroom_top">
			<h2>Udhetimet</h2>
			<div class="selectroom-info animated wow fadeInUp animated" data-wow-duration="1200ms" data-wow-delay="500ms" style="visibility: visible; animation-duration: 1200ms; animation-delay: 500ms; animation-name: fadeInUp;">
				<ul>
					<li class="nam">
						<label class="inputLabel">Numri i udhetareve</label>
						<input type="number" name="travelers" min="1" max="20" value="1" required="">
					</li>
					<li class="nam">
						<label class="inputLabel">Telefon kontakti</label>
						<input type="tel" name="contactphone" minlength="7" maxlength="20" pattern="[0-9+()\-\s]{7,20}" placeholder="p.sh. +355 69 123 4567" required="">
					</li>
					<li class="spe">
						<label class="inputLabel">Vendi i nisjes / marrjes</label>
						<input class="special" type="text" name="pickup" minlength="3" maxlength="120" placeholder="Qyteti, hoteli ose adresa" required="">
					</li>
					<li class="spe">
						<label class="inputLabel">Komente</label>
						<input class="special" type="text" name="comment" maxlength="500" placeholder="Kerkesa te vecanta per udhetimin">
					</li>
					<?php if($_SESSION['login'])
					{?>
						<li class="spe" align="center">
					<button type="submit" name="submit2" class="btn-primary btn">Prenoto</button>
						</li>
						<?php } else {?>
							<li class="sigi" align="center" style="margin-top: 1%">
							<a href="#" data-toggle="modal" data-target="#myModal4" class="btn-primary btn" > Prenotoni!</a></li>
							<?php } ?>
					<div class="clearfix"></div>
				</ul>
			</div>
			
		</div>
		</form>
<?php }} ?>


	</div>
</div>

<?php include('includes/footer.php');?>

<?php include('includes/signup.php');?>			

<?php include('includes/signin.php');?>			

<?php include('includes/write-us.php');?>
</body>
</html>


