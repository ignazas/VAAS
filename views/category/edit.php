<?php $edit = array_merge((array)$results['category'], $_POST) ?>

<form class="form-horizontal" action="" method="POST">
  <input type="hidden" name="id" value="<?php echo $results['category']->id ?>" />
  <fieldset>

    <!-- Form Name -->
    <legend><?php echo $results['pageTitle'] ?></legend>

    <div class="form-group">
    <?php echo theme('text', 'title', 'Pavadinimas', $results['category'], $edit) ?>
    <?php echo theme('text', 'description', 'Aprasymas', $results['category'], $edit) ?>
    <?php echo theme('text', 'ordering', 'Rikiavimas', $results['category'], $edit) ?>
    </div>

    <!-- Button -->
    <div class="buttons">
      <input type="submit" class="btn btn-sm btn-primary" name="saveChanges" value="Saugoti" />
      <a href="index.php?action=category" class="btn btn-sm">Atšaukti</a>
    </div>

  </fieldset>
</form>
