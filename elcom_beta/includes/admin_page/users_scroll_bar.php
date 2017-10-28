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

    while ($user = $all_users->fetch_assoc()) {

        echo "<a href='{$url[0]}?user_selected={$user['username']}'>";
        echo "<button type='button' class='btn btn-primary btn-block btn-md' style='border-radius: 0px;'>";
        echo "{$user['username']}";
        echo "</button>";
        echo "</a>";
        //echo "<a href='{$url[0]}&user_to_modify={$user['username']}'> {$user['username']} </a>";
        //echo "</br>";
    }
    ?>
</div>
