<?php
require_once dirname(__FILE__) . '/../functions.php';
require_once dirname(__FILE__) . '/const.inc';

function getmicrotime(){
    list($usec, $sec) = explode(" ",microtime());
    return ((float)$usec + (float)$sec);
}

$time_start = getmicrotime();

function get_day_letter($day) {
	$day = date('l', strtotime( $day));
	switch($day)
	{
		case "Monday":    $savaites_diena = "Pirmadienis";  break;
		case "Tuesday":   $savaites_diena = "Antradienis"; break;
		case "Wednesday": $savaites_diena = "Trečiadienis";  break;
		case "Thursday":  $savaites_diena = "Ketvirtadienis"; break;
		case "Friday":    $savaites_diena = "Penktadienis";  break;
		case "Saturday":  $savaites_diena = "Šeštadienis";  break;
		case "Sunday":    $savaites_diena = "Sekmadienis";  break;
		default:          $savaites_diena = "-"; break;
	}
	$raide = mb_substr($savaites_diena, 0, 2);
	return $raide;

}

IF(!isset($_GET['year'])){
    $_GET['year'] = date("Y");
}
IF(!isset($_GET['month'])){
    $_GET['month'] = date("n")+1;
}

$month = addslashes($_GET['month'] - 1);
$year = addslashes($_GET['year']);

$query_result = DB::query("SELECT e.event_id,e.event_title,e.event_day,e.event_time,e.event_desc FROM " . TBL_EVENTS . " e INNER JOIN `jos_users` u ON u.id=e.user_id WHERE e.event_month='$month' AND e.event_year='$year' ORDER BY e.event_time");

foreach ($query_result as $info) {
    $day = $info['event_day'];
    $event_id = $info['event_id'];
    $events[$day][] = $info['event_id'];
    $event_info[$event_id]['0'] = $info['event_title'];
    $event_info[$event_id]['1'] = $info['event_time'];
	$event_info[$event_id]['2'] = $info['event_desc'];
}

// gaunam partvirtintas ir atmestas datas

$query_result = DB::query("SELECT * FROM days ORDER BY day");

foreach ($query_result as $diena) {
	$dienos[$diena['day']]['data'] = $diena['day'];
	$dienos[$diena['day']]['status'] = $diena['status'];
	$dienos[$diena['day']]['reason'] = $diena['reason'];
	$dienos[$diena['day']]['confirmed'] = $diena['confirmed'];
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



?>
<script src="js/jquery-1.11.0.js"></script>

<link href="css/cal.css" rel="stylesheet" type="text/css">

<script language="JavaScript" type="text/JavaScript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->

</script>
</head>

<body>


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
<table width="100%" bgcolor="#000000">
  <tr>
    <td><table width="100%" class="calendar">
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
			$days_so_far = $days_so_far + 1;
			$count_boxes = $count_boxes + 1;
			echo "<td width=\"100\" height=\"100\" class=\"beforedayboxes\"></td>\n";
		}
		for ($i = 1; $i <= $days_in_month; $i++) {
   			$days_so_far = $days_so_far + 1;
    			$count_boxes = $count_boxes + 1;
			IF($_GET['month'] == $todays_month+1){
				IF($i == $todays_date){
					$class = "highlighteddayboxes";
				} ELSEIF($count_boxes==6 || $count_boxes==7) {
					$class = "dayboxes-weekend";
				} ELSE {
					$class = "dayboxes";
				}
			} ELSE {
				IF($i == 1){
					$class = "highlighteddayboxes";
				} ELSEIF($count_boxes==6 || $count_boxes==7) {
					$class = "dayboxes-weekend";
				} ELSE {
					$class = "dayboxes";
				}
			}
			//susikonstruojam menesi
			$menesis = ($_GET['month']-1);
			if($menesis<10) {$menesis = str_pad($menesis, 2, "0", STR_PAD_LEFT);}

			//susikonstruojam diena
			$diena = $i;
			if($i<10) {$diena = str_pad($i, 2, "0", STR_PAD_LEFT);}

			//tikrinam ar diena aktyvi
			$langelio_data = $_GET['year'] ."-". $menesis ."-". $diena;

			echo "<td width=\"100\" height=\"100\" class=\"$class\"><a name=\"" . $langelio_data . "\"></a>\n";
			$link_month = $_GET['month'] - 1;

			$day_letter = get_day_letter($langelio_data);
			echo "<span class=\"toprightnumber\">$i<font size=\"-2\">($day_letter)</font></span><div align=\"right\">
			<a class=\"add\" href=\"?day=$i&amp;month=$link_month&amp;year=$_GET[year]\"><i class=\"glyphicon glyphicon-plus\"></i></a>";
			echo "<a class=\"show_day\" href=\"?day=$langelio_data\"><i class=\"glyphicon glyphicon-th-list\"></i></a>";

			if($admin){
				echo "<a class=\"add_day\" href=\"?day=$langelio_data\"><i class=\"glyphicon glyphicon-tag\"></i></a>";
			}
			echo "</div>";
			echo "<div align=\"left\"><div class=\"eventinbox\">\n";
			$spec_events = array("šventė", "talka", "kita", "svečiai");
			IF(isset($events[$i])){
				while (list($key, $value) = each ($events[$i])) {
				    $vardas = empty($event_info[$value][0]) ? NULL : $event_info[$value][0];
				    $title_full = $event_info[$value]['1'] . " " . $vardas;
				    if (!empty($vardas)) {
					$vardas = explode(' ', trim($vardas));
					if (count($vardas) > 0 && !empty($vardas[0]))
					    $vardas[0] = mb_substr($vardas[0], 0, 1) . '.';
					$vardas = implode(' ', $vardas);
				    }
					IF (in_array($event_info[$value]['0'], $spec_events)) {
						$title = $event_info[$value]['1'] . " " . $event_info[$value]['0'] . ": " . $event_info[$value]['2'];
						$event = $event_info[$value]['0'];
						echo "&nbsp;<a class=\"$event\" href=\"?id=$value\" title=\"" . $title_full . "\">" . $title  . "</a><br />";
					} else {
						$title = $event_info[$value]['1'] . " " . $vardas;
						echo "&nbsp;<a class=\"registracija\" href=\"?id=$value\" title=\"" . $title_full . "\">" . $title  . "</a><br />";
					}
				}
			}
			if (isset($dienos[$langelio_data]['reason'])){
				echo "<div class=\"" . $dienos[$langelio_data]['status'] . "\" align=\"center\">" . $dienos[$langelio_data]['reason'] . "</div>";
			}
			echo "</td>\n";

			IF(($count_boxes == 7) AND ($days_so_far != (($first_day_of_month-1) + $days_in_month))){
				$count_boxes = 0;
				echo "</TR><TR valign=\"top\">\n";
			}
			echo "</div></div>\n";
		}
		$extra_boxes = 7 - $count_boxes;
		for ($i = 1; $i <= $extra_boxes; $i++) {
			echo "<td width=\"100\" height=\"100\" class=\"afterdayboxes\"></td>\n";
		}
		$time_end = getmicrotime();
		$time = round($time_end - $time_start, 3);
		?>
        </tr>
      </table></td>
  </tr>
</table>
</div>
</body>
