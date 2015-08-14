<?php $edit = array_merge((array)$results['aircraft'], $_POST) ?>

<form class="form-horizontal" action="" method="POST">
  <input type="hidden" name="id" value="<?php echo $results['aircraft']->id ?>" />
  <fieldset>

    <!-- Form Name -->
    <legend><?php echo $results['pageTitle'] ?></legend>

    <div class="form-group">
    <?php echo theme('text', 'reg_num', 'Registracijos numeris', $results['aircraft'], $edit) ?>
    <?php echo theme('text', 'name', 'Modelis', $results['aircraft'], $edit) ?>
    <?php echo theme('text', 'serial_num', 'Serijinis numeris', $results['aircraft'], $edit) ?>
    <?php echo theme('text', 'first_pilot', 'Pirmas pilotas', $results['aircraft'], $edit) ?>
    <?php echo theme('text', 'second_pilot', 'Antras pilotas', $results['aircraft'], $edit) ?>
    <?php echo theme('text', 'third_pilot', 'Trečias pilotas', $results['aircraft'], $edit) ?>
    <?php echo theme('text', 'remarks', 'Pastabos', $results['aircraft'], $edit) ?>

    <?php echo theme('decimal', 'time_since_new', 'Praskrista iš viso', $results['aircraft'], $edit) ?>
    <?php echo theme('decimal', 'flights_since_new', 'Skrydžių kiekis iš viso', $results['aircraft'], $edit) ?>

    <!--<?php echo theme('date', 'moh_date', 'MOH', $results['aircraft'], $edit) ?>-->
    <!--<?php echo theme('decimal', 'time_since_mo', 'Laikas nuo MO', $results['aircraft'], $edit) ?>-->
    <!--<?php echo theme('decimal', 'flights_since_mo', 'Skrydžių nuo MO', $results['aircraft'], $edit) ?>-->

    <?php echo theme('decimal', 'time_left', 'Laiko liko', $results['aircraft'], $edit) ?>
    <?php echo theme('decimal', 'flights_left', 'Skrydžių liko', $results['aircraft'], $edit) ?>

    <?php echo theme('decimal', 'time_last_year', 'Praskrista pernai', $results['aircraft'], $edit) ?>
    <?php echo theme('decimal', 'flights_last_year', 'Skrydžių kiekis pernai', $results['aircraft'], $edit) ?>

    <?php echo theme('date', 'coa_expiry_date', 'Tinkamumas baigiasi', $results['aircraft'], $edit) ?>
    <?php echo theme('date', 'civ_insur_expiry_date', 'Civilinis draudimas baigiasi', $results['aircraft'], $edit) ?>
    <?php echo theme('date', 'kasko_insur_expiry_date', 'Kasko draudimas baigiasi', $results['aircraft'], $edit) ?>

    <?php echo theme('date', 'manuf_date', 'Pagaminimo data', $results['aircraft']) ?>
    </div>

    <!-- Button -->
    <div class="buttons">
      <input type="submit" class="btn btn-sm btn-primary" name="saveChanges" value="Saugoti" />
      <a href="index.php?action=aircraft" class="btn btn-sm">Atšaukti</a>
    </div>

  </fieldset>
</form>
