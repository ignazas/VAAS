<a class="b-close"><i class="glyphicon glyphicon-remove-circle"></i></a>
<?php
require_once dirname(__FILE__) . '/../functions.php';
require_once dirname(__FILE__) . '/const.inc';
require_once dirname(__FILE__) . '/../models/calendar_event.inc';

$info = CalendarEvent::get($_GET['id']);

$time_array = split(":", $info->event_time);
?>

<table style="max-width:100%;width:480px;padding-right: 90px;">
  <tr>
    <td><span class="eventwhen"><h3><? echo date("Y-m-d H:i", mktime($time_array['0'],$time_array['1'],0,$info->event_month,$info->event_day,$info->event_year)); ?></h3></span><br></td>
  </tr>
<?php if (!empty($info->user)) { ?>
  <tr>
    <td>
      <div class="col-md-8 col-sm-12">
          <?php echo theme('display', 'name', 'Vardas', $info->user) ?>
          <?php echo theme('display_email', 'email', 'El. paštas', $info->user) ?>
          <?php echo theme('display_phone', 'telephone1', 'Telefonas', $info->user) ?>
          <?php echo theme('display_url', 'website', 'Interneto svetainė', $info->user) ?>
      </div>
      <div class="col-md-4 col-sm-12<?php if (empty($info->user->avatar)) echo ' hidden-sm hidden-xs hidden-md'?>">
	<img src="<?php echo '/' . CATALOG . '/' . (empty($info->user->avatar) ? 'images/users/avatar.jpg' : ('uploads/users/' . $info->user->avatar)) ?>" class="img-thumbnail img-responsive" alt="<?php echo htmlentities($info->user->name) ?>">
      </div>
    </td>
  </tr>
<?php } ?>

<?php $spec_events = array("šventė", "talka", "kita", "svečiai") ?>
<?php if (!empty($info->event_desc) || in_array($info->event_title, $spec_events)) { ?>
  <tr>
    <td><h2 class="event">Pastabos</h2></td>
  </tr>
  <?php if (in_array($info->event_title, $spec_events)) { ?>
  <tr>
    <td class="eventdetail">
      <?php echo theme('display', 'event_title', 'Renginys', $info) ?>
    </td>
  </tr>
  <?php } ?>
  <tr>
    <td class="eventdetail">
      <?php echo theme('display', 'event_desc', NULL, $info) ?>
    </td>
  </tr>
<?php } ?>
</table>
