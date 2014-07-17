<div class="page-header"><h1>Vartotojo nustatymai</h1></div>

<div class="row">
  <div class="col-md-4">
    <img src="<?php echo empty($user->avatar) ? 'images/users/avatar.jpg' : "uploads/users/$user->avatar" ?>" style="width: 150px; height: 150px;" class="img-thumbnail" alt="150x150 Foto">

    <?php echo theme('display', 'usertype', 'Vartotojo tipas', $user) ?>
    <?php echo theme('display', 'registerDate', 'Užsiregistravo', $user) ?>
    <?php echo theme('display', 'lastvisitDate', 'Paskutinis apsilankymas', $user) ?>
  </div>
  <div class="col-md-4">
    <fieldset>
      <legend>Pagrindinė informacija:</legend>
      <?php echo theme('display', 'name', 'Vardas', $user) ?>
      <?php echo theme('display_email', 'email', 'El. paštas', $user) ?>
      <?php echo theme('display_phone', 'telephone1', 'Telefonas', $user) ?>
      <?php echo theme('display_url', 'website', 'Interneto svetainė', $user) ?>
    </fieldset>
  </div>
</div>

<?php if (UserHelper::has_permission() || (!empty($_SESSION['user']['id']) && $_SESSION['user']['id'] == $user->id)) { ?>
<div class="buttons">
  <a href="index.php?action=user&amp;view=Edit&amp;id=<?php echo $user->id ?>" class="btn btn-sm btn-primary">Redaguoti</a>
</div>
<?php } ?>
