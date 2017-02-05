<?php

function get_assigned_roles() {
    $query = 'select u.usr_id, u.usr_last_name, u.usr_first_name, x.usr_role_cde, usr_role_desc 
from role_application_user_xref x, user u, user_role r
where x.usr_id = u.usr_id
and x.usr_role_cde= r.usr_role_cde
and x.app_cde = r.app_cde
and x.app_cde = :app_cde';

    global $db;
    global $app_cde;
//
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

function get_users() {
    $query = 'select usr_last_name, usr_first_name, usr_id
        from user
        where usr_active = 1
        order by usr_last_name, usr_first_name';

    global $db;

    try {
        $statement = $db->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();
        $statement->closeCursor();
        return $result;
    } catch (PDOException $e) {
        display_db_exception($e);
        exit();
    }
}

function get_roles() {
    $query = 'select usr_role_desc, usr_role_cde
from user_role
where app_cde = :app_cde
order by usr_role_desc';

    global $db;
    global $app_cde;

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
function get_teacher_list(){
    $query = "select concat('\"', usr_last_name, ', ', usr_first_name, '\"') as teachers, usr_id
                from user u
                where usr_active = 1
                order by usr_last_name, usr_first_name";

    global $db;

    try {
        $statement = $db->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();
        $statement->closeCursor();
        return $result;
    } catch (PDOException $e) {
        display_db_exception($e);
        exit();
    }
}
function add_admin($usr_id, $app_cde, $usr_role_cde) {
    $query = 'insert into role_application_user_xref (usr_id, app_cde, usr_role_cde)
        values (:usr_id, :app_cde, :usr_role_cde)';

    global $db;

    $statement = $db->prepare($query);
    $statement->bindValue(":usr_id", $usr_id);
    $statement->bindValue(":app_cde", $app_cde);
    $statement->bindValue(":usr_role_cde", $usr_role_cde);
    $statement->execute();
    $statement->closeCursor();
}

function delete_admin($usr_id, $usr_role_cde) {
    $query = 'delete from role_application_user_xref
                    where usr_role_cde = :usr_role_cde 
                    and app_cde = :app_cde
                    and usr_id = :usr_id';

    global $db;
    global $app_cde;
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(":usr_role_cde", $usr_role_cde);
        $statement->bindValue(":usr_id", $usr_id);
        $statement->bindValue(":app_cde", $app_cde);
        $statement->execute();
        $statement->closeCursor();
    } catch (PDOException $e) {
        display_db_exception($e);
        exit();
    }
}

?>