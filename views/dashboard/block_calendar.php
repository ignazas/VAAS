<?php if (!empty($elements['calendar']['events']['results']) || !empty($elements['calendar']['days']['results'])) { ?>

<div class="col-md-6" id="dienos">
  <link href="css/cal.css" rel="stylesheet" type="text/css">
  <div id="registracija"></div>
  <div id="registruotis"></div>
  <h2>Šiandien skrenda</h2>
  <ul class="list-group">
    <?php foreach ($elements['calendar']['events']['results'] as $event) { $title = $event->event_time . ' ' . ($event->event_type != 'registracija' ? $event->event_desc : $event->event_title); ?>
    <li class="list-group-item">
      <a class="<?php echo $event->event_type ?>" href="?id=<?php echo $event->event_id ?>" title="<?php echo $title ?>"><?php echo $title ?></a>
<?php if ($event->event_type != 'registracija') { ?>
      <span class="badge"><?php echo $event->event_type ?></span>
<?php } ?>
    </li>
    <?php } ?>
    <?php foreach ($elements['calendar']['days']['results'] as $day) { ?>
    <li class="<?php echo $day->status ?> alert <?php echo $day->status == 'nevyksta' ? 'alert-danger' : 'alert-info' ?>"><?php echo $day->reason ?></li>
    <?php } ?>
  </ul>
  <div class="buttons">
    <a class="add btn btn-sm btn-primary" href="?day=<?php echo date('j', time()) ?>&amp;month=<?php echo date('n', time()) ?>&amp;year=<?php echo date('Y', time()) ?>"><i class="glyphicon glyphicon-plus"></i> Šiandien</a>
    <!-- <a class="add btn btn-sm" href="?day=<?php echo date('j', strtotime('+1 day')) ?>&amp;month=<?php echo date('n', strtotime('+1 day')) ?>&amp;year=<?php echo date('Y', strtotime('+1 day')) ?>"><i class="glyphicon glyphicon-plus"></i> Rytoj</a> -->
  </div>
</div>

<?php } ?>
