<?php

$head = '<link rel="stylesheet" type="text/css" href="styles_add_modify.css' . getVersionString() . '"  >
        ';
$path = array(
    array("name" => $app_title, "link" => '/' . $app_url_path),
    array("name" => 'Admin', "link" => '/' . $app_url_path . '/admin'),
    array("name" => 'Add Coach', "link" => '/' . $app_url_path . '/')
);
generateHeader($head, $path);
?>

    <form action="." method="post">
        <input type="hidden" name="action" value="add_coach">

        <div id="box" class="container">
            <div class="row">
                <div class="header col s12"><h1 class="title">Add Coach</h1></div>
            </div>

            <div class="row">
                <div class="coach_input project_name col s5">
                    <label class="spacing" for="coach_first_name">First Name</label>
                    <input type="text" name="coach_first_name" autofocus required>
                </div>
                <div class="coach_input project_name col s7">
                    <label class="spacing" for="coach_last_name">Last Name</label>
                    <input type="text" name="coach_last_name" required>
                </div>
            </div>

            <div class="row">
                <div class="coach_input project_name col s6">
                    <label class="spacing" for="coach_phone_nbr">Phone</label>
                    <input type="text" name="coach_phone_nbr">
                </div>
                <div class="coach_input project_name col s6">
                    <label class="spacing" for="coach_email">Email</label>
                    <input type="text" name="coach_email">
                </div>
            </div>

            <div class="row">
                <div class="button_wrapper col s12">
                    <button class="submit back" type="button" onclick="location.href='index.php'">Back</button>
                    <button class="submit s" type="submit" name="choice" value="Add">Submit</button>
                </div>
            </div>
        </div>
    </form>
<?php writeFooter();?>