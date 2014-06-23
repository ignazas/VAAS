<?php
$file = dirname(__FILE__) . "/../../uploads/meteo_paluknis.png";
if (!file_exists($file) || round(abs(time() - filemtime($file)) / 60, 2) > 10) { // min
   file_put_contents($file, file_get_contents('http://meteo.lt/dokumentai/operatyvi_inf/skaitmenine_prog/meteo_paluknis.png'));
}
?>
<div class="col-md-8">
  <h2>Orų prognozė</h2>
<?php //<img src="http://meteo.lt/dokumentai/operatyvi_inf/skaitmenine_prog/meteo_paluknis.png" alt="Skaitmeninė Paluknio orų prognozė" /> ?>
  <img class="img-responsive" src="/<?php echo CATALOG ?>/uploads/meteo_paluknis.png" alt="Skaitmeninė Paluknio orų prognozė" />
  <a href="http://meteo.lt/skaitmenine_prog_lt_zem.php?skpt=lt_krit" target="_blank">Daugiau</a>
</div>
