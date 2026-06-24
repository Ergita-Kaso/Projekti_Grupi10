<?php
error_reporting(0);
if(isset($_POST['submit']))
{
$issue=$_POST['issue'];
$description=$_POST['description'];
$email=$_SESSION['login'];
$sql="INSERT INTO  tblissues(UserEmail,Issue,Description) VALUES(:email,:issue,:description)";
$query = $dbh->prepare($sql);
$query->bindParam(':issue',$issue,PDO::PARAM_STR);
$query->bindParam(':description',$description,PDO::PARAM_STR);
$query->bindParam(':email',$email,PDO::PARAM_STR);
$query->execute();
$lastInsertId = $dbh->lastInsertId();
if($lastInsertId)
{
$_SESSION['msg']="Mesazhi u dergua me sukses! ";
echo "<script type='text/javascript'> document.location = 'issuetickets.php'; </script>";
}
else 
{
$_SESSION['msg']="Ndodhi nje gabim. Provoni perseri! ";
echo "<script type='text/javascript'> document.location = 'issuetickets.php'; </script>";
}
}
?>	


	<div class="modal fade" id="myModal3"  role="dialog" aria-labelledby="myModalLabel">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>						
						</div>
							<section>
							<form name="help" method="post">
								<div class="modal-body modal-spa">
									<div class="writ">
										<h4>Si mund t'iu ndihmojme </h4>
											<ul>
												
												<li class="na-me">
													<select id="country" name="issue" class="frm-field required sect" required="">
														<option value="">Zgjidh Ceshtjen</option> 		
														<option value="Probleme me Rezervimin">Probleme me Rezervimin</option>
														<option value="Anullime"> Anullime</option>
														<option value="Ulje">Ulje</option>
														<option value="Te Tjera">Te Tjera</option>														
													</select>
												</li>
											
												<li class="descrip">
									<input class="special" type="text" placeholder="Pershkrimi"  name="description" required="">
												</li>
													<div class="clearfix"></div>
											</ul>
											<div class="sub-bn"><button type="submit" name="submit" class="subbtn">Dergo</button></div>
									</div>
								</div>
								</form>
							</section>
					</div>
				</div>
			</div>