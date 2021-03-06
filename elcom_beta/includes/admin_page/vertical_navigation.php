<?php
/**
 * Created by PhpStorm.
 * User: Denis
 * Date: 10/8/2017
 * Time: 9:15 AM
 */
?>
<?php
/*
 * NOTE! 3 empty div tags at the top!
 * 1. <div class="container-fluid">
 * 2. <div class="container-fluid">
 * 3. <div class="col-sm-10">
 * Closed at footer.php
 */



/*
* FIX ME! THIS IS NOT GOOD. Had to be refactored!
*/
?>




    <?php
    /*FIX-ME
        Call list items from databas.
        Than use rawurlencode for paths
        and url encode for actual variables.
        EXAMPLE:
        $parh=urlencode("elcom/admin/local files/mine");
        $variable="R&D";
        urlencode($variable);
        $link = $path?variable;
        <a href=$link>
    */

    /*
    * FIX ME! THIS IS NOT NEEDED. ONLY FOR THE vertical navigation
    */
    $current_page="admin/index.php";
    $local_path="index.php";

    $users_page_name = "Users";
    $callouts_page_name = "Callouts";

    $tables_to_modify = array("{$users_page_name}","{$callouts_page_name}");
    $modify_options = array("Add","Update_Delete");
    $modify_options_links = array(
        "Add" => "add_",
        "Update_Delete" => "manage_",
    );
    ?>
    <div class="">

        <?php $table_index = 0; while($table = current($tables_to_modify)) :?>

        <div class="btn-group" style="width: 100%; margin-top: 2px;">
            <a class="btn btn-default" style="width: 90%; border-radius: 0;" href="<?php echo "manage_" . strtolower($table) . ".php"?>">
                <?php echo $table?>
            </a>
            <a class="btn btn-default dropdown-toggle" style="width: 10%; border-radius: 0;" data-toggle="collapse" href="#collapse<?php echo $table_index?>">
                <span class="caret" style="margin-left: -4px;"></span>
            </a>
        </div>
        <div id="collapse<?php echo $table_index?>" class="panel-collapse collapse">
            <ul class="list-group">
                <?php reset($modify_options);
                while ($option = current($modify_options)):?>

                    <?php
                        /*Needed only for the Update_Delete option when printing*/
                        $option_to_print = str_replace("_", "/", $option);
                    ?>

                    <a href="<?php echo rawurlencode($modify_options_links[$option] . strtolower($table) . ".php")?>">
                        <li class="list-group-item"><?php echo $option_to_print?></li>
                    </a>

                    <?php
                    /*
                    <a href="<?php echo rawurlencode($local_path)?>?modified_group=<?php echo urlencode($table);?>&modify_option=<?php echo $option?>">
                        <li class="list-group-item"><?php echo $option?></li>
                    </a>
                    */
                    ?>
                <?php next($modify_options); endwhile;?>
            </ul>
        </div>
        <?php next($tables_to_modify); $table_index++; endwhile;?>

    </div>
