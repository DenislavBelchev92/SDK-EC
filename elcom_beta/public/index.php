<?php
/**
 * Created by PhpStorm.
 * User: Denis
 * Date: 11/15/2017
 * Time: 9:59 PM
 */
?>

<?php
    include_once $_SERVER['DOCUMENT_ROOT']."/elcom_beta/core/php/init.php";
?>


<!-- Iclude the head(metatags and title) -->
<?php include  $_SERVER['DOCUMENT_ROOT']."/elcom_beta/includes/common/head.html" ?>

<div class="page">

    <!-- Include the navigation bars -->
    <?php include $_SERVER['DOCUMENT_ROOT']."/elcom_beta/includes/common/navbar.html" ?>

    <div class="container-fluid">
        <div class="row content">

            <div class="col-sm-10">
                <div>
                    <h1>Добре дошли</h1>
                </div>

                <hr>

                <?php include  $_SERVER['DOCUMENT_ROOT']."/elcom_beta/includes/common/callout_filters.php" ?>

                <hr>

                <?php include  $_SERVER['DOCUMENT_ROOT']."/elcom_beta/includes/index_page/callouts_scroll_bar.html" ?>

            </div>

            <div class="col-sm-2">

                <?php include  $_SERVER['DOCUMENT_ROOT']."/elcom_beta/includes/index_page/news_and_callouts_short_info.html" ?>

            </div>
        </div>
    </div>


<?php include  $_SERVER['DOCUMENT_ROOT']."/elcom_beta/includes/common/footer.php" ?>