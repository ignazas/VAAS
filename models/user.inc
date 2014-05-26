<?php

require_once dirname(__FILE__) . '/../helpers/db.inc';

class User {
    public static function Get($id) {
        if (!empty($id)) {
            return DB::fetch_object("
                SELECT jos_users.id, jos_users.name, jos_users.username, jos_users.usertype ,jos_users.password,
                    jos_users.email, jos_contxtd_details.telephone1, jos_contxtd_details.website, jos_users.registerDate, jos_users.lastvisitDate,
                    jos_contxtd_details.avatar
                FROM jos_users
                LEFT JOIN jos_contxtd_details
                ON jos_users.id = jos_contxtd_details.user_id
                WHERE
                    jos_users.id = ".$id);
        }
        return NULL;
    }

    public static function get_by_username($username) {
        if (!empty($username)) {
            return DB::fetch_object("
                SELECT jos_users.id, jos_users.name, jos_users.username, jos_users.usertype ,jos_users.password,
                    jos_users.email, jos_contxtd_details.telephone1, jos_contxtd_details.website, jos_users.registerDate, jos_users.lastvisitDate,
                    jos_contxtd_details.avatar
                FROM jos_users
                LEFT JOIN jos_contxtd_details
                ON jos_users.id = jos_contxtd_details.user_id
                WHERE
                    jos_users.username = '" . $username . "' OR jos_users.email = '" . $username . "'");
        }
        return NULL;
    }

    public static function Put($id, $values) {
        if (!empty($id) && !empty($values)) {
            $query_user = NULL;
            $query_context = NULL;
            foreach ($values as $key => $value) {
                if (in_array($key, array('name', 'username', 'email', 'password', 'usertype', 'block', 'sendEmail',
                                         'gid', 'registerDate', 'lastvisitDate', 'activation', 'params')))
                    $query_user .= (!empty($query_user) ? ',' : NULL) . "`$key`='" . $value . "'";
                else                
                    $query_context .= (!empty($query_context) ? ',' : NULL) . "`$key`='" . $value . "'";                
            }

            if ($query_user)
                DB::query("UPDATE `jos_users` SET $query_user WHERE `id`=" . $id);
            
            if ($query_context)
                DB::query("UPDATE `jos_contxtd_details` SET $query_context WHERE `user_id`=" . $id);

            return TRUE;
        }
        return FALSE;         
    }
}
