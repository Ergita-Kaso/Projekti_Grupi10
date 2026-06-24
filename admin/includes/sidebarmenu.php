<?php
$currentPage = basename($_SERVER['PHP_SELF']);
$packagePages = array('create-package.php','manage-packages.php','update-package.php','change-image.php');
function adminMenuActive($pages, $currentPage) {
    if(is_array($pages)) {
        return in_array($currentPage, $pages) ? ' class="active"' : '';
    }
    return $currentPage === $pages ? ' class="active"' : '';
}
?>
<div class="sidebar-menu">
    <header class="logo1">
        <a href="#" class="sidebar-icon"> <span class="fa fa-bars"></span> </a>
    </header>
    <div class="menu-divider"></div>
    <div class="menu">
        <ul id="menu">
            <li<?php echo adminMenuActive('dashboard.php', $currentPage);?>><a href="dashboard.php"><i class="fa fa-tachometer"></i> <span>Paneli</span><div class="clearfix"></div></a></li>
            <li id="menu-academico"<?php echo adminMenuActive($packagePages, $currentPage);?>><a href="#"><i class="fa fa-list-ul" aria-hidden="true"></i><span>Paketat</span> <span class="fa fa-angle-right menu-arrow"></span><div class="clearfix"></div></a>
                <ul id="menu-academico-sub">
                    <li id="menu-academico-avaliacoes"<?php echo adminMenuActive('create-package.php', $currentPage);?>><a href="create-package.php">Krijo</a></li>
                    <li id="menu-academico-avaliacoes"<?php echo adminMenuActive(array('manage-packages.php','update-package.php','change-image.php'), $currentPage);?>><a href="manage-packages.php">Menaxho</a></li>
                </ul>
            </li>
            <li id="menu-academico"<?php echo adminMenuActive('manage-users.php', $currentPage);?>><a href="manage-users.php"><i class="fa fa-users" aria-hidden="true"></i><span>Menaxho Perdoruesit</span><div class="clearfix"></div></a></li>
            <li<?php echo adminMenuActive('manage-bookings.php', $currentPage);?>><a href="manage-bookings.php"><i class="fa fa-list" aria-hidden="true"></i><span>Menaxho Prenotimet</span><div class="clearfix"></div></a></li>
            <li<?php echo adminMenuActive('manage-enquires.php', $currentPage);?>><a href="manage-enquires.php"><i class="fa fa-envelope-o" aria-hidden="true"></i><span>Menaxho Mesazhet</span><div class="clearfix"></div></a></li>
            <li<?php echo adminMenuActive('manage-pages.php', $currentPage);?>><a href="manage-pages.php"><i class="fa fa-file-text-o" aria-hidden="true"></i><span>Menaxho Faqet</span><div class="clearfix"></div></a></li>
        </ul>
    </div>
</div>
