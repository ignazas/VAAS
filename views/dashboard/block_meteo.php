<?php
$file = dirname(__FILE__) . "/../../uploads/meteo_trakai.png";
if (!file_exists($file) || round(abs(time() - filemtime($file)) / 60, 2) > 30) { // min
  $opts = array('http' => array(
            'method'  => 'GET',
            'timeout' => 5
          )
  );
  $context  = stream_context_create($opts);
  $content = @file_get_contents('http://meteo.lt/dokumentai/operatyvi_inf/skaitmenine_prog/meteo_trakai.png', false, $context, -1);
  if (!empty($content))
    file_put_contents($file, $content);
}
?>

<?php if (file_exists($file)) { ?>
<div class="row">
  <h2>Orų prognozė</h2>
  <a href="index.php?action=weather"><img class="img-responsive" src="/<?php echo CATALOG ?>/uploads/meteo_trakai.png" alt="Skaitmeninė Trakų orų prognozė" /><a>
</div>
<?php } ?>