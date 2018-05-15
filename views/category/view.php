<div class="page-header"><h1>Kategorja</h1></div>
<div class="row">
  <div class="col-md-8<?php echo !empty($results['category']->deleted) ? " bg-danger" : NULL?>">
    <?php echo !empty($results['category']->deleted) ? theme('display', 'reg_num', 'Ištrintas', $results['category']) : NULL ?>
    <?php echo theme('display', 'title', 'Pavadinimas', $results['category']) ?>
    <?php echo theme('display', 'description', 'Aprasymas', $results['category']) ?>
    <?php echo theme('display', 'ordering', 'Rikiavimas', $results['category']) ?>
  </div>

  <div class="col-md-4">

    <div class="panel panel-default">
      <div class="panel-heading">
	<h3 class="panel-title">Info</h3>
      </div>
      <div class="panel-body">
<?php if (UserHelper::has_permission()) { ?>
        <div class="buttons">
	  <a href="index.php?action=category&amp;view=Edit&amp;id=<?php echo $results['category']->id ?>" class="btn btn-sm btn-primary">Redaguoti</a>
<?php   if (!empty($results['category']->deleted)) { ?>
	  <a href="index.php?action=category&amp;view=Restore&amp;id=<?php echo $results['category']->id ?>" class="btn btn-success">Sugražinti</a>
<?php   } else { ?>
 	  <a class="btn btn-xs btn-danger" onclick="return confirm('Ar tikrai norite pašalinti kategorija <?php echo $results['category']->reg_num ?>?')" href="admin.php?action=category&amp;view=Delete&amp;id=<?php echo $results['category']->id ?>">Pašalinti</a>
<?php   } ?>
	</div>
<?php } ?>
      </div>
    </div>
  </div>
</div>
