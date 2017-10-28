<?php
/**
 * Created by PhpStorm.
 * User: Denis
 * Date: 10/8/2017
 * Time: 9:27 AM
 */
?>

<?php
/*
 * NOTE! Two empty div tags at the bottom
 * Started at vertical_navigation.php
 */
?>


    <?php if(isset($_GET['modified_group'])):?>

        <h2>
            <?php
            // Title
            $modify_title_message = $_GET['modified_group'];

            if(isset($_GET['modify_option'])) {
                $modify_title_message .= " {$_GET['modify_option']}";
            }

            echo "{$modify_title_message}";
            ?>
        </h2>

    <?php if(isset($_GET['modify_option'])):?>
        <?php
        // Load main modify page

        if ($_GET['modified_group'] == "Users") {
            echo "<hr>";

        }
        ?>
    <?php endif;?>

    <?php else:?>
        Welcome to admin page
    <?php endif;?>



