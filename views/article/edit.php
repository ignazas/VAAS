<div class="page-header"><h1>Redaguoti pranešimą</h1></div>

<div class="col-md-8">
  <form role="form" action="" method="post">
    <input type="hidden" name="articleId" value="<?php echo $results['article']->id ?>"/>
    <input type="hidden" name="publicationDate" id="publicationDate" value="<?php echo date("Y-m-d");?>"><br />

    <div class="form-group">
      <label for="title">Pavadinimas</label>
      <input type="text" name="title" id="title" class="form-control input-lg" placeholder="Pavadinimas" value="<?php echo htmlspecialchars( $results['article']->title )?>">
    </div>
    <div class="form-group">
      <label for="summary">Santrumpa</label>
      <textarea name="summary" id="summary" class="form-control" rows="3" placeholder="Santrumpa"><?php echo $results['article']->summary ?></textarea>
    </div>
    <div class="form-group">
      <label for="content">Pranešimas</label>
      <textarea name="content" id="content" class="form-control ritchtext" rows="15" placeholder="Pranešimas"><?php echo $results['article']->content ?></textarea>
    </div>
    <button type="submit" name="saveChanges" class="btn btn-primary">Išsaugoti</button>
    <a href="admin.php?action=article&amp;view=AdminItemList" class="btn">Atšaukti</a>
  </form>
</div>

<?php if ( $results['article']->id ) { ?>
<div class="col-md-4">
  <div class="panel panel-danger">
    <div class="panel-heading">
      <h3 class="panel-title">Administravimas</h3>
    </div>
    <div class="panel-body">
      <p><a href="admin.php?action=Article&amp;view=Delete&amp;articleId=<?php echo $results['article']->id ?>" onclick="return confirm('Ar tikrai norite pašalinti pranešimą?')">Pašalinti pranešimą.</a></p>
    </div>
  </div>
</div>
<?php } ?>
