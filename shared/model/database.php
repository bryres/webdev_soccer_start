<?php

try {
    $db = new PDO($dsn, $username, $password, $options);
} catch (PDOException $e) {
    error_log("Unable to connect to database: " . $e->getMessage(), 0);

    display_error ("Unable to connect to database.");
    exit;
}

function set_db_user ()
{
    global $db;
    global $user;

    try {
        $id = isset($_SESSION['prev_usr_id']) ? $_SESSION['prev_usr_id'] : $user->usr_id;
        $statement = $db->prepare("SET @usr_id = " . $id);
        $statement->execute();
        $statement->closeCursor();
    } catch (PDOException $e) {
        display_db_exception($e);
    }
}
function get_list ($query) {
    global $db;

    try {
        $statement = $db->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();
        $statement->closeCursor();
        return $result;
    } catch (PDOException $e) {
        display_db_exception($e);
    }
}

function get_apps() {
    $query = "
        SELECT m.menu_id, title, descr, link, sort_order, target, fa_icon
        FROM menu_item m, menu_item_user_type_xref ux
        WHERE m.menu_id = ux.menu_id
        AND ux.usr_type_cde = :usr_type_cde
        AND active = 1
        
        union
        
        SELECT m.menu_id, title, descr, link, sort_order, target, fa_icon
        FROM menu_item m, menu_item_user_role_xref ur, role_application_user_xref ax
        WHERE m.menu_id = ur.menu_id
        and ur.usr_role_cde = ax.usr_role_cde
        and ur.app_cde = ax.app_cde
        and ax.usr_id = :usr_id
        AND active = 1
        
        ORDER BY sort_order        
        ";

     global $db;
     global $user;
     global $app_cde;

    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':usr_type_cde', $user->usr_type_cde);
        $statement->bindValue(':usr_id', $user->usr_id);

        $statement->execute();
        $result = $statement->fetchAll();
        $statement->closeCursor();
        return $result;
    } catch (PDOException $e) {
        display_db_exception($e);
        exit();
    }
}
