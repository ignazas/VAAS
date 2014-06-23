<?php
require_once dirname(__FILE__) . '/../functions.php';
require_once dirname(__FILE__) . '/../models/calendar_event.inc';

$info = CalendarEvent::get($_GET['id']);

$time_array = split(":", $info->event_time);
?>

<a class="b-close"><i class="glyphicon glyphicon-remove-circle"></i></a>

<h2 class="eventwhen col-xs-12"><? echo date("Y-m-d H:i", mktime($time_array['0'],$time_array['1'],0,$info->event_month,$info->event_day,$info->event_year)); ?></h2>

<div class="col-xs-12" style="width:480px;">

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
<?php if ($info->isSpecial()) { ?>
  <div class="eventdetail">
    <?php echo theme('display', 'event_title', 'Renginys', $info) ?>
  </div>
<?php } ?>
  <div class="eventdetail">
    <?php echo theme('display', 'event_desc', NULL, $info) ?>
  </div>
<?php } ?>

</div>
