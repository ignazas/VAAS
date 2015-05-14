<div class="page-header"><h1>Pranešimai</h1></div>

<div class="col-md-8">
  <?php foreach ( $results['articles'] as $article ) { ?>
  <div class="panel panel-default">
    <div class="panel-heading">
      <h3 class="panel-title">
	<strong><a href="index.php?action=article&amp;view=View&amp;articleId=<?php echo $article->id?>"><?php echo htmlspecialchars( $article->title )?></a></strong>
      </h3>
    </div>
    <div class="panel-body">
      <font size="-2"><?php echo date('Y-m-d', $article->publicationDate)?></font>
      <p class="summary"><?php echo htmlspecialchars( $article->summary )?>...</p>
      <div align="right"><p><a href="index.php?action=article&amp;view=View&amp;articleId=<?php echo $article->id?>">[Skaityti daugiau]</a></p></div>

<?php if (UserHelper::has_permission('publish')) { ?>
      <div class="buttons">
	<a href="index.php?action=article&amp;view=Notify&amp;id=<?php echo $article->id ?>&amp;receivers=flying_today" class="btn btn-sm btn-default"><i class="glyphicon glyphicon-envelope"></i> Skr. šiandien</a>
 	<a href="index.php?action=article&amp;view=Notify&amp;id=<?php echo $article->id ?>&amp;receivers=flying_tomorrow" class="btn btn-sm btn-default"><i class="glyphicon glyphicon-envelope"></i> Skr. rytoj</a>
	<a href="index.php?action=article&amp;view=Notify&amp;id=<?php echo $article->id ?>&amp;receivers=all" class="btn btn-sm btn-default"><i class="glyphicon glyphicon-envelope"></i> Visiems</a>
      </div>
<?php } ?>
    </div>
  </div>

  <?php } ?>



</div>
<div class="col-md-4">


  <div class="panel panel-default">
    <div class="panel-heading">
      <h3 class="panel-title">Info</h3>
    </div>
    <div class="panel-body">
      <p>Čia yra talpinama visa vidinė informacija klubo nariams.</p>
      <p></p>
    </div>
  </div>


</div>
