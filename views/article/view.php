<div class="page-header"><h1>Pranešimai</h1></div>
<div class="col-md-8">
  <h2 style="width: 75%;"><?php echo htmlspecialchars( $results['article']->title )?></h2>
  <p class="pubDate">Paskelbta <i><?php echo date('Y-m-d', $results['article']->publicationDate)?></i></p>
  <?php echo $results['article']->content ?>
</div>

<div class="col-md-4">
  <div class="panel panel-default">
    <div class="panel-heading">
      <h3 class="panel-title">Info</h3>
    </div>
    <div class="panel-body">
      <p>Čia yra talpinama visa vidinė informacija klubo nariams.</p>
      <p>Visi šie pranešimai buvo automatiškai išsiųsti nariams el. paštu.</p>
<?php if (UserHelper::has_permission()) { ?>
      <div class="buttons">
	<a href="index.php?action=article&amp;view=Edit&amp;id=<?php echo $results['article']->id ?>" class="btn btn-sm btn-primary">Redaguoti</a>

	<a href="index.php?action=article&amp;view=Notify&amp;id=<?php echo $results['article']->id ?>&amp;receivers=flying_today" class="btn btn-sm btn-default"><i class="glyphicon glyphicon-envelope"></i> Skr. šiandien</a>
 	<a href="index.php?action=article&amp;view=Notify&amp;id=<?php echo $results['article']->id ?>&amp;receivers=flying_tomorrow" class="btn btn-sm btn-default"><i class="glyphicon glyphicon-envelope"></i> Skr. rytoj</a>
	<a href="index.php?action=article&amp;view=Notify&amp;id=<?php echo $results['article']->id ?>&amp;receivers=all" class="btn btn-sm btn-default"><i class="glyphicon glyphicon-envelope"></i> Visiems</a>
	<a href="index.php?action=article&amp;view=Notify&amp;id=<?php echo $results['article']->id ?>&amp;receivers=me" class="btn btn-sm btn-default"><i class="glyphicon glyphicon-envelope"></i> Man</a>
      </div>
<?php } ?>
    </div>
  </div>
</div>
