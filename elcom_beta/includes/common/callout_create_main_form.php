<?php
/**
 * Created by PhpStorm.
 * User: Denis
 * Date: 11/15/2017
 * Time: 9:03 PM
 */
?>

<?php
/*
 * Heading
 */
$current_field_errors = $Session->get_form_field_errors('heading')
?>
<div class="form-group  <?php if (!empty($current_field_errors)){echo 'has-error';}?>">
    <div class="col-sm-12">
        <label class="control-label" for="heading">Заглавие:</label>
    </div>
    <div class="col-sm-12">
        <input type="text" class="form-control" id="heading" name="heading" value="<?php echo $callout->heading?>" placeholder="Заглавие ...">
    </div>
    <?php
    $Session::display_current_field_errors($current_field_errors);
    ?>
</div>


<?php
/*
 * Area
 */
?>
<div class="form-group">
    <div class="col-sm-12">
        <label class="control-label" for="area">Област:</label>
    </div>
    <div class="col-sm-12">
        <select class="form-control" id="area" name="area">
            <?php
            foreach ($AREAS_IN_BULGARIA as $area) {
                if ($area == $callout->area) {
                    echo "<option selected>" ;
                } else {
                    echo "<option>" ;
                }
                echo $area;
                echo "</option>";
            }

            ?>
        </select>
    </div>
</div>

<?php
/*
 * Creator
 */
$current_field_errors = $Session->get_form_field_errors('description')
?>
<div class="form-group <?php if (!empty($current_field_errors)){echo 'has-error';}?>">
    <div class="col-sm-12">
        <label class="control-label" for="creator">Описание:</label>
    </div>
    <div class="col-sm-12">
        <textarea class="form-control" form="callout_form" id="description" name="description" placeholder="Описание ..."><?php echo $callout->description?></textarea>
    </div>
    <?php
    $Session::display_current_field_errors($current_field_errors);
    ?>
</div>

<?php
/*
 * Creator
 */
$current_field_errors = $Session->get_form_field_errors('creator')
?>
<div class="form-group <?php if (!empty($current_field_errors)){echo 'has-error';}?>">
    <div class="col-sm-12">
        <label class="control-label" for="creator">Създател:</label>
    </div>
    <div class="col-sm-12">
        <input type="text" class="form-control" id="creator" name="creator" value="<?php echo $callout->creator?>" placeholder="Enter username or email">
    </div>
    <?php
    $Session::display_current_field_errors($current_field_errors);
    ?>
</div>

<?php
$Session->clear_form_field_errors();
?>