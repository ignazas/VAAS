<?php
require_once dirname(__FILE__) . '/../functions.php';
require_once dirname(__FILE__) . '/../models/calendar_event.inc';
require_once dirname(__FILE__) . '/../helpers/user.inc';

$info = CalendarEvent::get($_GET['id']);

$time_array = split(":", str_replace(array('.', ','), ':', $info->event_time));
if (count($time_array) == 1)
    array_push($time_array, '00');
?>

<a class="b-close"><i class="glyphicon glyphicon-remove-circle"></i></a>

<h2 class="eventwhen col-xs-12"><? echo date("Y-m-d H:i", mktime($time_array['0'],$time_array['1'],0,$info->event_month,$info->event_day,$info->event_year)); ?></h2>

<div class="col-xs-12" style="width:480px;margin-bottom:30px;">

<?php if (!empty($info->user)) { ?>
  <div class="col-md-6 col-sm-12">
    <?php echo theme('display', 'name', '', $info->user) ?>
    <?php echo theme('display_email', 'email', '', $info->user) ?>
    <?php echo theme('display_phone', 'telephone1', '', $info->user) ?>
    <?php echo theme('display_url', 'website', '', $info->user) ?>
  </div>
  <div class="col-md-6 col-sm-12<?php if (empty($info->user->avatar)) echo ' hidden-sm hidden-xs hidden-md'?>">
    <?php echo theme('display_avatar', 'avatar', $info->user->name, $info->user) ?>
  </div>
<?php } ?>

<?php if (!empty($info->event_desc) || $info->isSpecial()) { ?>
  <h2 class="event">Pastabos</h2>
<?php   if ($info->isSpecial()) { ?>
  <div class="eventdetail">
    <?php echo theme('display', 'event_title', 'Renginys', $info) ?>
  </div>
<?php   } ?>
  <div class="eventdetail">
    <?php echo theme('display', 'event_desc', NULL, $info) ?>
  </div>
<?php } ?>

<?php USerHelper::init_session() ?>
<?php if (strtotime($info->event_date) >= strtotime(date('Y-m-d')) && !empty($_SESSION['user']['id']) && $_SESSION['user']['id'] == $info->user->id) { ?>
  <div class="buttons">
    <a class="delete btn btn-danger" onclick="return confirm('Ar tikrai norite atsisakyti registracijos?')" href="index.php?action=deleteBooking&amp;bookingId=<?php echo $info->event_id ?>&amp;destination=index.php%3Faction%3Dcalendar%26year%3D<?php echo $info->event_year ?>%26month%3D<?php echo $info->event_month+1 ?>"><i class="glyphicon glyphicon-minus"></i> Atsisakyti</a>
  </div>
<?php } ?>

</div>
