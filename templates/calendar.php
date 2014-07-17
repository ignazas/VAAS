<?php
require_once dirname(__FILE__) . '/../helpers/user.inc';
UserHelper::check_access();

include "templates/include/header.php";
include "templates/include/top-menu.php";
?>

<div class="container">
	<div class="page-header"><h1>Kalendorius</h1></div>

        <?php include "calendar/index.php" ?>
		Norėdami registruotis skraidymams spauskite pliuso [+] ženklą toje dienoje.
    </div> <!-- /container -->


<?php include "templates/include/footer.php" ?>