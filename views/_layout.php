<?php
require_once dirname(__FILE__) . '/../helpers/messages.inc';

require dirname(__FILE__) . "/../common.php";
require dirname(__FILE__) . "/../secure.php";
include dirname(__FILE__) . "/../templates/include/header.php";
include dirname(__FILE__) . "/../templates/include/top-menu.php";
?>

<div class="container">
    <?php include "templates/include/messages.inc" ?>
    <?php include "templates/include/errors.inc" ?>

    <?php require $this->view; ?>

</div> <!-- /container -->

<?php include "templates/include/footer.php" ?>
