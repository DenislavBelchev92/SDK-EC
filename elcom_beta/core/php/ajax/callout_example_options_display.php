<?php
include_once "../defines/sql_defs.php";
include_once "../helpers/header.php";
include_once "../helpers/database.php";

$db = new Database();
?>

<?php if(1) :?>
<?php 
$example_input = $_POST["example_form_user_input"];
$query = "SELECT * FROM callout_examples WHERE example_name='$example_input'";
$collout_example_options = $db->select($query);
?>
<?php while($issue = $collout_example_options->fetch_assoc()) :?>
  <div class="issues">
  
	<?php echo $issue['example_name']; ?>


  </div>

<?php endwhile;?>

<?php else :?>
<p>Все още няма докладвани проблеми за този град</p>

<?php endif;?>