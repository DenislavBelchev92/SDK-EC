<?php
   // Unset all gloabal session variables();
    session_unset();

   // destroys current session();
    session_destroy();

   echo ("YOU are no longer logged in!");

?>

<!DOCTYPE html>

<html>

<head>
  <meta http-equiv="refresh" content="5;url=index.php" />
</head>

<body>

</body>
</html>