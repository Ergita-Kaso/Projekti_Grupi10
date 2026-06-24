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
$iid=intval($_GET['iid']);
if(isset($_SESSION['msg'])) {
$msg=$_SESSION['msg'];
unset($_SESSION['msg']);
}
if(isset($_SESSION['error'])) {
$error=$_SESSION['error'];
unset($_SESSION['error']);
}
if(isset($_POST['submit2']))
{
$remark=trim($_POST['remark']);
if(!dreamTextLength($remark, 2, 1000)) {
$_SESSION['error']="Pergjigjia duhet te kete 2 deri ne 1000 karaktere.";
header('location:updateissue.php?iid='.$iid);
exit;
} else {
$sql = "UPDATE tblissues SET AdminRemark=:remark, AdminremarkDate=NOW() WHERE id=:iid";
$query = $dbh->prepare($sql);
$query->bindParam(':remark',$remark, PDO::PARAM_STR);
$query->bindParam(':iid',$iid, PDO::PARAM_STR);
$query->execute();
$_SESSION['msg']="Pergjigjia u dergua me sukses!";
header('location:updateissue.php?iid='.$iid);
exit;
}
}
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Pergjigje Mesazhi</title>
<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<style>
body{font-family:Arial, sans-serif;background:#f4f7fb;padding:24px;color:#263847}.issue-reply-box{background:#fff;border-radius:8px;box-shadow:0 8px 24px rgba(28,45,68,.12);padding:22px}.issue-meta{background:#f7f9fb;border:1px solid #e3e9ef;border-radius:6px;padding:12px;margin-bottom:15px}.errorWrap,.succWrap{padding:10px;margin-bottom:15px;background:#fff;box-shadow:0 1px 1px rgba(0,0,0,.1)}.errorWrap{border-left:4px solid #dd3d36}.succWrap{border-left:4px solid #5cb85c}.btn-row{margin-top:15px}.form-control{resize:vertical}
</style>
</head>
<body>
<div class="issue-reply-box">
<h3>Kthim Pergjigje</h3>
<?php if($error){?><div class="errorWrap"><strong>Gabim!</strong> <?php echo htmlentities($error); ?> </div><?php } else if($msg){?><div class="succWrap"><strong>Sukses!</strong> <?php echo htmlentities($msg); ?> </div><?php }?>
<?php
$sql = "SELECT tblissues.*, tblusers.FullName, tblusers.MobileNumber from tblissues left join (select EmailId, max(FullName) as FullName, max(MobileNumber) as MobileNumber from tblusers group by EmailId) tblusers on tblusers.EmailId=tblissues.UserEmail where tblissues.id=:iid";
$query = $dbh->prepare($sql);
$query->bindParam(':iid',$iid, PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
if($query->rowCount() > 0)
{
foreach($results as $result)
{ ?>
<div class="issue-meta">
<p><strong>Perdoruesi:</strong> <?php echo htmlentities($result->FullName);?> | <?php echo htmlentities($result->UserEmail);?> | <?php echo htmlentities($result->MobileNumber);?></p>
<p><strong>Kategoria:</strong> <?php echo htmlentities($result->Issue);?></p>
<p><strong>Mesazhi:</strong> <?php echo htmlentities($result->Description);?></p>
<p><strong>Data:</strong> <?php echo htmlentities($result->PostingDate);?></p>
</div>
<?php if($result->AdminRemark=="") { ?>
<form name="updateticket" method="post">
<label>Pergjigjia:</label>
<textarea class="form-control" rows="7" name="remark" minlength="2" maxlength="1000" required></textarea>
<div class="btn-row">
<button type="submit" name="submit2" class="btn btn-primary">Dergo</button>
<button type="button" onclick="window.close();" class="btn btn-default">Mbyll</button>
</div>
</form>
<?php } else { ?>
<p><strong>Pergjigjia:</strong></p>
<p><?php echo htmlentities($result->AdminRemark);?></p>
<p><strong>Data e Kthimit te Pergjigjes:</strong> <?php echo htmlentities($result->AdminremarkDate);?></p>
<button type="button" onclick="window.close();" class="btn btn-default">Mbyll</button>
<?php }}} else { ?>
<p>Mesazhi nuk u gjet.</p>
<?php } ?>
</div>
</body>
</html>
<?php } ?>

