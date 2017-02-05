<?php

//Authenticate a username and password to Bergen Techs AD
//Username must be in UPN format username@bergen.org
//Returns True on sucess
//Returns False on any fails
function bergenAuthLDAP($username, $password)
{
    $ad = ldap_connect("168.229.1.240", 3268);

    if ($ad === FALSE)
        return false;

    if (empty($password))
        return false;

    ldap_set_option($ad, LDAP_OPT_PROTOCOL_VERSION, 3);
    ldap_set_option($ad, LDAP_OPT_REFERRALS, 0);

    //Test user creds
    if ( @ldap_bind($ad, $username . '@bergen.org', $password) )
        return true;
    else
        return false;
}

function get_user_by_username($username, $app_cde) {
    $query = 'SELECT user.usr_id, usr_bca_id, usr_type_cde, usr_role_cde, usr_class_year, usr_first_name, usr_last_name, usr_active
              FROM user
              LEFT OUTER JOIN role_application_user_xref ON user.usr_id = role_application_user_xref.usr_id
              and app_cde = :app_cde
              WHERE usr_bca_id =  :username';

    global $db;
//change
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':username', $username);
        $statement->bindValue(':app_cde', $app_cde);
        $statement->execute();
        $result = $statement->fetch();
        $statement->closeCursor();
        return $result;
    } catch (PDOException $e) {
        display_db_exception($e);
        exit();
    }
}

function get_user($usr_id, $app_cde) {
    $query = 	'SELECT user.usr_id, usr_bca_id, usr_type_cde, usr_role_cde, usr_class_year, usr_first_name, usr_last_name, usr_active
                  FROM user
                  LEFT OUTER JOIN role_application_user_xref ON user.usr_id = role_application_user_xref.usr_id
                  and app_cde = :app_cde
                  WHERE user.usr_id = :usr_id';

    global $db;

    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':usr_id', $usr_id);
        $statement->bindValue(':app_cde', $app_cde);
        $statement->execute();
        $result = $statement->fetch();
        $statement->closeCursor();
        return $result;
    } catch (PDOException $e) {
        display_db_exception($e);
        exit();
    }
}

function get_user_list() {
    $query = 'SELECT usr_id, usr_bca_id, usr_type_cde, usr_class_year, usr_grade_lvl, 
                 usr_first_name, usr_last_name, usr_active
              from user
              where usr_active = 1
			  order by usr_grade_lvl desc, usr_last_name, usr_first_name ';

    return get_list($query);
}
function get_user_list_test_page()
{
    $query = 'Select u.usr_id, u.usr_first_name, u.usr_last_name, u.usr_display_name, u.usr_class_year, r.usr_role_cde,
                  u.usr_type_cde, u.usr_grade_lvl
                  from user u
                  left join role_application_user_xref r
                  on u.usr_id = r.usr_id
                  and app_cde = :app_cde
                  where u.usr_active = 1
                  order by usr_role_cde desc, usr_grade_lvl desc, usr_last_name, usr_first_name';

    global $app_cde;
    global $db;

    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':app_cde', $app_cde);
        $statement->execute();
        $result = $statement->fetchAll();
        $statement->closeCursor();
        return $result;
    } catch (PDOException $e) {
        display_db_exception($e);
        exit();
    }
}

class User
{
    public $usr_id, $usr_first_name, $usr_last_name, $usr_display_name,
        $usr_grade_lvl, $usr_bca_id, $user_email, $usr_type_cde,
        $usr_class_year, $academy_cde, $ps_id, $usr_active;

    private $roles;

    public function __construct($usr_id, $usr_first_name, $usr_last_name, $usr_display_name,
                                $usr_grade_lvl, $usr_bca_id, $user_email, $usr_type_cde,
                                $usr_class_year, $academy_cde, $ps_id, $usr_active)
    {
        $this->usr_id = $usr_id;
        $this->usr_first_name = $usr_first_name;
        $this->usr_last_name = $usr_last_name;
        $this->usr_display_name = $usr_display_name;
        $this->usr_grade_lvl = $usr_grade_lvl;
        $this->usr_bca_id = $usr_bca_id;
        $this->user_email = $user_email;
        $this->usr_type_cde = $usr_type_cde;
        $this->usr_class_year = $usr_class_year;
        $this->academy_cde = $academy_cde;
        $this->ps_id = $ps_id;
        $this->usr_active = $usr_active;
    }

    public function getRole($app_cde)
    {
        if (array_key_exists ($app_cde , $this->roles))
            return $this->roles[$app_cde];
        else
            return '';
    }

    private function loadRoles()
    {
        $query = 'SELECT app_cde, usr_role_cde
                  FROM role_application_user_xref
                  WHERE usr_id = :usr_id';

        global $db;

        try {
            $statement = $db->prepare($query);
            $statement->bindValue(':usr_id', $this->usr_id);
            $statement->execute();
            $result = $statement->fetchAll();
            $statement->closeCursor();

            $this->roles = array();

            foreach ($result as $row) {
                $this->roles[$row['app_cde']] = $row['usr_role_cde'];
            }
        } catch (PDOException $e) {
            display_db_exception($e);
            exit();
        }
    }


    private static function getUserByColumn($whereColumn, $whereCriteria)
    {
        $query = 'SELECT usr_id, usr_first_name, usr_last_name, usr_display_name,
                        usr_grade_lvl, usr_bca_id, user_email, usr_type_cde,
                        usr_class_year, academy_cde, ps_id, usr_active
                  FROM user
                  WHERE user.' . $whereColumn . ' = :' . $whereColumn;

        global $db;

        try {
            $statement = $db->prepare($query);
            $statement->bindValue(':' . $whereColumn, $whereCriteria);
            $statement->execute();
            $result = $statement->fetch();
            $statement->closeCursor();

            $u = new User($result["usr_id"], $result["usr_first_name"], $result["usr_last_name"],
                $result["usr_display_name"], $result["usr_grade_lvl"], $result["usr_bca_id"],
                $result["user_email"], $result["usr_type_cde"], $result["usr_class_year"],
                $result["academy_cde"], $result["ps_id"], $result["usr_active"]);

            $u->loadRoles();
            return $u;

        } catch (PDOException $e) {
            display_db_exception($e);
            exit();
        }
    }
    public static function getUserByUsrId($usr_id)
    {
        return User::getUserByColumn('usr_id', $usr_id);
    }

    public static function getUserByBCAId($bca_id)
    {
        return User::getUserByColumn('usr_bca_id', $bca_id);
    }

    public function __toString()
    {
        return "usr_id:" . $this->usr_id .
        ";usr_first_name:" . $this->usr_first_name .
        ";usr_last_name:" . $this->usr_last_name .
        ";usr_display_name:" . $this->usr_display_name .
        ";usr_grade_lvl:" . $this->usr_grade_lvl .
        ";usr_bca_id:" . $this->usr_bca_id .
        ";user_email:" . $this->user_email .
        ";usr_type_cde:" . $this->usr_type_cde .
        ";usr_class_year:" . $this->usr_class_year .
        ";academy_cde:" . $this->academy_cde .
        ";usr_active:" . $this->usr_active;
    }
}
?>