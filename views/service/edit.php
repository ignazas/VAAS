<div class="page-header"><h1>Paslauga</h1></div>

<form class="form-horizontal" action="" method="POST" role="form">
  <input id="id" name="id" type="hidden" value="<?php echo $results['service']->id ?>">
  <fieldset>

    <!-- Form Name -->
    <legend><?php echo $results['pageTitle'] ?></legend>

    <!-- Text input-->
    <div class="form-group">
      <label for="title">Pavadinimas</label>
      <input id="title" name="title" class="form-control" type="text" maxlength="256" value="<?php echo $results['service']->title ?>">
    </div>
    <div class="form-group">
      <label for="description">Aprašymas</label>
      <input id="description" name="description" class="form-control" maxlength="256" type="text" value="<?php echo $results['service']->description ?>">
    </div>
    <div class="form-group">
      <label for="amount">Kaina, Lt</label>
      <input id="amount" name="amount" class="form-control" type="number" value="<?php echo $results['service']->amount ?>">
    </div>
    <div class="checkbox form-group">
      <label for="discount_disabled">
	<input id="discount_disabled" name="discount_disabled" type="checkbox" value="1" <?php if (!empty($results['service']->discount_disabled)) echo 'checked="checked"' ?>> Nuolaida netaikoma
      </label>
    </div>

    <div class="buttons">
      <input type="submit" class="btn btn-sm btn-primary" name="saveChanges" value="Saugoti" />
      <a href="index.php?action=service" class="btn btn-sm">Atšaukti</a>
    </div>

  </fieldset>
</form>