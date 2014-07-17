<?php
$action = isset($_GET['action']) ? $_GET['action'] : (isset($action) ? $action : NULL);
$on = UserHelper::logged_in();
$admin = UserHelper::has_permission();
?>

    <!-- Static navbar -->
    <div class="navbar navbar-default navbar-static-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Perjungti navigaciją</span>
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
            <li class="<?php if ($action=="calendar"||$action=="my_bookings"||$action=='weather'){echo 'active';} ?> dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" title="Kalendorius"><i class="glyphicon glyphicon-calendar"></i> Kalendorius <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li class="calendar<?php if ($action=="calendar"){echo " active";} ?>"><a class="" href="index.php?action=calendar"><i class="glyphicon glyphicon-calendar"></i> Registruotis</a></li>
                <li class="calendar mobile<?php if ($action=="calendar"){echo " active";} ?>"><a class="" href="index.php?action=calendar#<?php echo date('Y-m-d')?>"><i class="glyphicon glyphicon-calendar"></i> Registruotis</a></li>
                <li <?php if ($action=="my_bookings"){echo "class=\"active\"";} ?>><a class="" href="index.php?action=my_bookings"><i class="glyphicon glyphicon-book"></i> Mano registracijos</a></li>
		<li <?php if ($action=="weather"){echo "class=\"active\"";} ?>><a class="" href="index.php?action=weather" title="Orai"><i class="glyphicon glyphicon-cloud"></i><span class="hidden-md hidden-sm"> Orai</span></a></li>
              </ul>
            </li>
            <li <?php if ($action=="user" && isset($_GET['view']) && $_GET['view'] == 'ItemList'){echo "class=\"active\"";} ?>><a class="" href="index.php?action=user&amp;view=ItemList" title="Nariai"><i class="glyphicon glyphicon-user"></i><span class="hidden-md hidden-sm"> Nariai</span></a></li>
            <li <?php if ($action=="contact"){echo "class=\"active\"";} ?>><a class="" href="index.php?action=contact" title="Kontaktai"><i class="glyphicon glyphicon-envelope"></i><span class="hidden-md hidden-sm"> Kontaktai</span></a></li>
          </ul>

          <ul class="nav navbar-nav navbar-right">
<?php if (!$on) { ?>
            <li><a class="" href="index.php?action=on"><i class="glyphicon glyphicon-log-in"></i> Prisijungti</a></li>
<?php } else { ?>
            <li <?php if ($action=="user" && (empty($_GET['id']) || (!empty($_SESSION['user']['id']) && $_GET['id'] == $_SESSION['user']['id'])) && (empty($_GET['view']) || $_GET['view'] == 'View' || $_GET['view'] == 'Edit')) {echo "class=\"active\"";} ?>><a class="" href="index.php?action=user"><i class="glyphicon glyphicon-user"></i> <?php echo $_SESSION['user']['name']; ?></a></li>

<?php if ($admin || UserHelper::has_permission('day_tag')) { ?>
            <li class="<?php if ($action=="admin/news"||$action=="admin/bookings"||$action=="admin/finance") {echo 'active';} ?> dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown" title="Administravimas"><i class="glyphicon glyphicon-cog"></i><span class="hidden-lg hidden-md hidden-sm"> Administravimas</span> <b class="caret"></b></a>
              <ul class="dropdown-menu">
<?php if ($admin) { ?>
                <li <?php if ($action=="admin/news") {echo "class=\"active\"";} ?>><a class="" href="admin.php?action=article&amp;view=AdminItemList" title="Pranešimai"><i class="glyphicon glyphicon-bell"></i> Pranešimai</a></li>
<?php } ?>
<?php if (UserHelper::has_permission('day_tag')) { ?>
                <li <?php if ($action=="admin/working_days") {echo "class=\"active\"";} ?>><a class="" href="admin.php?action=admin/working_days" title="Darbo dienos"><i class="glyphicon glyphicon-book"></i> Darbo dienos</a></li>
<?php } ?>
<?php if ($admin) { ?>
                <li <?php if ($action=="admin/bookings") {echo "class=\"active\"";} ?>><a class="" href="admin.php?action=admin/bookings" title="Registracijos"><i class="glyphicon glyphicon-calendar"></i> Registracijos</a></li>
                <li <?php if ($action=="admin/finance") {echo "class=\"active\"";} ?>><a class="" href="admin.php?action=admin/finance" title="Finansai"><i class="glyphicon glyphicon-shopping-cart"></i> Finansai</a></li>
                <li <?php if ($action=="admin/aircraft") {echo "class=\"active\"";} ?>><a class="" href="admin.php?action=aircraft" title="Orlaiviai"><i class="glyphicon glyphicon-plane"></i> Orlaiviai</a></li>
                <li <?php if ($action=="admin/flight") {echo "class=\"active\"";} ?>><a class="" href="admin.php?action=flight" title="Skrydžiai"><i class="glyphicon glyphicon-list-alt"></i> Skrydžiai</a></li>
<?php } ?>
              </ul>
            </li>
<?php } ?>
            <li><a class="" href="index.php?action=off" title="Atsijungti"><i class="glyphicon glyphicon-log-out"></i><span class="hidden-md hidden-sm"> Atsijungti</span></a></li>
<?php } ?>
          </ul>

        </div><!--/.nav-collapse -->
      </div>
    </div>
