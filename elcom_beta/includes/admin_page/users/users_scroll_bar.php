<?php
/**
 * Created by PhpStorm.
 * User: Denis
 * Date: 10/16/2017
 * Time: 8:44 AM
 */
?>

<div style="max-height: 360px;  overflow: auto; margin-bottom: 15px;">
    <?php
    // FIX ME
    // Very stupid way to pass dynamically the modified username
    $url = explode("?user_selected", $_SERVER['REQUEST_URI']);

    $ALL_USERS = User::get_all();
    foreach ($ALL_USERS as $user_to_show) {

        echo "<a href='{$url[0]}?user_selected=" . htmlentities($user_to_show->username) . "'>";
        echo "<button type='button' class='btn btn-primary btn-block btn-md' style='border-radius: 0px;'>";
        echo "{$user_to_show->username}";
        echo "</button>";
        echo "</a>";

    }
    ?>
</div>
