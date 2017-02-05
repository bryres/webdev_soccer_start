<html>
    <head>
        <title>Login</title>
    </head>
    <body>


    <form action="." method="post">
        <input type="hidden" name="action" value="login">

        <label>Admin</label>
        <select name="usr_id_adm"  title="usr_id_adm">
            <!-- Loop through each user and add them to dropdown -->
            <?php foreach ($user_list as $user) {
                if($user['usr_role_cde'] == "ADM") {
                ?>
                <option value="<?php echo $user['usr_id']?>">
                    <?php echo $user['usr_type_cde'] ?> &nbsp
                    <?php echo $user['usr_grade_lvl']?> -
                    <?php echo $user['usr_last_name']?>,
                    <?php echo $user['usr_first_name'] ?>
                    <?php echo $user['usr_role_cde'] ?>
                </option>
            <?php } } ?>
        </select>

        <input type="submit" name="choice" value="Login ADM">

        <br>
        <br>
        <br>

        <label>Teachers</label>
        <select name="usr_id_tch"  title="usr_id_tch">
            <!-- Loop through each user and add them to dropdown -->
            <?php foreach ($user_list as $user) {
                if($user['usr_role_cde'] != "ADM" && $user['usr_type_cde'] != "STD") {
                    ?>
                    <option value="<?php echo $user['usr_id']?>">
                        <?php echo $user['usr_type_cde'] ?> &nbsp
                        <?php echo $user['usr_grade_lvl']?> -
                        <?php echo $user['usr_last_name']?>,
                        <?php echo $user['usr_first_name'] ?>
                        <?php echo $user['usr_role_cde'] ?>
                    </option>
                <?php } } ?>
        </select>

        <input type="submit" name="choice" value="Login TCH">

        <br>
        <br>
        <br>

        <label>Students</label>
        <select name="usr_id_std"  title="usr_id_std">
            <!-- Loop through each user and add them to dropdown -->
            <?php foreach ($user_list as $user) {
                if($user['usr_role_cde'] != "ADM" && $user['usr_type_cde'] == "STD") {
                    ?>
                    <option value="<?php echo $user['usr_id']?>">
                        <?php echo $user['usr_type_cde'] ?> &nbsp
                        <?php echo $user['usr_grade_lvl']?> -
                        <?php echo $user['usr_last_name']?>,
                        <?php echo $user['usr_first_name'] ?>
                        <?php echo $user['usr_role_cde'] ?>
                    </option>
                <?php } } ?>
        </select>

        <input type="submit" name="choice" value="Login STD">
    </form>
    </body>
</html>