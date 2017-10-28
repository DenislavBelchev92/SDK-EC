<?php
/**
 * Created by PhpStorm.
 * User: Denis
 * Date: 10/8/2017
 * Time: 9:33 AM
 */

include_once $_SERVER['DOCUMENT_ROOT'] . "/elcom_beta/core/php/init.php";

$users_db = new users_database();

$all_users = $users_db->select_user("*", "");
$valid_users_columns = $users_db->get_users_db_columns();

include $_SERVER['DOCUMENT_ROOT'] . "/elcom_beta/includes/admin_page/header.php";

include $_SERVER['DOCUMENT_ROOT'] . "/elcom_beta/includes/admin_page/horizontal_navigation.php";

include $_SERVER['DOCUMENT_ROOT'] . "/elcom_beta/includes/admin_page/vertical_navigation.php";

/*
* Choose user to modify
*/
choose_user_to_be_modified ($users_db);

/*
* Choose message to display
*/

choose_message_to_display("manage_users");
/*
 * ASSIGN VALUE TO BE PRINTED IN the form fields
 */
if ($_SESSION['message_info']['sql_status']) {
    /*
     * Do nothing. Fields are received from other page.
     */
} else {
    populate_form_fields($users_db, $valid_users_columns);
}

?>

<div class="container-fluid">
    <?php
    echo display_message();
    ?>
    <div class="row">
        <div class="col-md-3">
            <?php
                include_once $_SERVER['DOCUMENT_ROOT'] . "/elcom_beta/includes/admin_page/users_scroll_bar.php";
            ?>

            <div class="col-sm-offset-4" style="display: inline-block; padding-left: 5px;">
                <a href="add_users.php">
                    <button name="add" class="btn btn-default">Add Users</button>
                </a>
            </div>

        </div>
        <div class="col-md-9">
            <div class="">
                <form class="form-horizontal" action="../../core/php/admin/users_modify.php?<?php echo http_build_query($_GET)?>" method="POST">
                    <?php
                        include_once $_SERVER['DOCUMENT_ROOT'] . "/elcom_beta/includes/admin_page/update_users_form.php";
                    ?>
                </form>
            </div>
        </div>
    </div>
</div>



<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>


    $(document).ready(function(){
        $(".input-group-addon").hover(function(){
            $(this).css("background-color", "#fff");
        }, function(){
            $(this).css("background-color", "#eee");
        });

        $(".input-group-addon").on("click", function () {
            $(this).siblings("input").prop("disabled", false);
        })

    });

</script>

<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/elcom_beta/includes/admin_page/footer.php";
?>