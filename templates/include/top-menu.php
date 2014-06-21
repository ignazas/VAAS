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
          <a class="navbar-brand" href="index.php"><i class="glyphicon glyphicon-dashboard"></i> VAAS</a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li <?php if ($action=="news"){echo "class=\"active\"";} ?>><a class="" href="index.php?action=article" title="Pranešimai"><i class="glyphicon glyphicon-bell"></i><span class="hidden-md hidden-sm"> Pranešimai</span></a></li>
            <li <?php if ($action=="finance"){echo "class=\"active\"";} ?>><a class="" href="index.php?action=finance" title="Finansai"><i class="glyphicon glyphicon-shopping-cart"></i><span class="hidden-md hidden-sm"> Finansai</span></a></li>
            <li <?php if ($action=="logbook"){echo "class=\"active\"";} ?>><a class="" href="index.php?action=logbook" title="Žurnalas"><i class="glyphicon glyphicon-book"></i><span class="hidden-md hidden-sm"> Žurnalas</span></a></li>
            <li class="<?php if ($action=="calendar"||$action=="booking"||$action=="my_bookings"){echo 'active';} ?> dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" title="Kalendorius"><i class="glyphicon glyphicon-calendar"></i> Kalendorius <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li class="calendar<?php if ($action=="calendar"){echo " active";} ?>"><a class="" href="index.php?action=calendar"><i class="glyphicon glyphicon-calendar"></i> Registruotis</a></li>
                <li class="calendar mobile<?php if ($action=="calendar"){echo " active";} ?>"><a class="" href="index.php?action=calendar#<?php echo date('Y-m-d')?>"><i class="glyphicon glyphicon-calendar"></i> Registruotis</a></li>
                <li <?php if ($action=="my_bookings"){echo "class=\"active\"";} ?>><a class="" href="index.php?action=my_bookings"><i class="glyphicon glyphicon-book"></i> Mano registracijos</a></li>
              </ul>
            </li>
            <li <?php if ($action=="contact"){echo "class=\"active\"";} ?>><a class="" href="index.php?action=contact" title="Kontaktai"><i class="glyphicon glyphicon-envelope"></i><span class="hidden-md hidden-sm"> Kontaktai</span></a></li>
          </ul>

          <ul class="nav navbar-nav navbar-right">
<?php if (!$on) { ?>
            <li><a class="" href="index.php?action=on"><i class="glyphicon glyphicon-log-in"></i> Prisijungti</a></li>
<?php } else { ?>
            <li <?php if ($action=="user") {echo "class=\"active\"";} ?>><a class="" href="index.php?action=user"><i class="glyphicon glyphicon-user"></i> <?php echo $_SESSION['user']['name']; ?></a></li>

<?php if ($admin) { ?>
            <li class="<?php if ($action=="admin/news"||$action=="admin/bookings"||$action=="admin/finance") {echo 'active';} ?> dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown" title="Administravimas"><i class="glyphicon glyphicon-cog"></i><span class="hidden-md hidden-sm"> Administravimas</span> <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li <?php if ($action=="admin/news") {echo "class=\"active\"";} ?>><a class="" href="admin.php?action=article&amp;view=AdminItemList"><i class="glyphicon glyphicon-bell"></i> Pranešimai</a></li>
                <li <?php if ($action=="admin/working_days") {echo "class=\"active\"";} ?>><a class="" href="admin.php?action=admin/working_days"><i class="glyphicon glyphicon-book"></i> Darbo dienos</a></li>
                <li <?php if ($action=="admin/bookings") {echo "class=\"active\"";} ?>><a class="" href="admin.php?action=admin/bookings"><i class="glyphicon glyphicon-calendar"></i> Registracijos</a></li>
                <li <?php if ($action=="admin/finance") {echo "class=\"active\"";} ?>><a class="" href="admin.php?action=admin/finance"><i class="glyphicon glyphicon-shopping-cart"></i> Finansai</a></li>
                <li <?php if ($action=="admin/aircraft") {echo "class=\"active\"";} ?>><a class="" href="admin.php?action=aircraft"><i class="glyphicon glyphicon-plane"></i> Orlaiviai</a></li>
                <li <?php if ($action=="admin/flight") {echo "class=\"active\"";} ?>><a class="" href="admin.php?action=flight"><i class="glyphicon glyphicon-list-alt"></i> Skrydžiai</a></li>

              </ul>
            </li>
<?php } ?>
            <li><a class="" href="index.php?action=off" title="Atsijungti"><i class="glyphicon glyphicon-log-out"></i><span class="hidden-md hidden-sm"> Atsijungti</span></a></li>
<?php } ?>
          </ul>

        </div><!--/.nav-collapse -->
      </div>
    </div>
