<?php
session_start();
require_once 'header.php';

echo "<div class='center'>Welcome,";
if ($loggedin) 
    echo " $user";
else
    echo " guest, please log in or sign up";

echo <<<_END
        </div><br>
    </div>
    <div data-role='footer'>
        <h3> footer </h3>
    </div>
</body>
</html>
_END;
?>