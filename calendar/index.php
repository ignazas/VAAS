<?php
require_once dirname(__FILE__) . '/../functions.php';
require_once dirname(__FILE__) . '/../helpers/user.inc';

$today = strtotime(date('Y-m-d'));

if (!isset($_GET['year'])){
    $_GET['year'] = date("Y");
}
if (!isset($_GET['month'])){
    $_GET['month'] = date("n")+1;
}

$month = addslashes($_GET['month'] - 1);
$year = addslashes($_GET['year']);

$query_result = DB::query("SELECT e.event_id,e.event_title,e.event_day,e.event_time,e.event_desc FROM `calendar_events` e INNER JOIN `jos_users` u ON u.id=e.user_id WHERE e.event_month='$month' AND e.event_year='$year' ORDER BY e.event_time");

foreach ($query_result as $info) {
    $day = $info['event_day'];
    $event_id = $info['event_id'];
    $events[$day][] = $info['event_id'];
    $event_info[$event_id]['0'] = $info['event_title'];
    $event_info[$event_id]['1'] = $info['event_time'];
	$event_info[$event_id]['2'] = $info['event_desc'];
}

// gaunam partvirtintas ir atmestas datas
$query_result = DB::query("SELECT * FROM days WHERE day >= '$year-$month-01' AND day < DATE_ADD('$year-$month-01', INTERVAL 1 MONTH) ORDER BY day");
foreach ($query_result as $diena) {
	$dienos[$diena['day']][] = $diena;
}

$todays_date = date("j");
$todays_month = date("n");

$days_in_month = date ("t", mktime(0,0,0,$_GET['month'],0,$_GET['year']));
$first_day_of_month = date ("w", mktime(0,0,0,$_GET['month']-1,1,$_GET['year']));
IF ($first_day_of_month == 0) {$first_day_of_month = 7;};
$count_boxes = 0;
$days_so_far = 0;

IF($_GET['month'] == 13){
    $next_month = 2;
    $next_year = $_GET['year'] + 1;
} ELSE {
    $next_month = $_GET['month'] + 1;
    $next_year = $_GET['year'];
}

IF($_GET['month'] == 2){
    $prev_month = 13;
    $prev_year = $_GET['year'] - 1;
} ELSE {
    $prev_month = $_GET['month'] - 1;
    $prev_year = $_GET['year'];
}

//susikonstruojam menesi
$link_month = empty($_GET['month']) ? 0 : ($_GET['month'] - 1);
$menesis = str_pad($link_month, 2, '0', STR_PAD_LEFT);

$spec_events = array("šventė", "talka", "kita", "svečiai");


?>
<?php include dirname(__FILE__) . "/../templates/include/messages.inc" ?>
<?php include dirname(__FILE__) . "/../templates/include/errors.inc" ?>

<link href="css/cal.css" rel="stylesheet" type="text/css">

<div id="registruotis"></div>
<div id="registracija"></div>
<div id="report"></div>
<div id="addDay"></div>

<div class="pager" align="center">
  <a class="prev glyphicon glyphicon-backward" href="<?php echo "index.php?action=calendar&amp;month=$prev_month&amp;year=$prev_year"; ?>"></a>
  <?php echo date ("Y m", mktime(0,0,0,$_GET['month']-1,1,$_GET['year'])); ?>
  <a class="next glyphicon glyphicon-forward" href="<?php echo "index.php?action=calendar&amp;month=$next_month&amp;year=$next_year"; ?>"></a>
</div>

<div id="dienos">
<table width="100%" class="calendar">
        <tr class="topdays">
          <td><div align="center">Pirmadienis</div></td>
          <td><div align="center">Antradienis</div></td>
          <td><div align="center">Trečiadienis</div></td>
          <td><div align="center">Ketvirtadienis</div></td>
          <td><div align="center">Penktadienis</div></td>
          <td><div align="center">Šeštadienis</div></td>
          <td><div align="center">Sekmadienis</div></td>
        </tr>
		<tr valign="top" bgcolor="#FFFFFF">
<?php
		for ($i = 1; $i <= $first_day_of_month-1; $i++) {
			$days_so_far++;
			$count_boxes++;
			echo "<td width=\"100\" height=\"100\" class=\"beforedayboxes\"></td>\n";
		}
		for ($i = 1; $i <= $days_in_month; $i++) {
   			$days_so_far++;
    			$count_boxes++;
			if (($_GET['month'] == $todays_month+1 && $i == $todays_date) ||
			    ($_GET['month'] != $todays_month+1 && $i == 1))
			    $class = "highlighteddayboxes";
			elseif ($count_boxes==6 || $count_boxes==7)
			    $class = "dayboxes-weekend";
			else
			    $class = "dayboxes";

			//susikonstruojam diena
			$diena = str_pad($i, 2, "0", STR_PAD_LEFT);

			//tikrinam ar diena aktyvi
			$langelio_data = $_GET['year'] ."-". $menesis ."-". $diena;
			$current_date = strtotime($langelio_data);
?>
			<td width="100" height="100" class="<?php echo $class ?>">
			  <a name="<?php echo $langelio_data ?>"></a>

			  <div class="menu">
			    <span class="toprightnumber"><?php echo $i ?><font size="-2"><?php echo get_day_letter($current_date) ?></font></span>
			    <div class="actions">
<?php if ($current_date >= $today) { ?>
			      <a class="add" href="?day=<?php echo $i ?>&amp;month=<?php echo $link_month ?>&amp;year=<?php echo $_GET['year'] ?>"><i class="glyphicon glyphicon-plus"></i></a>
<?php } ?>
<?php if (isset($events[$i])) { ?>
			      <a class="show_day" href="?day=<?php echo $langelio_data ?>"><i class="glyphicon glyphicon-th-list"></i></a>
<?php } ?>
<?php if ($current_date >= $today && UserHelper::has_permission('day_tag')) { ?>
			      <a class="add_day" href="?day=<?php echo $langelio_data ?>"><i class="glyphicon glyphicon-tag"></i></a>
<?php } ?>
			    </div>
			  </div>

			  <div class="data" align="left">
			    <div class="eventinbox">
<?php
			if (isset($events[$i])){
				while (list($key, $value) = each ($events[$i])) {
				    $vardas = empty($event_info[$value][0]) ? NULL : $event_info[$value][0];
				    $title_full = $event_info[$value]['1'] . " " . $vardas;
				    if (!empty($vardas)) {
					$vardas = explode(' ', trim($vardas));
					if (count($vardas) > 0 && !empty($vardas[0]))
					    $vardas[0] = mb_substr($vardas[0], 0, 1) . '.';
					$vardas = implode(' ', $vardas);
				    }
					if (in_array($event_info[$value]['0'], $spec_events)) {
						$title = $event_info[$value]['1'] . " " . $event_info[$value]['0'] . ": " . $event_info[$value]['2'];
						$event = $event_info[$value]['0'];
						echo "&nbsp;<a class=\"$event\" href=\"?id=$value\" title=\"" . $title_full . "\">" . $title  . "</a><br />";
					} else {
						$title = $event_info[$value]['1'] . " " . $vardas;
						echo "&nbsp;<a class=\"registracija\" href=\"?id=$value\" title=\"" . $title_full . "\">" . $title  . "</a><br />";
					}
				}
			}
			if (!empty($dienos[$langelio_data])){
                foreach ($dienos[$langelio_data] as $diena) {
                    echo
                        "<div class=\"" . $diena['status'] . "\" align=\"center\">" .
                        ($current_date >= $today && UserHelper::has_permission('day_tag') ? '<a class="add_day" href="?day=' . $langelio_data . '&amp;status=' . $diena['status'] . '" style="color:inherit;">' : NULL) .
                        $diena['reason'] .
                        ($current_date >= $today && UserHelper::has_permission('day_tag') ? '</a>' : NULL) .
                        "</div>";
                }
			}
?>
			    </div>
			  </div>
			</td>
<?php
			if (($count_boxes == 7) && ($days_so_far != (($first_day_of_month-1) + $days_in_month))) {
				$count_boxes = 0;
				echo "</tr><tr valign=\"top\">\n";
			}
		}
		$extra_boxes = 7 - $count_boxes;
		for ($i = 1; $i <= $extra_boxes; $i++) {
			echo "<td width=\"100\" height=\"100\" class=\"afterdayboxes\"></td>\n";
		}
?>
        </tr>
      </table>
</div>
