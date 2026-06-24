<?php
session_start();
include_once(__DIR__ . '/password-helper.php');
include_once(__DIR__ . '/validation-helper.php');
if(isset($_POST['signin']))
{
$email=dreamCleanInput($_POST['email']);
$password=($_POST['password']);
if(!dreamValidEmail($email) || $password === '') {
echo "<script>alert('Te dhena te gabuara!');</script>";
} else {
$sql ="SELECT EmailId,Password FROM tblusers WHERE EmailId=:email";
$query= $dbh -> prepare($sql);
$query-> bindParam(':email', $email, PDO::PARAM_STR);
$query-> execute();
$result=$query->fetch(PDO::FETCH_OBJ);
if($result && dreamPasswordMatches($password, $result->Password))
{
if(dreamPasswordNeedsUpgrade($result->Password)) {
$hashedPassword=dreamPasswordHash($password);
$updateSql="UPDATE tblusers SET Password=:password WHERE EmailId=:email";
$updateQuery=$dbh->prepare($updateSql);
$updateQuery->bindParam(':password',$hashedPassword,PDO::PARAM_STR);
$updateQuery->bindParam(':email',$email,PDO::PARAM_STR);
$updateQuery->execute();
}
$_SESSION['login']=$_POST['email'];
echo "<script type='text/javascript'> document.location = 'index.php'; </script>";
} else{
	
	echo "<script>alert('Te dhena te gabuara!');</script>";

}
}
}

?>

<div class="modal fade" id="myModal4"  role="dialog" aria-labelledby="myModalLabel">
				<div class="modal-dialog" role="document">
					<div class="modal-content modal-info">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">x</span></button>						
						</div>
						<div class="modal-body modal-spa">
							<div class="login-grids">
								<div class="login">
										<div class="login-left">
												
											</div>
									<div class="login-right">
										<form method="post">
											<h3>Logohu </h3>
	<input type="text" name="email" id="email" placeholder=" Email" maxlength="120" inputmode="email" pattern="[A-Za-z0-9._%+\-]+@[A-Za-z0-9.\-]+\.[A-Za-z]{2,}" required="">	
	<input type="password" name="password" id="password" placeholder="Fjalekalimi" value="" minlength="6" maxlength="72" required="">	
											<h4><a href="forgot-password.php">Keni harruar Fjalekalimin ?</a></h4>
											
											<input type="submit" name="signin" value="Logohu">
										</form>
									</div>
									<div class="clearfix"></div>								
								</div>
								
							</div>
						</div>
					</div>
				</div>
			</div>
