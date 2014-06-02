<?php if (!empty($elements['calendar']['results']) && is_array($elements['calendar'])) { ?>

<div class="col-xs-6 col-md-6" id="dienos">
  <link href="css/cal.css" rel="stylesheet" type="text/css">
  <div id="registracija"></div>
  <div id="registruotis"></div>
  <h2>Šiandien skrenda <a class="add" href="?day=<?php echo date('j', time()) ?>&amp;month=<?php echo date('n', time()) ?>&amp;year=<?php echo date('Y', time()) ?>"><i class="glyphicon glyphicon-plus"></i></a></h2>
  <ul>
    <?php foreach ($elements['calendar']['results'] as $event) { ?>
    <li><a class="registracija" href="?id=<?php echo $event->event_id ?>" title="<?php echo $event->event_title ?>"><?php echo $event->event_time ?> <?php echo $event->event_title ?></a></li>
    <?php } ?>
  </ul>
</div>

<?php } ?>
