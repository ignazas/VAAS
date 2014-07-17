<?php
require_once dirname(__FILE__) . '/../helpers/user.inc';
UserHelper::check_access();

require_once dirname(__FILE__) . '/../helpers/messages.inc';
include dirname(__FILE__) . "/../templates/include/header.php";
include dirname(__FILE__) . "/../templates/include/top-menu.php";
?>

<div class="container">
    <?php include "templates/include/messages.inc" ?>
    <?php include "templates/include/errors.inc" ?>

    <?php if (!empty($this->view)) require $this->view; ?>

</div> <!-- /container -->

<?php include "templates/include/footer.php" ?>
