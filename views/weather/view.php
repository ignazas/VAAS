<?php
function weather_view_get_value($match, $value_index, $translate = FALSE) {
  if (empty($value_index) || empty($match[$value_index]) || $match[$value_index] == '&nbsp;' || $match[$value_index] == 'n/a')
    return FALSE;
  /*if ($translate === TRUE) {
    require_once dirname(__FILE__) . '/../../helpers/translate.inc';
    return Translate::t($match[$value_index]);
    }*/
  return $match[$value_index];
}
?>
<div class="page-header"><h1>Orai</h1></div>

<h2>Faktinis oras</h2>
<?php if (!empty($this->data_time)) { ?>
<?php   if ((time() - $this->data_time) / 60 < 10) { ?>
<p class="text-info">Informacija atnaujinta: <?php echo date('Y-m-d H:i', $this->data_time) ?></p>
<?php   } else { ?>
<p class="text-danger">Informacija pasenusi: <?php echo date('Y-m-d H:i', $this->data_time) ?></p>
<?php   } ?>
<?php } else { ?>
<p class="text-danger">Informacija pasenusi</p>
<?php } ?>

<table class="table">
  <thead>
     <th>Pavadinimas</th>
     <th>Reišmė</th>
  </thead>
  <tbody>

<?php if (!empty($this->data)) foreach ($this->data as $match) { ?>
<?php
$title = $match[1];
$value = NULL;
switch ($title) {
  case "Outside Temp": $title = 'Temperatūra'; $value = weather_view_get_value($match, 3); break;
  case "Outside Humidity": $title = 'Drėgmė'; $value = weather_view_get_value($match, 3); break;
  case "Inside Temp": break;
  case "Inside Humidity": break;
  case "Heat Index": $title = 'Šilumos rodiklis (heat index)'; $value = weather_view_get_value($match, 3); break;
  case "Wind Chill": $title = 'Vėjo žvarba'; $value = weather_view_get_value($match, 3); break;
  case "Dew Point": $title = 'Rasos taškas'; $value = weather_view_get_value($match, 3); break;
  case "Barometer": $title = 'Slėgis'; $value = weather_view_get_value($match, 3); break;
  case "Bar Trend": $title = 'Slėgio tendencija (bar trend)'; $value = weather_view_get_value($match, 3, TRUE); break;
  case "Wind Speed": $title = 'Vėjo greitis'; $value = weather_view_get_value($match, 3); break;
  case "Wind Direction": $title = 'Vėjo kryptis'; $value = weather_view_get_value($match, 3); break;
  case "12 Hour Forecast": $title = '12 val prognozė'; $value = weather_view_get_value($match, 8, TRUE); break;
  case "Rain": $title = 'Lietus'; $value = weather_view_get_value($match, 3); break;
  case "Average Wind Speed": $title = 'Vidutinis vėjo greitis'; $value = weather_view_get_value($match, 4); break;
  case "Wind Gust Speed": $title = 'Gūsiai'; $value = weather_view_get_value($match, 4); break;
  case "Last Hour Rain": $title = 'Lietus per paskutinę val'; $value = weather_view_get_value($match, 3); break;
}
if (empty($value))
  continue;
?>
    <tr>
      <td><?php echo $title ?></td>
      <td><?php echo $value ?></td>
    </tr>
<?php } ?>
  </tbody>
</table>

<?php if (!empty($this->prognosis)) { ?>
<h2>Orų prognozė</h2>
<img class="img-responsive" src="<?php echo $this->prognosis ?>" alt="Skaitmeninė Paluknio orų prognozė" />
<ol>
  <li>Mėlyni (lietaus) arba purpuriniai (sniego) stulpeliai rodo kritulių kiekį per 1 val. Kritulių skalė yra kairėje pusėje (matavimo vienetai - mm/1 val.).</li>
  <li>Oranžinės spalvos linija rodo vidutinį vėjo greitį. Vėjo greičio skalė yra kairėje pusėje (matavimo vienetai - m/s). Melsva spalva vaizduojami vėjo gūsiai (m/s). Rodyklės rodo vėjo kryptį.</li>
  <li>Raudona linija rodo oro temperatūrą 2 m aukštyje. Mėlyna linija pavaizduota rasos taško temperatūra. Temperatūros skalė yra kairėje pusėje (matavimo vienetai - <sup>o</sup>C).</li>
  <li>Pilka linija rodo slėgį jūros lygyje. Slėgio skalė yra kairėje pusėje (matavimo vienetai - hPa).</li>
</ol>
<a class="btn btn-default" href="http://meteo.lt/skaitmenine_prog_lt_zem.php?skpt=lt_krit" target="_blank">Krituliai</a>
<a class="btn btn-default" href="http://meteo.lt/skaitmenine_prog_lt_zem.php?skpt=lt_vej" target="_blank">Vėjas</a>
<a class="btn btn-default" href="http://meteo.lt/radaro_inf.php" target="_blank">Radaro informacija</a>
<?php } ?>
