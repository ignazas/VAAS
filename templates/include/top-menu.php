<?php
    // user status
    $on = '';
	$admin = '';
    $action = isset($action) ? $action : NULL;

	IF(isset($_SESSION['user'])) {
    //IF(!empty($_SESSION['user'])) {

		//prisijunges
    	$on = TRUE;

		//adminas
		IF($_SESSION['user']['usertype']=="Administrator" || $_SESSION['user']['usertype']=="Super Administrator") {
			 $admin = TRUE;
		}
    }

	IF(isset( $_GET['action'] )) { 	$action = $_GET['action']; }
    ?>

    <!-- Static navbar -->
    <div class="navbar navbar-default navbar-static-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php?action=">VAAS</a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li <?php if ($action=="news"){echo "class=\"active\"";} ?>><a href="index.php?action=Article">Pranešimai</a></li>
            <li <?php if ($action=="finance"){echo "class=\"active\"";} ?>><a href="index.php?action=finance">Finansai</a></li>
            <li <?php if ($action=="logbook"){echo "class=\"active\"";} ?>><a href="index.php?action=logbook">Log Book</a></li>
            <li <?php if ($action=="calendar"||$action=="booking"||$action=="my_bookings"){echo "class=\"active\"";} ?>class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Kalendorius <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li <?php if ($action=="calendar"){echo "class=\"active\"";} ?>><a href="index.php?action=calendar">Registruotis</a></li>
                <li <?php if ($action=="my_bookings"){echo "class=\"active\"";} ?>><a href="index.php?action=my_bookings">Mano registracijos</a></li>
              </ul>
            </li>
            <li <?php if ($action=="contact"){echo "class=\"active\"";} ?>><a href="index.php?action=contact">Kontaktai</a></li>
           <?php IF ($admin) { ?>
           <li <?php if ($action=="admin/news"||$action=="admin/bookings"||$action=="admin/finance") {echo "class=\"active\"";} ?> class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Administravimas <b class="caret"></b></a>
           		<ul class="dropdown-menu">
                	<li <?php if ($action=="admin/news") {echo "class=\"active\"";} ?>><a href="admin.php?action=Atricle&amp;view=AdminItemList">Pranešimai</a></li>
                	<li <?php if ($action=="admin/working_days") {echo "class=\"active\"";} ?>><a href="admin.php?action=admin/working_days">Darbo dienos</a></li>
                	<li <?php if ($action=="admin/bookings") {echo "class=\"active\"";} ?>><a href="admin.php?action=admin/bookings">Registracijos</a></li>
                	<li <?php if ($action=="admin/finance") {echo "class=\"active\"";} ?>><a href="admin.php?action=admin/finance">Finansai</a></li>
                	<li <?php if ($action=="admin/aircrafts") {echo "class=\"active\"";} ?>><a href="admin.php?action=aircraft">Orlaiviai</a></li>
              	</ul>
           </li>
           <?php } ?>

          </ul>
          <ul class="nav navbar-nav navbar-right">
          	<?php if (!$on) { ?>
            <li><a href="index.php?action=on">Prisijungti</a></li>
            <?php } else { ?>
            <li><a href="index.php?action=user"><u><?php echo $_SESSION['user']['name']; ?></u></a></li>
            <li><a href="index.php?action=off">Atsijungti</a></li>

            <?php } ?>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>
