<?php
$action = isset($_GET['action']) ? $_GET['action'] : (isset($action) ? $action : NULL);
if ($action == "practice" && isset($_GET['view']) && $_GET['view'] == "DataItemList")
    $action = "practice_data";
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
<?php if ($on) { ?>
	    <li <?php if ($action=="documents"){echo "class=\"active\"";} ?>><a class="" href="https://www.dropbox.com/sh/oarg4cfludjocqa/AACUxivtcI6HzGLTrBCny0gBa?dl=0" title="Dokumentai" target="_blank"><i class="glyphicon glyphicon-file"></i><span class="hidden-md hidden-sm"> Dokumentai</span></a></li>

            <li <?php if ($action=="finance"){echo "class=\"active\"";} ?>><a class="" href="index.php?action=finance" title="Finansai"><i class="glyphicon glyphicon-shopping-cart"></i><span class="hidden-md hidden-sm"> Finansai</span></a></li>

            <li class="<?php if (in_array($action, array("flight", "analysis", "practice"))){echo 'active';} ?> dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" title="Skrydžiai"><i class="glyphicon glyphicon-list-alt"></i><span class="hidden-md hidden-sm">  Skrydžiai</span> <b class="caret"></b></a>
              <ul class="dropdown-menu">
		<li <?php if ($action=="flight") {echo "class=\"active\"";} ?>><a class="" href="index.php?action=flight&amp;view=ItemList&amp;date=&amp;search=<?php echo empty($_SESSION['user']['name']) ? NULL : $_SESSION['user']['name'] ?>" title="Mano skrydžiai"><i class="glyphicon glyphicon-list-alt"></i> Mano skrydžiai</a></li>
		<li <?php if ($action=="analysis"){echo "class=\"active\"";} ?>><a class="" href="index.php?action=analysis" title="Analizė"><i class="glyphicon glyphicon-book"></i> Analizė</a></li>
<?php  if (UserHelper::is_student()) { ?>
<!--		<li <?php if ($action=="practice") {echo "class=\"active\"";} ?>><a class="" href="index.php?action=practice" title="Skrydžių praktikos lapas"><i class="glyphicon glyphicon-list-alt"></i> Skrydžių praktikos lapas</a></li> -->
<!--                <li <?php if ($action=="practice_data") {echo "class=\"active\"";} ?>><a class="" href="admin.php?action=practice&amp;view=DataItemList" title="Praktikos atlikimas"><i class="glyphicon glyphicon-list"></i> Praktikos atlikimas</a></li> -->
<?php  } ?>
              </ul>
            </li>

            <li class="<?php if (in_array($action, array("calendar", "my_bookings", 'weather'))){echo 'active';} ?> dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" title="Kalendorius"><i class="glyphicon glyphicon-calendar"></i><span class="hidden-md hidden-sm"> Kalendorius</span> <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li class="calendar<?php if ($action == "calendar"){echo " active";} ?>"><a class="" href="index.php?action=calendar"><i class="glyphicon glyphicon-calendar"></i> Registruotis</a></li>
                <li class="calendar mobile<?php if ($action=="calendar"){echo " active";} ?>"><a class="" href="index.php?action=calendar#<?php echo date('Y-m-d')?>"><i class="glyphicon glyphicon-calendar"></i> Registruotis</a></li>
                <li <?php if ($action=="my_bookings"){echo "class=\"active\"";} ?>><a class="" href="index.php?action=my_bookings"><i class="glyphicon glyphicon-book"></i> Mano registracijos</a></li>
		<li <?php if ($action=="weather"){echo "class=\"active\"";} ?>><a class="" href="index.php?action=weather" title="Orai"><i class="glyphicon glyphicon-cloud"></i> Orai</a></li>
              </ul>
            </li>
            <li <?php if ($action=="user" && isset($_GET['view']) && $_GET['view'] == 'ItemList'){echo "class=\"active\"";} ?>><a class="" href="index.php?action=user&amp;view=ItemList" title="Nariai"><i class="glyphicon glyphicon-user"></i><span class="hidden-md hidden-sm"> Nariai</span></a></li>

            <li <?php if ($action=="article"){echo "class=\"active\"";} ?>><a class="" href="index.php?action=article" title="Pranešimai"><i class="glyphicon glyphicon-bell"></i><span class="hidden-md hidden-sm"> Pranešimai</span></a></li>

            <li <?php if ($action=="contact"){echo "class=\"active\"";} ?>><a class="" href="index.php?action=contact" title="Kontaktai"><i class="glyphicon glyphicon-envelope"></i><span class="hidden-md hidden-sm"> Kontaktai</span></a></li>
          </ul>

          <ul class="nav navbar-nav navbar-right">
<?php if (!$on) { ?>
            <li><a class="" href="index.php?action=on"><i class="glyphicon glyphicon-log-in"></i> Prisijungti</a></li>
<?php } else { ?>
            <li <?php if ($action=="user" && (empty($_GET['id']) || (!empty($_SESSION['user']['id']) && $_GET['id'] == $_SESSION['user']['id'])) && (empty($_GET['view']) || $_GET['view'] == 'View' || $_GET['view'] == 'Edit')) {echo "class=\"active\"";} ?>><a class="" href="index.php?action=user"><i class="glyphicon glyphicon-user"></i> <?php echo $_SESSION['user']['name']; ?></a></li>

<?php if ($admin || UserHelper::has_permission('day_tag')) { ?>
            <li class="<?php if (in_array($action, array("article", "admin/bookings", "admin/finance", "aircraft", "flight", "service", "practice_data"))) {echo 'active';} ?> dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown" title="Administravimas"><i class="glyphicon glyphicon-cog"></i><span class="hidden-lg hidden-md hidden-sm"> Administravimas</span> <b class="caret"></b></a>
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
                <li <?php if ($action=="aircraft") {echo "class=\"active\"";} ?>><a class="" href="admin.php?action=aircraft" title="Orlaiviai"><i class="glyphicon glyphicon-plane"></i> Orlaiviai</a></li>
                <li <?php if ($action=="category") {echo "class=\"active\"";} ?>><a class="" href="admin.php?action=category" title="Kategorijos"><i class="glyphicon glyphicon-tasks"></i> Kategorijos</a></li>
                <li <?php if ($action=="flight") {echo "class=\"active\"";} ?>><a class="" href="admin.php?action=flight" title="Skrydžiai"><i class="glyphicon glyphicon-list-alt"></i> Skrydžiai</a></li>
                <li <?php if ($action=="service") {echo "class=\"active\"";} ?>><a class="" href="admin.php?action=service" title="Kainynas"><i class="glyphicon glyphicon-shopping-cart"></i> Kainynas</a></li>
<!--                <li <?php if ($action=="practice_data") {echo "class=\"active\"";} ?>><a class="" href="admin.php?action=practice&amp;view=DataItemList" title="Praktika"><i class="glyphicon glyphicon-list"></i> Praktika</a></li> -->
<?php } ?>
              </ul>
            </li>
<?php } ?>
            <li><a class="" href="index.php?action=off" title="Atsijungti"><i class="glyphicon glyphicon-log-out"></i><span class="hidden-md hidden-sm hidden-lg"> Atsijungti</span></a></li>
<?php } ?>
<?php } ?>
          </ul>

        </div><!--/.nav-collapse -->
      </div>
    </div>

<?php
if ($on) {
    require_once dirname(__FILE__) . '/../../models/user.inc';
    $user_id = UserHelper::get_id();
    $curr_user = User::Get($user_id);

    if (!empty($curr_user->licenseValidTill) && $curr_user->licenseValidTill < date('Y-m-d')) {
        Messages::set_message("Licencija nebegalioja. <a href=\"index.php?action=user&view=Edit\">Nurodykite</a>", 'errors');
    }
    if (!empty($curr_user->healthValidTill) && $curr_user->healthValidTill < date('Y-m-d')) {
        Messages::set_message("Sveikatos paž. nebegalioja. <a href=\"index.php?action=user&view=Edit\">Nurodykite</a>", 'errors');
    }

    if (empty($curr_user->licenseValidTill) && empty($curr_user->healthValidTill)) {
        Messages::set_message("Nenurodyta, iki kada galioja licencija ir sveikatos paž. <a href=\"index.php?action=user&view=Edit\">Nurodykite</a>", 'errors');
    } else if (empty($curr_user->licenseValidTill)) {
        Messages::set_message("Nenurodyta, iki kada galioja licencija. <a href=\"index.php?action=user&view=Edit\">Nurodykite</a>", 'errors');
    } else if (empty($curr_user->healthValidTill)) {
        Messages::set_message("Nenurodyta, iki kada galioja sveikatos paž. <a href=\"index.php?action=user&view=Edit\">Nurodykite</a>", 'errors');
    }
}
