<?php
$file = dirname(__FILE__) . "/../../uploads/meteo_trakai.png";
if (!file_exists($file) || round(abs(time() - filemtime($file)) / 60, 2) > 10) { // min
   file_put_contents($file, file_get_contents('http://meteo.lt/dokumentai/operatyvi_inf/skaitmenine_prog/meteo_trakai.png'));
}
?>
<div class="col-md-8">
  <h2>Orų prognozė</h2>
  <img class="img-responsive" src="/<?php echo CATALOG ?>/uploads/meteo_trakai.png" alt="Skaitmeninė Trakų orų prognozė" />
  <a href="http://meteo.lt/skaitmenine_prog_lt_zem.php?skpt=lt_krit" target="_blank">Daugiau</a>
</div>
