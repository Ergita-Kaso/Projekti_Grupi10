<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
    {   
header('location:index.php');
}
else{ 
    
?>
<!DOCTYPE HTML>
<html>
<head>
<title>Dream Travel | Menaxhimi i mesazheve Admin </title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<link href="css/bootstrap.min.css" rel='stylesheet' type='text/css' />
<link href="css/style.css" rel='stylesheet' type='text/css' />
<link rel="stylesheet" href="css/morris.css" type="text/css"/>
<link href="css/font-awesome.css" rel="stylesheet"> 
<script src="js/jquery-2.1.4.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/table-style.css" />
<link rel="stylesheet" type="text/css" href="css/basictable.css" />
<script type="text/javascript" src="js/jquery.basictable.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
      $('#issues-table').basictable();
    });
</script>
<script language="javascript" type="text/javascript">
var popUpWin=0;
function popUpWindow(URLStr, left, top, width, height)
{
 if(popUpWin && !popUpWin.closed) popUpWin.close();
 popUpWin = open(URLStr,'popUpWin','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,copyhistory=yes,width='+(width||650)+',height='+(height||650)+',left='+(left||100)+',top='+(top||100)+',screenX='+(left||100)+',screenY='+(top||100));
}
</script>
<link href='//fonts.googleapis.com/css?family=Roboto:700,500,300,100italic,100,400' rel='stylesheet' type='text/css'/>
<link href='//fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="css/icon-font.min.css" type='text/css' />
  <style>
.errorWrap {padding: 10px;margin: 0 0 20px 0;background: #fff;border-left: 4px solid #dd3d36;box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);}
.succWrap{padding: 10px;margin: 0 0 20px 0;background: #fff;border-left: 4px solid #5cb85c;box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);}
.message-section h2{margin-bottom:16px;}
.empty-row{text-align:center;color:#687587;padding:22px !important;}
  </style>
</head> 
<body>
   <div class="page-container">
   
<div class="left-content">
       <div class="mother-grid-inner">
           
                <?php include('includes/header.php');?>
                     <div class="clearfix"> </div> 
                </div>

<ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="dashboard.php">Home</a><i class="fa fa-angle-right"></i>Menaxho Mesazhet</li>
            </ol>
<div class="agile-grids"> 
                
                <?php if($error){?><div class="errorWrap"><strong>Gabim! </strong> <?php echo htmlentities($error); ?> </div><?php } 
                else if($msg){?><div class="succWrap"><strong>Sukses! </strong> <?php echo htmlentities($msg); ?> </div><?php }?>
                <div class="agile-tables">
                    <div class="w3l-table-info message-section">
                      <h2>Menaxho Mesazhet - Na shkruani</h2>
                        <table id="issues-table">
                        <thead>
                          <tr>
                            <th><center>ID</center></th>
                            <th><center>Perdoruesi</center></th>
                            <th><center>Nr.Tel / Email</center></th>
                            <th><center>Kategoria</center></th>
                            <th><center>Mesazhi</center></th>
                            <th><center>Data e postimit</center></th>
                            <th><center>Statusi</center></th>
                            <th><center>Data e pergjigjes</center></th>
                            <th><center>Veprimi</center></th>
                          </tr>
                        </thead>
                        <tbody>
<?php $sqlIssues = "SELECT ti.id as id,tblusers.FullName as fname,tblusers.MobileNumber as mnumber,tblusers.EmailId as email,ti.Issue as issue,ti.Description as Description,ti.PostingDate as PostingDate,ti.AdminRemark as AdminRemark,ti.AdminremarkDate as AdminremarkDate from tblissues ti inner join (select coalesce(nullif(max(case when AdminRemark is not null and AdminRemark<>'' then id else 0 end),0), max(id)) as id from tblissues group by UserEmail, Issue, Description) latest on latest.id=ti.id left join (select EmailId, max(FullName) as FullName, max(MobileNumber) as MobileNumber from tblusers group by EmailId) tblusers on tblusers.EmailId=ti.UserEmail order by ti.PostingDate desc";
$queryIssues = $dbh->prepare($sqlIssues);
$queryIssues->execute();
$issueResults=$queryIssues->fetchAll(PDO::FETCH_OBJ);

if($queryIssues->rowCount() > 0)
{
foreach($issueResults as $issue)
{               ?>
                          <tr>
                            <td width="120">#TKT-<?php echo htmlentities($issue->id);?></td>
                            <td width="130"><?php echo htmlentities($issue->fname);?></td>
                            <td width="160"><?php echo htmlentities($issue->mnumber);?> /<br /><?php echo htmlentities($issue->email);?></td>
                            <td width="180"><?php echo htmlentities($issue->issue);?></td>
                            <td width="340"><?php echo htmlentities($issue->Description);?></td>
                            <td width="120"><?php echo htmlentities($issue->PostingDate);?></td>
                            <td><?php if($issue->AdminRemark){?><span class="admin-status admin-status-read">Pergjigjur</span><?php } else {?><span class="admin-status admin-status-pending">Ne pritje</span><?php } ?></td>
                            <td width="120"><?php echo $issue->AdminremarkDate ? htmlentities($issue->AdminremarkDate) : '-';?></td>
                            <td class="package-actions"><a class="btn btn-primary btn-sm" href="javascript:void(0);" onClick="popUpWindow('updateissue.php?iid=<?php echo htmlentities($issue->id);?>', 100, 100, 650, 650);">Lexo / Pergjigju</a></td>
                          </tr>
                         <?php } } else { ?>
                          <tr><td colspan="9" class="empty-row">Nuk ka mesazhe nga seksioni Na shkruani.</td></tr>
                         <?php } ?>
                        </tbody>
                      </table>
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


