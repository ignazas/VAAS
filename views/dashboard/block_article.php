<?php if (isset($elements['article']) && is_array($elements['article']) && !empty($elements['article'])) { ?>

<div class="col-md-6">
  <h2>Pranešimai</h2>
  <?php foreach ($elements['article']['results'] as $article) { ?>
  <div class="panel panel-default">
    <div class="panel-heading">
      <h3 class="panel-title">
	<strong><a href="index.php?action=Article&amp;view=View&amp;articleId=<?php echo $article->id?>"><?php echo htmlspecialchars( $article->title )?></a></strong>
      </h3>
    </div>
    <div class="panel-body">
      <font size="-2"><?php echo date('Y-m-d', $article->publicationDate)?></font>
      <p class="summary"><?php echo htmlspecialchars( $article->summary )?>...</p>
      <div align="right"><p><a href="index.php?action=article&amp;view=View&amp;articleId=<?php echo $article->id?>">[Skaityti daugiau]</a></p></div>
    </div>
  </div>
  <?php } ?>
</div>
<?php } ?>
