<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="../../../shared/ss/main.css<?php echo(getVersionString()); ?>" rel="stylesheet" type="text/css"/>
    <link href="/<?php echo $app_url_path ?>/../shared/roles/view.css<?php echo(getVersionString()); ?>" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" type="text/css" href="Semantic-UI-CSS-master/semantic.min.css<?php echo(getVersionString()); ?>">
    <script src="Semantic-UI-CSS-master/semantic.min.js<?php echo(getVersionString()); ?>"></script>
    <script src="https://code.jquery.com/jquery-1.10.2.js<?php echo(getVersionString()); ?>"></script>
    <script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js<?php echo(getVersionString()); ?>"></script>
    <link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css<?php echo(getVersionString()); ?>" rel="stylesheet">
    <script>
        $(function () {
            var availableTutorials = [
                <?php foreach($users as $user) { ?>
                "<?php echo $user['usr_last_name']?>, <?php echo $user['usr_first_name'] ?>",
                <?php } ?>
            ];
            $("#automplete-1").autocomplete({
                source: availableTutorials
            });
        });
    </script>
</head>
<body>
<form action="index.php" method="post">
    <input type="hidden" name="action" value="modify_admin">

    <div id="box">
        <div id="wrapper">
            <div id="wrapper2">
                <div id="columns">
                    <h1 class="title">Admin Roles</h1>

                    <table>
                        <tr>
                            <td><h2><strong>User</strong></h2></td>
                            <td><h2><strong>Role</strong></h2></td>
                            <td></td>
                        </tr>
                        <?php foreach ($assigned_roles as $assigned_user) { ?>
                            <tr>
                                <td>
                                    <h3><?php echo $assigned_user['usr_last_name'] ?>, <?php echo $assigned_user['usr_first_name'] ?></h3>
                                </td>
                                <td>
                                    <h3><?php echo $assigned_user['usr_role_desc'] ?></h3>
                                </td>
                                <td>
                                    <a href="index.php?action=delete_admin&usrID=<?php echo $assigned_user['usr_id'] ?>&roleID=<?php echo $assigned_user['usr_role_cde'] ?>">
                                        <h4 class="delete" style="color: rgb(54, 54, 143); z-index: 100;">d</h4></a>
                                </td>
                            </tr>
                        <?php } ?>
                    </table>

                </div>

                <div id="add">
                    <br>

                    <ul style="display: inline-block; text-decoration: none; padding-left: 20px;">
                        <li style="display: inline-block; margin-left: 18px;">
                            <h2><strong>Add Admin</strong></h2>
                            <select id="user_drop" name="user_drop">
                                <?php foreach ($users as $user) { ?>
                                    <option value="<?php echo $user['usr_id'] ?>"><?php echo $user['usr_last_name'] ?>
                                        , <?php echo $user['usr_first_name'] ?></option>
                                <?php } ?>
                            </select></li>

                        <!--                <div style="margin:20px 0"></div>-->

                        <li style="display: inline-block; margin-left: 40px;">
                            <div>
                                <h2><strong>Select Role</strong></h2>
                                <select class="ui search dropdown" name="role_drop" name="role_drop">
                                    
                                    <?php foreach ($roles as $role) { ?>
                                        <option
                                            value="<?php echo $role['usr_role_cde'] ?>"><?php echo $role['usr_role_desc'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </li>

                        <li style="display: inline-block">
                            <button class="submit s" type="submit" name="choice" value="Add Admin" style="margin-left: 3em; margin-top: .5em;">Add</button>
                        </li>
                    </ul>

                    <br>
                    <div id="button-div">
                        <button class="submit b" type="submit" name="choice" value="Back">Back</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
</body>

</html>