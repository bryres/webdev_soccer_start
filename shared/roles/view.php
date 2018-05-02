<?php
$head =
    '<title>Admin Roles</title>
    <link href="/'.$shared_url_path.'/roles/styles.css' . getVersionString() . '" rel="stylesheet">
    <link href="/'.$shared_url_path.'/ss/main_new.css' . getVersionString() . '" rel="stylesheet">';

$path = array
(
    array("name" => $app_title, "link" => '/' . $app_url_path),
    array("name" => 'Admin', "link" => '/' . $app_url_path . '/admin'),
    array("name" => 'User Roles', "link" => '/' . $app_url_path . '/admin/roles')
);
generateHeader($head, $path);
?>
<div class="container">
    <div class="title">
        <h2>User Roles</h2>
    </div>
    <div class="button-div">
        <a class="waves-effect waves-light btn" href="./index.php?action=show_add_admin">Add Role</a>
    </div>

    <table class="highlight centered bordered">
        <tr>
            <td><h5><strong>User</strong></h5></td>
            <td><h5><strong>Role</strong></h5></td>
            <td></td>
        </tr>
        <?php foreach ($assigned_roles as $assigned_user) { ?>
            <tr>
                <td>
                    <h6><?php echo $assigned_user['usr_last_name'] ?>, <?php echo $assigned_user['usr_first_name'] ?></h6>
                </td>
                <td>
                    <h6><?php echo $assigned_user['usr_role_desc'] ?></h6>
                </td>
                <td>
                    <a href="index.php?action=delete_admin&usrID=<?php echo $assigned_user['usr_id'] ?>&roleID=<?php echo $assigned_user['usr_role_cde'] ?>">
                        <h6 class="delete bca_fonts" style="color: rgb(54, 54, 143); z-index: 100;"><i class="material-icons">delete</i></h6></a>
                </td>
            </tr>
        <?php } ?>
    </table>
</div>
<script>
    $(".del").hover(function() {
        $(this).css("color", "#7d7069");
    }, function() {
        $(this).css("color", "#5d4c43");
    });
</script>
<?php writeFooter(); ?>