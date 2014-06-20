<?php
require_once dirname(__FILE__) . '/../functions.php';
require_once dirname(__FILE__) . '/const.inc';
require_once dirname(__FILE__) . '/../models/calendar_event.inc';

$info = CalendarEvent::get($_GET['id']);

$time_array = split(":", $info->event_time);
?>

<a class="b-close"><i class="glyphicon glyphicon-remove-circle"></i></a>

<h2 class="eventwhen col-xs-12"><? echo date("Y-m-d H:i", mktime($time_array['0'],$time_array['1'],0,$info->event_month,$info->event_day,$info->event_year)); ?></h2>

<table class="col-xs-12" style="max-width:100%;width:480px;table-layout:fixed;">
<?php if (!empty($info->user)) { ?>
  <tr>
    <td>
      <div class="col-md-6 col-sm-12">
          <?php echo theme('display', 'name', '', $info->user) ?>
          <?php echo theme('display_email', 'email', '', $info->user) ?>
          <?php echo theme('display_phone', 'telephone1', '', $info->user) ?>
          <?php echo theme('display_url', 'website', '', $info->user) ?>
      </div>
      <div class="col-md-6 col-sm-12<?php if (empty($info->user->avatar)) echo ' hidden-sm hidden-xs hidden-md'?>">
	<?php echo theme('display_avatar', 'avatar', $info->user->name, $info->user) ?>
      </div>
    </td>
  </tr>
<?php } ?>

<?php if (!empty($info->event_desc) || $info->isSpecial()) { ?>
  <tr>
    <td><h2 class="event">Pastabos</h2></td>
  </tr>
<?php if ($info->isSpecial()) { ?>
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
