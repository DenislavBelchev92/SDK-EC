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
    $url = explode("?selected_callout_id", $_SERVER['REQUEST_URI']);

    /*
     * For now only these
     */

    $ALL_CALLOUTS = Lost_And_Found::get_all();

    foreach ($ALL_CALLOUTS as $current_callout) {

        if ($Session->get_callout_filter()) {
            if ($current_callout->area == $Session->get_callout_filter()) {
                echo "<a href='{$url[0]}?selected_callout_id=" . htmlentities($current_callout->id) . "'>";
                echo "<button type='button' class='btn btn-primary btn-block btn-md' style='border-radius: 0px;'>";
                echo "{$current_callout->heading}";
                echo "</button>";
                echo "</a>";
            } else {
                continue;
            }
        } else {
            echo "<a href='{$url[0]}?selected_callout_id=" . htmlentities($current_callout->id) . "'>";
            echo "<button type='button' class='btn btn-primary btn-block btn-md' style='border-radius: 0px;'>";
            echo "{$current_callout->heading}";
            echo "</button>";
            echo "</a>";
        }

    }

    $Session->free_callout_filter();
    ?>
</div>
