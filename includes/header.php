<?php if($_SESSION['login'])
{?>
<div class="top-header">
	<div class="container">
		<ul class="tp-hd-lft wow fadeInLeft animated" data-wow-delay=".5s">
			<li class="prnt"><a href="profile.php">Profili</a></li>
			<li class="prnt"><a href="change-password.php">Ndrysho Fjalekalimin</a></li>
			<li class="prnt"><a href="tour-history.php">Historiku</a></li>
		</ul>
		<ul class="tp-hd-rgt wow fadeInRight animated" data-wow-delay=".5s">
			<li class="tol">Miresevini :</li>
			<li class="sig"><?php echo htmlentities($_SESSION['login']);?></li>
		</ul>
		<div class="clearfix"></div>
	</div>
</div><?php } else {?>
<div class="top-header guest-top-header">
	<div class="container">
		<ul class="tp-hd-lft wow fadeInLeft animated" data-wow-delay=".5s">
			<li class="hm"><a href="admin/index.php">Admin Login</a></li>
		</ul>
		<ul class="tp-hd-rgt wow fadeInRight animated" data-wow-delay=".5s">
			<li class="sig"><a href="#" data-toggle="modal" data-target="#myModal">Regjistrohu</a></li>
			<li class="sigi"><a href="#" data-toggle="modal" data-target="#myModal4">Logohu</a></li>
		</ul>
		<div class="clearfix"></div>
	</div>
</div>
<?php }?>

<div class="header">
	<div class="container">
		<div class="logo wow fadeInDown animated" data-wow-delay=".5s">
			<a href="index.php">DREAM <span>TRAVEL</span></a>
		</div>
		<div class="lock fadeInDown animated" data-wow-delay=".5s">
			<div class="clearfix"></div>
		</div>
		<div class="clearfix"></div>
	</div>
</div>

<div class="footer-btm wow fadeInLeft animated" data-wow-delay=".5s">
	<div class="container">
		<div class="navigation">
			<nav class="navbar navbar-default">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
				</div>

				<div class="collapse navbar-collapse nav-wil" id="bs-example-navbar-collapse-1">
					<nav class="cl-effect-1">
						<ul class="nav navbar-nav">
							<li><a href="index.php">Kryefaqja</a></li>
							<li><a href="page.php?type=aboutus">Rreth Nesh</a></li>
							<li><a href="package-list.php">Paketat Turistike</a></li>
							<li><a href="page.php?type=privacy">Politika e Privatesise</a></li>
							<li><a href="page.php?type=terms">Rregullat</a></li>
							<li><a href="page.php?type=contact">Adresa</a></li>
							<?php if($_SESSION['login'])
{?>
							<li><a href="issuetickets.php">Na shkruani</a></li>
							<li class="nav-auth"><a href="logout.php">Dil</a></li>
							<?php } else { ?>
							<?php } ?>
							<div class="clearfix"></div>
						</ul>
					</nav>
				</div>
			</nav>
		</div>
		<div class="clearfix"></div>
	</div>
</div>

