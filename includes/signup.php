<?php
error_reporting(0);
include_once(__DIR__ . '/password-helper.php');
include_once(__DIR__ . '/validation-helper.php');
if(isset($_POST['submit']))
{
$fname=dreamCleanInput($_POST['fname']);
$mnumber=dreamCleanInput($_POST['mobilenumber']);
$email=dreamCleanInput($_POST['email']);
$rawPassword=(string) $_POST['password'];
if(!dreamValidName($fname)) {
$_SESSION['msg']="Vendosni nje emer te vlefshem.";
header('location:thankyou.php');
exit;
} else if(!dreamValidPhone($mnumber)) {
$_SESSION['msg']="Vendosni nje numer telefoni te vlefshem.";
header('location:thankyou.php');
exit;
} else if(!dreamValidEmail($email)) {
$_SESSION['msg']="Vendosni nje email te vlefshem.";
header('location:thankyou.php');
exit;
} else if(!dreamValidPassword($rawPassword)) {
$_SESSION['msg']="Fjalekalimi duhet te kete 6 deri ne 72 karaktere.";
header('location:thankyou.php');
exit;
}
$password=dreamPasswordHash($rawPassword);
$sql="INSERT INTO  tblusers(FullName,MobileNumber,EmailId,Password) VALUES(:fname,:mnumber,:email,:password)";
$query = $dbh->prepare($sql);
$query->bindParam(':fname',$fname,PDO::PARAM_STR);
$query->bindParam(':mnumber',$mnumber,PDO::PARAM_STR);
$query->bindParam(':email',$email,PDO::PARAM_STR);
$query->bindParam(':password',$password,PDO::PARAM_STR);
$query->execute();
$lastInsertId = $dbh->lastInsertId();
if($lastInsertId)
{
$_SESSION['msg']="Ju u regjistruat me sukses. Ju lutem logohuni! ";
header('location:thankyou.php');
}
else 
{
$_SESSION['msg']="Ndodhi nje gabim. Ju lutem provoni perseri!";
header('location:thankyou.php');
}
}
?>

<!--Javascript per kontrollin e vlefshmerise se email-it -->

<script>
function checkAvailability() {

$("#loaderIcon").show();
jQuery.ajax({
url: "check_availability.php",
data:'emailid='+$("#email").val(),
type: "POST",
success:function(data){
$("#user-availability-status").html(data);
$("#loaderIcon").hide();
},
error:function (){}
});
}
</script>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>						
						</div>
							<section>
								<div class="modal-body modal-spa">
									<div class="login-grids">
										<div class="login">
											<div class="login-left">
												
											</div>
											<div class="login-right">
												<form name="signup" method="post">
													<h3>Krijo llogarine tende </h3>
					

				<input type="text" value="" placeholder="Emri i plote" name="fname" autocomplete="off" minlength="2" maxlength="80" required="">
				<input type="text" value="" placeholder="Numri telefonit" minlength="7" maxlength="20" pattern="[0-9+()\-\s]{7,20}" inputmode="tel" name="mobilenumber" autocomplete="off" required="">
		<input type="text" value="" placeholder="Email i vlefshem" name="email" id="email" onBlur="checkAvailability()" autocomplete="off" maxlength="120" inputmode="email" pattern="[A-Za-z0-9._%+\-]+@[A-Za-z0-9.\-]+\.[A-Za-z]{2,}" required="">	
		 <span id="user-availability-status" style="font-size:12px;"></span> 
	<input type="password" value="" placeholder="Fjalekalimi" name="password" minlength="6" maxlength="72" required="">	
													<input type="submit" name="submit" id="submit" value="Krijo llogarine">
												</form>
											</div>
												<div class="clearfix"></div>								
										</div>
											
									</div>
								</div>
							</section>
					</div>
				</div>
			</div>
