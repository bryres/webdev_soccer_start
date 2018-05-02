<?php
$head = "
         <link rel='stylesheet' href='../ss/main.css" . getVersionString() . "'>
         ";

$path = array(
    array("name" => $app_title, "link" => '/' . $app_url_path),
    array("name" => 'Admin', "link" => '/' . $app_url_path . '/admin'),
    array("name" => 'Coaches', "link" => 'index.php')
);

generateHeader($head, $path);
?>


<div class="container" style="text-align:center;width:700px">
    <h3>Coaches</h3>

    <div class="col s5">
        <a class="btn-floating btn-large" href="./index.php?action=show_add_coach">+</a>
    </div>

    <table class="highlight">
        <thead>
        <tr>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Phone Number</th>
            <th>Email</th>
            <th>Actions</th>
        </tr>
        </thead>

        <tbody>
        <?php foreach ($coachList as $coach) {
            $coach_id = $coach['coach_id'];
    ?>
            <tr>
                <td><?php echo $coach['coach_first_name'] ?></td>
                <td><?php echo $coach['coach_last_name'] ?></td>
                <td><?php echo $coach['coach_phone_nbr'] ?></td>
                <td><?php echo $coach['coach_email'] ?></td>
                <td>
                    <a href="./index.php?coach_id=<?php echo $coach_id ?>&action=show_modify_coach">
                        <i class="material-icons" style="cursor:pointer">mode_edit</i></a> &nbsp;
                    <a style="cursor:pointer" onclick=deleteCoach(<?php echo $coach_id; ?>);><i class="material-icons">delete</i></a>&nbsp;


                </td>
            </tr>
        <?php } ?>

        </tbody>
    </table>
</div>

<script>
    function deleteCoach(coachID) {
        if (confirm('Are you sure you would like to delete this coach?')) {
            window.parent.parent.location.href = 'index.php?action=delete_coach&coach_id=' + coachID;
        }
    }
</script>

<?php writeFooter(); ?>
