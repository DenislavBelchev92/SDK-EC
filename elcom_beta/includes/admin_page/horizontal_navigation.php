<?php
/**
 * Created by PhpStorm.
 * User: Denis
 * Date: 10/8/2017
 * Time: 9:15 AM
 */
?>

    <div>
        <div class="page-header clearfix">
            <a class="" href="index.php">
                <div class="pull-left btn btn-default btn-lg clearfix">
                    Admin Page
                </div>
            </a>
            <a href="callout_create.html" class="btn btn-success btn-lg pull-left">
                <span class="glyphicon glyphicon-plus-sign"></span> СЪЗДАЙ
            </a>

            <?php if(!isset($_GET['login'])) :?>

            <a href="/elcom_beta/public/login.php?login=1" class="pull-right btn btn-primary btn-lg">
                <span class="glyphicon glyphicon-log-in"></span> Влез
            </a>

            <?php endif;?>

            <a href="#" class="pull-right btn btn-primary btn-lg">
                <span class="glyphicon glyphicon-th"></span> Настройки
            </a>

            <form class="hidden-xs pull-right search-bar-top clearfix" style="position: relative; right:5px; top: 6px; " role="search">
                <div class="form-group input-group">
                    <input type="text" class="form-control" placeholder="Search..">
                </div>
            </form>
        </div>

        <nav class="navbar navbar-default">

            <div class="navbar-header">

                <button type="button" class="navbar-toggle pull-left" data-toggle="collapse" data-target="#myNavbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <a href="#search-bar" data-toggle="collapse" class="visible-xs btn btn-primary btn-lg pull-right">
                    <span class="glyphicon glyphicon-search"></span>
                </a>
            </div>



            <div class="collapse navbar-collapse" id="myNavbar">

                <ul class="nav nav-tabs nav-justified">
                    <li><a href="#">Users</a></li>
                    <li><a href="#">Callouts</a></li>
                </ul>
            </div>
        </nav>

        <div class="collapse" id="search-bar">
            <form class=" navbar-form visible-xs" role="search">
                <div class="form-group input-group">
                    <input type="text" class="form-control" placeholder="Search..">
                </div>
            </form>
        </div>
    </div>
