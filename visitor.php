<?php
//if it's an unegistered user, then it will first destory the previous session.
session_start();
session_unset();
session_destroy();
header("Location:interface.php");
exit;
?>