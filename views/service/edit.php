<div class="page-header"><h1>Paslauga</h1></div>

<form class="form-horizontal" action="" method="POST" role="form">
  <input id="id" name="id" type="hidden" value="<?php echo $results['service']->id ?>">
  <fieldset>

    <!-- Form Name -->
    <legend><?php echo $results['pageTitle'] ?></legend>

    <!-- Text input-->
    <div class="form-group">
      <?php echo theme('checkbox', 'is_flight', 'Ar skrydis', $results['service'], $edit) ?>
    </div>
    <div class="form-group">
      <label for="title">Pavadinimas</label>
      <input id="title" name="title" class="form-control" type="text" maxlength="256" value="<?php echo $results['service']->title ?>">
    </div>
    <div class="form-group">
      <label for="description">Aprašymas</label>
      <input id="description" name="description" class="form-control" maxlength="256" type="text" value="<?php echo $results['service']->description ?>">
    </div>
    <div class="form-group">
      <label for="amount">Kaina,&#160;€</label>
      <input id="amount" name="amount" class="form-control" type="number" step="any" value="<?php echo $results['service']->amount ?>">
    </div>
    <div class="form-group">
      <label for="unit">Kainos papildomi vienetai</label>
      <input id="unit" name="unit" class="form-control" type="text" value="<?php echo $results['service']->unit ?>">
    </div>
    <div class="form-group">
      <label for="amount_unit">Papildoma kaina už vienetą,&#160;€</label>
      <input id="amount_unit" name="amount_unit" class="form-control" type="number" step="any" value="<?php echo $results['service']->amount_unit ?>">
    </div>
    <div class="form-group">
      <?php echo theme('checkbox', 'is_price_for_duration', 'Ar kaina už skrydžio laiką', $results['service'], $edit) ?>
    </div>
    <div class="form-group">
      <label for="amount">Mokestis instruktoriui,&#160;€</label>
      <input id="price_for_instructor" name="price_for_instructor" class="form-control" type="number" step="any" value="<?php echo $results['service']->price_for_instructor ?>">
    </div>
    <div class="form-group"<?php if (!$this->HasPermission('Flight Manager') && !$isOwner) echo ' disabled="disabled"'; ?>>
      <?php $d = isset($_POST['default_duration']) ? $_POST['default_duration'] : (isset($results['service']->default_duration) ? floatval($results['service']->default_duration) : NULL); ?>
      <?php echo theme('time', 'default_duration', 'Trukmė pagal nutylėjimą', $results['service'], array('default_duration' => $d)) ?>
    </div>
    <div class="checkbox form-group">
      <label for="is_discount">
	    <input id="is_discount" name="is_discount" type="checkbox" value="1" <?php if (!empty($results['service']->is_discount)) echo 'checked="checked"' ?>> Nuolaida taikoma
      </label>
    </div>

    <div class="buttons">
      <input type="submit" class="btn btn-sm btn-primary" name="saveChanges" value="Saugoti" />
      <a href="index.php?action=service" class="btn btn-sm">Atšaukti</a>
    </div>

  </fieldset>
</form>
