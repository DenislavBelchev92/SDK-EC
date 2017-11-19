<div class="container-fluid">
    <div class="row">
        <form class="form-horizontal" action="../../core/php/common/run_callout_filter.php" method="POST" >
            <div class="form-group">
                <div class="col-sm-8">
                    <div class="input-group">
                        <input type="text" class="form-control" id="search" name="search" placeholder="Search">
                        <div class="input-group-btn">
                            <button class="btn btn-default" type="submit" id="submit" name="submit"><i class="glyphicon glyphicon-search"></i></button>
                        </div>
                        <div class="input-group-btn">
                            <a href="#callouts-filters" data-toggle="collapse" ><button class="btn btn-default" ><i class="caret"></i></button></a>
                        </div>
                    </div>
                </div>

                <label class="col-sm-1 control-label" for="area">Област:</label>
                <div class="col-sm-3">
                    <select class="form-control" id="area" name="area">
                        <?php
                        foreach ($AREAS_IN_BULGARIA as $area) {
                            echo "<option>" ;
                            echo $area;
                            echo "</option>";
                        }

                        ?>
                    </select>
                </div>
            </div>
        </form>

        <div class="collapse" id="callouts-filters">
            <form class="form-horizontal" >
                <div class="form-group">

                    <label class="col-md-1 control-label" for="type">Тип:</label>
                    <div class="col-md-3">
                        <select class="form-control" id="sel2">
                            <option>Административен</option>
                            <option>Битов</option>
                            <option>Инсфраструктура</option>
                        </select>
                    </div>



                    <label class="col-md-1 control-label" for="followers">
                        <a href="#" data-toggle="tooltip" data-placement="top" title="Последователи">
                            <i class="glyphicon glyphicon-user"> </i>
                        </a>
                    </label>
                    <div class="col-md-3">
                        <select class="form-control" id="sel3">
                            <option>1-10</option>
                            <option>10-100</option>
                            <option>100+</option>
                        </select>
                    </div>

                    <label class="col-md-1 control-label" for="rating">
                        <a href="#" data-toggle="tooltip" data-placement="top" title="Рейтинг">
                            <i class="glyphicon glyphicon-star"> </i>
                        </a>
                    </label>
                    <div class="col-md-3">
                        <select class="form-control" id="sel3">
                            <option>1-5</option>
                            <option>5-8</option>
                            <option>8-10</option>
                        </select>
                    </div>


                </div>
            </form>
        </div>
    </div>
</div>