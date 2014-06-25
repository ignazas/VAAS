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
switch ($title) {
  case "Outside Temp": $title = 'Temperatūra'; break;
  case "Outside Humidity": $title = 'Drėgmė'; break;
  case "Inside Temp": $title=NULL; break;
  case "Inside Humidity": $title=NULL; break;
  case "Heat Index": $title = 'Šilumos rodiklis (heat index)'; break;
  case "Wind Chill": $title = 'Vėjo žvarba'; break;
  case "Dew Point": $title = 'Rasos taškas'; break;
  case "Barometer": $title = 'Slėgis'; break;
  case "Bar Trend": $title = 'Slėgio tendencija (bar trend)'; break;
  case "Wind Speed": $title = 'Vėjo greitis'; break;
  case "Wind Direction": $title = 'Vėjo kryptis'; break;
  case "12 Hour Forecast": $title = '12 val prognozė'; break;
  case "Rain": $title = 'Lietus'; break;
  case "Average Wind Speed": $title = 'Vidutinis vėjo greitis'; break;
  case "Wind Gust Speed": $title = 'Gūsiai'; break;
  case "Last Hour Rain": $title = 'Lietus per paskutinę val'; break;
}
?>
<?php   if (!empty($title) && !empty($match[3]) && $match[3] != '&nbsp;' && $match[3] != 'n/a') { ?>
    <tr>
      <td><?php echo $title ?></td>
      <td><?php echo $match[3] ?></td>
    </tr>
<?php   } elseif (!empty($title) && !empty($match[8]) && $match[8] != '&nbsp;' && $match[8] != 'n/a') { ?>
    <tr>
      <td><?php echo $title ?></td>
      <td><?php echo $match[8] ?></td>
    </tr>
<?php   } ?>
<?php } ?>
  </tbody>
</table>

<?php if (!empty($this->prognosis)) { ?>
<h2>Orų prognozė</h2>
<img class="img-responsive" src="<?php echo $this->prognosis ?>" alt="Skaitmeninė Paluknio orų prognozė" />
<a href="http://meteo.lt/skaitmenine_prog_lt_zem.php?skpt=lt_krit" target="_blank">Daugiau</a>
<?php } ?>
