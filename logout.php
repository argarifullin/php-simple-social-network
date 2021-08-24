<?php
//error_reporting(0);
require_once 'header.php';

if (isset($_SESSION['user']))
{
    destroySession();
    echo "<br><div class='center'>You have been logged out. Click <a href='index.php' data-transition='slide'>here</a> to continue</div>";
}
else die("you are not logged in</div></body></html>");
?>