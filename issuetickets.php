<?php
session_start();
error_reporting(0);
include('includes/config.php');
include_once('includes/validation-helper.php');
if(strlen($_SESSION['login'])==0)
    {
header('location:index.php');
}
else{
if(isset($_SESSION['msg'])) {
$msg=$_SESSION['msg'];
unset($_SESSION['msg']);
}
if(isset($_SESSION['error'])) {
$error=$_SESSION['error'];
unset($_SESSION['error']);
}
if(isset($_POST['submitissue']))
{
$issue=trim($_POST['issue']);
$description=trim($_POST['description']);
$email=$_SESSION['login'];
if(!dreamAllowedValue($issue, array('Probleme me Rezervimin','Anullime','Ulje','Te Tjera'))) {
$_SESSION['error']="Zgjidhni nje kategori te vlefshme.";
header('location:issuetickets.php');
exit;
} else if(!dreamTextLength($description, 10, 1000)) {
$_SESSION['error']="Mesazhi duhet te kete 10 deri ne 1000 karaktere.";
header('location:issuetickets.php');
exit;
} else {
$sql="INSERT INTO tblissues(UserEmail,Issue,Description) VALUES(:email,:issue,:description)";
$query = $dbh->prepare($sql);
$query->bindParam(':issue',$issue,PDO::PARAM_STR);
$query->bindParam(':description',$description,PDO::PARAM_STR);
$query->bindParam(':email',$email,PDO::PARAM_STR);
$query->execute();
if($dbh->lastInsertId()) {
$_SESSION['msg']="Mesazhi u dergua me sukses.";
} else {
$_SESSION['error']="Ndodhi nje gabim. Provoni perseri.";
}
header('location:issuetickets.php');
exit;
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
<script>new WOW().init();</script>
<style>
.errorWrap,.succWrap{padding:10px;margin:0 0 20px 0;background:#fff;box-shadow:0 1px 1px rgba(0,0,0,.1)}
.errorWrap{border-left:4px solid #dd3d36}.succWrap{border-left:4px solid #5cb85c}
.issue-form{max-width:720px;margin-bottom:30px}.issue-form .form-control{margin-bottom:15px}.issue-status{display:inline-block;padding:5px 10px;border-radius:20px;font-weight:700;font-size:12px}.issue-open{background:#fff4df;color:#8a6f3d}.issue-answered{background:#e7f4ec;color:#37604d}
</style>
</head>
<body>
<?php include('includes/header.php');?>
<div class="privacy">
    <div class="container">
        <h3 class="wow fadeInDown animated animated" data-wow-delay=".5s">Na shkruani</h3>
        <?php if($error){?><div class="errorWrap"><strong>Gabim!</strong> <?php echo htmlentities($error); ?> </div><?php } else if($msg){?><div class="succWrap"><strong>Me sukses!</strong> <?php echo htmlentities($msg); ?> </div><?php }?>
        <form name="issueform" method="post" class="issue-form">
            <label>Kategoria e mesazhit</label>
            <select name="issue" class="form-control" required>
                <option value="">Zgjidh kategorine</option>
                <option value="Probleme me Rezervimin">Probleme me Rezervimin</option>
                <option value="Anullime">Anullime</option>
                <option value="Ulje">Ulje</option>
                <option value="Te Tjera">Te Tjera</option>
            </select>
            <label>Mesazhi</label>
            <textarea name="description" class="form-control" rows="5" placeholder="Shkruani mesazhin tuaj" minlength="10" maxlength="1000" required></textarea>
            <button type="submit" name="submitissue" class="btn-primary btn">Dergo mesazhin</button>
        </form>
        <h3>Historiku i mesazheve</h3>
        <table border="1" width="100%">
            <tr align="center">
                <th>#</th>
                <th><center>ID</center></th>
                <th><center>Kategoria</center></th>
                <th><center>Pershkrimi</center></th>
                <th><center>Statusi</center></th>
                <th><center>Pergjigjia e Adminit</center></th>
                <th><center>Data e Pergjigjes</center></th>
                <th><center>Data e regjistrimit</center></th>
            </tr>
<?php
$uemail=$_SESSION['login'];
$sql = "SELECT ti.* from tblissues ti inner join (select coalesce(nullif(max(case when AdminRemark is not null and AdminRemark<>'' then id else 0 end),0), max(id)) as id from tblissues where UserEmail=:uemail group by UserEmail, Issue, Description) latest on latest.id=ti.id order by ti.PostingDate desc";
$query = $dbh->prepare($sql);
$query->bindParam(':uemail', $uemail, PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{ ?>
            <tr align="center">
                <td><?php echo htmlentities($cnt);?></td>
                <td width="100">#TKT-<?php echo htmlentities($result->id);?></td>
                <td><?php echo htmlentities($result->Issue);?></td>
                <td width="300"><?php echo htmlentities($result->Description);?></td>
                <td><?php if($result->AdminRemark){?><span class="issue-status issue-answered">Pergjigjur</span><?php } else {?><span class="issue-status issue-open">Ne pritje</span><?php } ?></td>
                <td><?php echo $result->AdminRemark ? htmlentities($result->AdminRemark) : 'Ende pa pergjigje';?></td>
                <td width="100"><?php echo $result->AdminremarkDate ? htmlentities($result->AdminremarkDate) : '-';?></td>
                <td width="100"><?php echo htmlentities($result->PostingDate);?></td>
            </tr>
<?php $cnt=$cnt+1; }} else { ?>
            <tr><td colspan="8" align="center">Nuk keni derguar ende asnje mesazh.</td></tr>
<?php } ?>
        </table>
    </div>
</div>
<?php include('includes/footer.php');?>
<?php include('includes/signup.php');?>
<?php include('includes/signin.php');?>
</body>
</html>
<?php } ?>

