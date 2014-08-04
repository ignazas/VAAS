<?php
?>

<div class="page-header"><h1>Skrydžių analizė</h1></div>
<div class="row">
  <div class="col-md-8">
    <?php echo isset($results['google_maps_code']) ? $results['google_maps_code'] : NULL; ?>
  </div>

  <div class="col-md-4">

    <div class="panel panel-default">
      <div class="panel-heading">
	<h3 class="panel-title">Info</h3>
      </div>
      <div class="panel-body">
	<p>Čia yra talpinami Jūsų skrydžių analizės failai (*.igc).</p>
<?php if (!empty($results['files'])) { ?>
	<ul class="list-group">
<?php   foreach ($results['files'] as $f) { ?>
          <li class="list-group-item<?php echo $file == $f ? ' list-group-item-success' : NULL ?>"><a href="?action=analysis&amp;file=<?php echo urlencode(basename($f, '.igc')) ?>"><?php echo basename($f, '.igc') ?></a> <a href="?action=analysis&amp;view=Delete&amp;file=<?php echo urlencode(basename($f, '.igc')) ?>"><i class="glyphicon glyphicon-remove"></i></a></li>
<?php   } ?>
	</ul>
<?php } ?>
        <form action="" method="post" enctype="multipart/form-data">
	  <input type="file" id="file" name="files[]" multiple="multiple" />
	  <input type="submit" value="Įkelti" />
	</form>
      </div>
    </div>
  </div>
</div>
