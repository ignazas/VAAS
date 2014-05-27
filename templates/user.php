<?php require "common.php" ?>
<?php require "secure.php" ?>
<?php include "templates/include/header.php" ?>
<?php include "templates/include/top-menu.php" ?>

<div class="container">
    <?php include "templates/include/messages.inc" ?>
    <?php include "templates/include/errors.inc" ?>

	<div class="page-header"><h1>Vartotojo nustatymai</h1></div>
      	<div class="row">
    	
        <form action="index.php?action=user" method="post" id="user_edit" enctype= "multipart/form-data">
	<div class="col-md-4">	
        <img src="<?php echo empty($user->avatar) ? 'images/users/avatar.jpg' : "uploads/users/$user->avatar" ?>" style="width: 150px; height: 150px;" class="img-thumbnail" alt="150x150 Foto">
        <input type="file" name="avatar" id="avatar" value="Įkelti" /><br />
                    <?php echo theme('display', 'usertype', 'Vartotojo tipas', $user, $edit) ?>
                    <?php echo theme('display', 'registerDate', 'Užsiregistravo', $user, $edit) ?>
                    <?php echo theme('display', 'lastvisitDate', 'Paskutinis apsilankymas', $user, $edit) ?>
            	</div>
            <div class="col-md-4">
                <fieldset>
                    <legend>Pagrindinė informacija:</legend>
                    <?php echo theme('text', 'name', 'Vardas', $user, $edit) ?>
                    <?php echo theme('email', 'email', 'El. paštas', $user, $edit) ?>
                    <?php echo theme('text', 'telephone1', 'Telefonas', $user, $edit) ?>
                    <?php echo theme('url', 'website', 'Interneto svetainė', $user, $edit) ?>
                </fieldset>
		</div>
		<div class="col-md-4">
                <fieldset>
                    <legend>Slaptažodis:</legend>
                    <?php echo theme('password', 'password', 'Senas', $user, array('password' => '')) ?>
                    <?php echo theme('password', 'new_password_1', 'Naujas', $user, $edit) ?>
                    <?php echo theme('password', 'new_password_2', 'Pakartoti', $user, $edit) ?>
                </fieldset>
            </div>
            </div>
            <div class="buttons">
                <input type="submit" class="btn btn-sm btn-primary" value="Saugoti" />
            </div>   
        </form>
    </div>

  
	
		
	</div> <!-- /container -->



        



<?php include "templates/include/footer.php" ?>