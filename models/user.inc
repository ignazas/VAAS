<?php

require_once dirname(__FILE__) . '/../helpers/db.inc';

class User {
    public $id;
    public $name;
    public $username;
    public $usertype;
    public $password;
    public $email;
    public $registerDate;
    public $lastvisitDate;
    public $discount;

    public $telephone1;
    public $website;
    public $avatar;

  /**
  * Sets the object's properties using the values in the supplied array
  *
  * @param assoc The property values
  */
  public function __construct( $data=array() ) {
    if (isset($data['id'])) $this->id = $data['id'];
    if (isset($data['name'])) $this->name = $data['name'];
    if (isset($data['username'])) $this->username = $data['username'];
    if (isset($data['usertype'])) $this->usertype = $data['usertype'];
    if (isset($data['password'])) $this->password = $data['password'];
    if (isset($data['email'])) $this->email = $data['email'];
    if (isset($data['registerDate'])) $this->registerDate = $data['registerDate'];
    if (isset($data['lastvisitDate'])) $this->lastvisitDate = $data['lastvisitDate'];
    if (isset($data['discount'])) $this->discount = $data['discount'];

    if (isset($data['telephone1'])) $this->telephone1 = $data['telephone1'];
    if (isset($data['website'])) $this->website = $data['website'];
    if (isset($data['avatar'])) $this->avatar = $data['avatar'];
  }

    public static function Get($id) {
        if (!empty($id)) {
          $data = DB::fetch("
                SELECT u.*,
                    ud.telephone1, ud.website, ud.avatar
                FROM jos_users u
                LEFT JOIN jos_contxtd_details ud ON u.id = ud.user_id
                WHERE
                    u.id = :id", array(':id' => $id));
          if (!empty($data))
            return new User($data);
        }
        return NULL;
    }

    public static function get_by_username($username) {
        if (!empty($username)) {
            $data = DB::fetch("
                SELECT u.*,
                    ud.telephone1, ud.website, ud.avatar
                FROM jos_users u
                LEFT JOIN jos_contxtd_details ud ON u.id = ud.user_id
                WHERE
                    u.username = :username OR u.email = :username", array(':username' => $username));
            if (!empty($data))
              return new User($data);
        }
        return NULL;
    }

    public static function Put($id, $values) {
        if (!empty($id) && !empty($values)) {
            $query_user = NULL;
            $query_context = NULL;
            foreach ($values as $key => $value) {
                if (in_array($key, array('name', 'username', 'email', 'password', 'usertype', 'block', 'sendEmail',
                                         'gid', 'registerDate', 'lastvisitDate', 'activation', 'params', 'discount')))
                    $query_user .= (!empty($query_user) ? ',' : NULL) . "`$key`='" . $value . "'";
                else
                    $query_context .= (!empty($query_context) ? ',' : NULL) . "`$key`='" . $value . "'";
            }

            if ($query_user)
                DB::query("UPDATE `jos_users` SET $query_user WHERE `id`=:id", array(':id' => $id));

            if ($query_context)
                DB::query("UPDATE `jos_contxtd_details` SET $query_context WHERE `user_id`=:id", array(':id' => $id));

            return TRUE;
        }
        return FALSE;
    }
}
