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
                    <?php echo theme('display', 'email', 'El. paštas', $user) ?>
                    <?php echo theme('display', 'telephone1', 'Telefonas', $user) ?>
                    <?php echo theme('display', 'website', 'Interneto svetainė', $user) ?>
                </fieldset>
		</div>
            </div>
            <div class="buttons">
                <a href="index.php?action=user&amp;view=Edit" class="btn btn-sm btn-primary">Redaguoti</a>
            </div>
    </div>
