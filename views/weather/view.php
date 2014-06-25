<div class="page-header"><h1>Orai</h1></div>

<h2>Faktinis oras</h2>
<table class="table">
  <thead>
     <th>Pavadinimas</th>
     <th>Reišmė</th>
  </thead>
  <tbody>
<?php if (!empty($this->data)) foreach ($this->data as $match) { ?>
<?php
$title = $match[1];
$value_index = 3;
switch ($title) {
  case "Outside Temp": $title = 'Temperatūra'; break;
  case "Outside Humidity": $title = 'Drėgmė'; break;
  case "Inside Temp": $value_index = NULL; break;
  case "Inside Humidity": $value_index = NULL; break;
  case "Heat Index": $title = 'Šilumos rodiklis (heat index)'; break;
  case "Wind Chill": $title = 'Vėjo žvarba'; break;
  case "Dew Point": $title = 'Rasos taškas'; break;
  case "Barometer": $title = 'Slėgis'; break;
  case "Bar Trend": $title = 'Slėgio tendencija (bar trend)'; break;
  case "Wind Speed": $title = 'Vėjo greitis'; break;
  case "Wind Direction": $title = 'Vėjo kryptis'; break;
  case "12 Hour Forecast": $title = '12 val prognozė'; $value_index = 8; break;
  case "Rain": $title = 'Lietus'; break;
  case "Average Wind Speed": $title = 'Vidutinis vėjo greitis'; $value_index = 4; break;
  case "Wind Gust Speed": $title = 'Gūsiai'; $value_index = 4; break;
  case "Last Hour Rain": $title = 'Lietus per paskutinę val'; break;
}
if (empty($value_index) || empty($match[$value_index]) || $match[$value_index] == '&nbsp;' || $match[$value_index] == 'n/a')
  continue;
?>
    <tr>
      <td><?php echo $title ?></td>
      <td><?php echo $match[$value_index] ?></td>
    </tr>
<?php } ?>
  </tbody>
</table>

<?php if (!empty($this->prognosis)) { ?>
<h2>Orų prognozė</h2>
<img class="img-responsive" src="<?php echo $this->prognosis ?>" alt="Skaitmeninė Paluknio orų prognozė" />
<a href="http://meteo.lt/skaitmenine_prog_lt_zem.php?skpt=lt_krit" target="_blank">Daugiau</a>
<?php } ?>
