<div class="page-header"><h1>Vartotojo nustatymai</h1></div>

<div class="row">
  <div class="col-md-4">
    <img src="<?php echo empty($user->avatar) ? 'images/users/avatar.jpg' : "uploads/users/$user->avatar" ?>" style="width: 150px; height: 150px;" class="img-thumbnail" alt="150x150 Foto">

    <?php echo theme('display', 'usertype', 'Vartotojo tipas', $user) ?>
    <?php echo theme('display', 'registerDate', 'Užsiregistravo', $user) ?>
    <?php echo theme('display', 'lastvisitDate', 'Paskutinis apsilankymas', $user) ?>
    <?php echo theme('display_checkbox', 'instructor', 'Instruktorius', $user) ?>
    <?php echo theme('display_percent', 'discount', 'Nuolaida', $user) ?>
  </div>
  <div class="col-md-4">
    <fieldset>
      <legend>Pagrindinė informacija:</legend>
      <?php echo theme('display', 'name', 'Vardas', $user) ?>
      <?php echo theme('display_email', 'email', 'El. paštas', $user) ?>
      <?php echo theme('display_phone', 'telephone1', 'Telefonas', $user) ?>
      <?php echo theme('display_url', 'website', 'Interneto svetainė', $user) ?>
      <?php echo theme('display', 'licenseNo', 'Licencijos numeris', $user) ?>
      <?php echo theme('display_date_only', 'licenseValidTill', 'Licencija galioja iki', $user) ?>
      <?php echo theme('display', 'healthNo', 'Sveikatos paž. numeris', $user) ?>
      <?php echo theme('display_date_only', 'healthValidTill', 'Sveikatos paž. galioja iki', $user) ?>
    </fieldset>
  </div>
</div>

<?php if (UserHelper::has_permission() || (!empty($_SESSION['user']['id']) && $_SESSION['user']['id'] == $user->id)) { ?>
<div class="buttons">
  <a class="btn btn-sm btn-primary" href="index.php?action=user&amp;view=Edit&amp;id=<?php echo $user->id ?>">Redaguoti</a>
<?php  if (UserHelper::has_permission()) { ?>
  <a class="btn btn-xs btn-danger" onclick="return confirm('Ar tikrai norite pašalinti įrašą <?php echo $user->name ?>?')" href="index.php?action=user&amp;view=Delete&amp;id=<?php echo $user->id ?>">Pašalinti</a>
<?php  } ?>
</div>
<?php } ?>
