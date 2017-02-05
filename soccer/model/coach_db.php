<?php

function get_coach_list() {
    $query = 'SELECT coach_id, coach_last_name, coach_first_name, coach_phone_nbr, coach_email
              from coach
			  order by coach_last_name, coach_first_name';
    return get_list($query);
}

function get_coach($coach_id) {
    global $db;
    $query = 'select coach_id, coach_last_name, coach_first_name, coach_phone_nbr, coach_email
              from coach 
              where coach_id = :coach_id';

    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':coach_id', $coach_id);
        $statement->execute();
        $result = $statement->fetch();
        $statement->closeCursor();
        return $result;
    }
    catch (PDOException $e) {
        display_db_exception($e);
        exit();
    }
}

function add_coach($coach_last_name, $coach_first_name, $coach_phone_nbr, $coach_email) {
    global $db;
    $query = 'INSERT INTO coach
                 (coach_last_name, coach_first_name, coach_phone_nbr, coach_email)
              VALUES
                 (:coach_last_name, :coach_first_name, :coach_phone_nbr, :coach_email)';
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':coach_last_name', $coach_last_name);
        $statement->bindValue(':coach_first_name', $coach_first_name);
        $statement->bindValue(':coach_phone_nbr', $coach_phone_nbr);
        $statement->bindValue(':coach_email', $coach_email);
        $statement->execute();
        $statement->closeCursor();
    } catch (PDOException $e) {
        display_db_exception($e);
        exit();
    }
}


function modify_coach($coach_id, $coach_last_name, $coach_first_name, $coach_phone_nbr, $coach_email) {
    global $db;
    $query = 'update coach set
                 coach_last_name = :coach_last_name,
                 coach_first_name = :coach_first_name,
                 coach_phone_nbr = :coach_phone_nbr,
                 coach_email = :coach_email
                 where coach_id = :coach_id';
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':coach_last_name', $coach_last_name);
        $statement->bindValue(':coach_first_name', $coach_first_name);
        $statement->bindValue(':coach_phone_nbr', $coach_phone_nbr);
        $statement->bindValue(':coach_email', $coach_email);
        $statement->bindValue(':coach_id', $coach_id);
        $statement->execute();
        $statement->closeCursor();
    } catch (PDOException $e) {
        display_db_exception($e);
        exit();
    }
}


function delete_coach($coach_id){
    global $db;
    $query = 'delete from coach
              where coach_id = :coach_id';
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':coach_id', $coach_id);
        $statement->execute();
        $statement->closeCursor();
    } catch (PDOException $e) {
        display_db_exception($e);
        exit();
    }
}

?>