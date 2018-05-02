<?php

//Authenticate a username and password to Bergen Techs AD
//Username must be in UPN format username@bergen.org
//Returns True on success
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
                 usr_first_name, usr_last_name, usr_active, academy_cde, usr_ad_allow_updt, pwd, failed
              from user
              where usr_active = 1
			  order by usr_grade_lvl desc, usr_last_name, usr_first_name ';

    return get_list($query);
}

function get_user_list_with_params($usr_grade_lvl, $academy_cde, $active, $userType)
{
    global $db;
    $criteria_clause = '';
    if ($usr_grade_lvl != '') {
        $criteria_clause .= ' and usr_grade_lvl = :usr_grade_lvl ';
    }
    if ($academy_cde != '') {
        $criteria_clause .= ' and academy_cde = :academy_cde ';
    }
    if ($active != '') {
        $criteria_clause .= ' and usr_active = :usr_active ';
    }
    if ($userType != '') {
        $criteria_clause .= ' and usr_type_cde = :usr_type_cde ';
    }

    $query = 'SELECT usr_id, usr_bca_id, u.usr_type_cde, usr_class_year, usr_grade_lvl, 
                 CONCAT(usr_last_name, ", ", usr_first_name) as name, 
                 user_email, usr_type_desc, academy_cde, ps_id, usr_ad_cn,
                 usr_active, usr_ad_allow_updt
              from user u, user_type t
              where u.usr_type_cde = t.usr_type_cde '
        . $criteria_clause .
        ' order by usr_grade_lvl desc, name ';

    try {
        $statement = $db->prepare($query);

        if ($usr_grade_lvl != '') {
            $statement->bindValue(':usr_grade_lvl', $usr_grade_lvl);
        }
        if ($academy_cde != '') {
            $statement->bindValue(':academy_cde', $academy_cde);
        }
        if ($active != '') {
            $statement->bindValue(':usr_active', $active);
        }
        if ($userType != '') {
            $statement->bindValue(':usr_type_cde', $userType);
        }
        $statement->execute();
        $result = $statement->fetchAll();
        $statement->closeCursor();
        return $result;
    } catch (PDOException $e) {
        display_db_exception($e);
        exit();
    }
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

function add_user($usr_first_name, $usr_last_name, $usr_display_name, $usr_grade_lvl, $user_email, $pwd,$usr_type_cde, $usr_class_year, $active){
    if (User::getUserByEmail($user_email) != null)
        return;

    $hashed_pwd = password_hash($pwd, PASSWORD_BCRYPT);

    $query = 'INSERT INTO user (usr_first_name,usr_last_name,usr_display_name,usr_grade_lvl,user_email,usr_type_cde,usr_class_year,usr_active,pwd)
              VALUES (:usr_first_name,:usr_last_name,:usr_display_name,:usr_grade_lvl,:user_email,:usr_type_cde,:usr_class_year,:usr_active,:hashed_pwd)   ';

    global $db;

    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':usr_first_name', $usr_first_name);
        $statement->bindValue(':usr_last_name', $usr_last_name);
        $statement->bindValue(':usr_display_name', $usr_display_name);
        $statement->bindValue(':usr_grade_lvl', $usr_grade_lvl);
        $statement->bindValue(':user_email', $user_email);
        $statement->bindValue(':usr_type_cde', $usr_type_cde);
        $statement->bindValue(':usr_class_year', $usr_class_year);
        $statement->bindValue(':usr_active', $active);
        $statement->bindValue(':hashed_pwd', $hashed_pwd);
        $statement->execute();
        $statement->closeCursor();

    } catch (PDOException $e) {
        display_db_exception($e);
        exit();
    }
}


class User
{
    public $usr_id, $usr_first_name, $usr_last_name, $usr_display_name,
        $usr_grade_lvl, $usr_bca_id, $user_email, $usr_type_cde,
        $usr_class_year, $academy_cde, $ps_id, $usr_active, $team_cde, $pwd, $failed;

    private $roles;

    public function __construct($usr_id, $usr_first_name, $usr_last_name, $usr_display_name,
                                $usr_grade_lvl, $usr_bca_id, $user_email, $usr_type_cde,
                                $usr_class_year, $academy_cde, $ps_id, $usr_active, $team_cde,
                                $usr_dob, $usr_cell_nbr, $usr_text_ok,
                                $pwd = null, $failed = 0)
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
        $this->team_cde = $team_cde;
        $this->usr_dob = $usr_dob;
        $this->usr_cell_nbr = $usr_cell_nbr;
        $this->usr_text_ok = $usr_text_ok;
        $this->pwd = $pwd;
        $this->failed = $failed;
    }

    function update_user(){
        $query = 'UPDATE user
              SET usr_first_name = :usr_first_name,
                  usr_last_name = :usr_last_name,
                  usr_display_name = :usr_display_name,
                  usr_grade_lvl = :usr_grade_lvl,
                  usr_bca_id = :usr_bca_id,
                  user_email = :user_email,
                  usr_type_cde = :usr_type_cde,
                  usr_class_year = :usr_class_year,
                  academy_cde = :academy_cde,
                  ps_id = :ps_id,
                  usr_dob = :usr_dob,
                  usr_cell_nbr = :usr_cell_nbr,
                  usr_text_ok = :usr_text_ok,
                  failed = :failed,
                  usr_active = :usr_active
              WHERE usr_id = :usr_id';
        global $db;

        try {
            $statement = $db->prepare($query);
            $statement->bindValue(':usr_first_name', $this->usr_first_name);
            $statement->bindValue(':usr_last_name', $this->usr_last_name);
            $statement->bindValue(':usr_display_name', $this->usr_display_name);
            $statement->bindValue(':usr_grade_lvl', $this->usr_grade_lvl);
            $statement->bindValue(':usr_bca_id', $this->usr_bca_id);
            $statement->bindValue(':user_email', $this->user_email);
            $statement->bindValue(':usr_type_cde', $this->usr_type_cde);
            $statement->bindValue(':usr_class_year', $this->usr_class_year);
            $statement->bindValue(':academy_cde', $this->academy_cde);
            $statement->bindValue(':ps_id', $this->ps_id);
            $statement->bindValue(':usr_dob', $this->usr_dob);
            $statement->bindValue(':usr_cell_nbr', $this->usr_cell_nbr);
            $statement->bindValue(':usr_text_ok', $this->usr_text_ok);
            $statement->bindValue(':failed', $this->failed);
            $statement->bindValue(':usr_active', $this->usr_active);
            $statement->bindValue(':usr_id', $this->usr_id);
            $statement->execute();
            $statement->closeCursor();

        } catch (PDOException $e) {
            display_db_exception($e);
            exit();
        }
    }



    public function getRole($app_cde)
    {
        if (array_key_exists($app_cde, $this->roles))
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

    public function change_password($password){
        $query = 'UPDATE user 
                  SET pwd=:pwd 
                  WHERE usr_id=:id';
        global $db;

        try {
            $new_pass = password_hash($password, PASSWORD_BCRYPT);

            $statement = $db->prepare($query);
            $statement->bindValue(':id', $this->usr_id);
            $statement->bindValue(':pwd', $new_pass);
            $statement->execute();
            $statement->closeCursor();

        } catch (PDOException $e) {
            display_db_exception($e);
            exit();
        }
    }

    public function setFailed($f){
        $query = 'UPDATE user 
                  SET failed=:failed
                  WHERE usr_id=:id';
        global $db;

        try {
            $statement = $db->prepare($query);
            $statement->bindValue(':id', $this->usr_id);
            $statement->bindValue(':failed', $f);
            $statement->execute();
            $statement->closeCursor();

        } catch (PDOException $e) {
            display_db_exception($e);
            exit();
        }
    }

    private static function getUserByColumn($whereColumn, $whereCriteria)
    {
        $query = 'SELECT usr_id, usr_first_name, usr_last_name, usr_display_name,
                        usr_grade_lvl, usr_bca_id, user_email, usr_type_cde,
                        usr_class_year, academy_cde, ps_id, usr_active, team_cde, pwd, failed, 
                        usr_dob, usr_cell_nbr, usr_text_ok
                  FROM user
                  WHERE user.' . $whereColumn . ' = :' . $whereColumn;

        global $db;

        try {
            $statement = $db->prepare($query);
            $statement->bindValue(':' . $whereColumn, $whereCriteria);
            $statement->execute();
            $result = $statement->fetch();
            $statement->closeCursor();

            if ($result["usr_id"] == null)
                return null;

            $u = new User($result["usr_id"], $result["usr_first_name"], $result["usr_last_name"],
                $result["usr_display_name"], $result["usr_grade_lvl"], $result["usr_bca_id"],
                $result["user_email"], $result["usr_type_cde"], $result["usr_class_year"],
                $result["academy_cde"], $result["ps_id"], $result["usr_active"], $result["team_cde"],
                $result["usr_dob"], $result["usr_cell_nbr"], $result["usr_text_ok"],
                $result["pwd"], $result["failed"]);

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

    public static function getUserByEmail($email){
        return User::getUserByColumn('user_email', $email);
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
        ";usr_active:" . $this->usr_active .
        ";usr_dob:" . $this->usr_dob .
        ";usr_cell_nbr:" . $this->usr_cell_nbr .
        ";usr_text_ok:" . $this->usr_text_ok;

    }
}

function get_grade_lvls(){
    $query = 'SELECT distinct usr_grade_lvl
              from user
              order by usr_grade_lvl';

    return get_list($query);
}

function get_user_types(){
    $query = 'SELECT usr_type_cde, usr_type_desc 
              from user_type';

    return get_list($query);
}
