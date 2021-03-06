<?php
if (session_id() == '') session_start();

if (isset($_POST['action']) && $_POST['action'] == 'reset' &&
    ($username = !empty($_POST['username']) ? $_POST['username'] : NULL)) {

    require_once dirname(__FILE__) . '/../models/user.inc';
    require_once dirname(__FILE__) . '/../helpers/password.inc';
    require_once dirname(__FILE__) . '/../functions.php';
    $user_model = new User();
    $edit = array();
    $user = $user_model->get_by_username($username);

    if (empty($user->id)) {
      echo 'Nežinomas naudotojas';
    }
    else {
    $new_password = Password::generate_password();
    $edit['password'] = md5($new_password);

    if ($user_model->Put($user->id, $edit)) {
        send_mail($user->email, 'Naujas sklandymas.lt slaptažodis', "Sveiki, $user->name,<br /><br />Siunčiame Jums naują prisijungimo slaptažodį.<br /><br />Jūsų vartotojo vardas: $user->username<br />Slaptažodis: $new_password<br />");
        $messages = Messages::get_messages();
        echo empty($messages) ? 'Naujas slaptažodis sugeneruotas ir išsiųstas adresu ' . $user->email : implode("\n", $messages);
    }
    else {
        echo 'Nepavyko pakeisti slaptažodžio';
    }
    }
}
else {
    echo 'Nežinomas veiksmas';
}
