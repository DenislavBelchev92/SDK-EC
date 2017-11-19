<?php
/**
 * Created by PhpStorm.
 * User: Denis
 * Date: 10/8/2017
 * Time: 9:33 AM
 *
 * USED TO UPDATE AND DELETE USERS
 */

include $_SERVER['DOCUMENT_ROOT'] . "/elcom_beta/includes/admin_page/header.php";


?>
<body>
    <div class="page">
        <?php
        include $_SERVER['DOCUMENT_ROOT'] . "/elcom_beta/includes/admin_page/horizontal_navigation.php";
        ?>

        <?php
        /*
         * Create empty user
         */
        $callout = new Lost_And_Found();

        if(isset($_GET['selected_callout_id'])) {
            $callout = Lost_And_Found::get_by_id($_GET['selected_callout_id']);

            $Session->save_callout_id_to_modify($callout->id);
            $Session->set_message("Modify callout with id {$callout->id}");

        } else {
            $Session->set_message("Modify callouts");
        }
        ?>

        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-2" style="height: 800px; border-right: 1px solid black;">
                <?php
                include $_SERVER['DOCUMENT_ROOT'] . "/elcom_beta/includes/admin_page/vertical_navigation.php";
                ?>
                </div>

                <!-- Start of the main part -->

                <div class="col-sm-10">
                    <div class="container-fluid">
                        <div class="row" style="margin-top: 5px;">
                            <div>
                                <?php
                                echo $Session->display_message(true);
                                ?>
                            </div>
                            <div>
                            <?php include  $_SERVER['DOCUMENT_ROOT']."/elcom_beta/includes/common/callout_filters.php" ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-5">
                                <?php
                                include_once $_SERVER['DOCUMENT_ROOT'] . "/elcom_beta/includes/admin_page/callouts/callouts_scroll_bar.php";
                                ?>


                                <div class="col-sm-offset-4" style="display: inline-block; padding-left: 5px;">
                                    <a href="add_callouts.php">
                                        <button name="add" class="btn btn-default">Add Callouts</button>
                                    </a>
                                </div>
                            </div>

                            <div class="col-md-7">
                                <div class="container-fluid">
                                    <div class="row">
                                        <form class="form-horizontal" id="callout_form" action="../../core/php/admin/callouts_modify.php" method="POST">
                                            <?php
                                            include_once $_SERVER['DOCUMENT_ROOT'] . "/elcom_beta/includes/admin_page/callouts/update_callouts_form.php";
                                            ?>

                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <!-- End of the main part <div class="col-sm-10">-->
                </div>
            <!-- End <div class="row"> -->
            </div>
        <!-- End <div class="container-fluid"> -->
        </div>
        <?php
        include $_SERVER['DOCUMENT_ROOT'] . "/elcom_beta/includes/admin_page/footer.php";
        ?>

    <!-- <div class="page"> -->
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

</body>
</html>
