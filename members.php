<?php

require_once 'header.php';

if (!$loggedin) 
die('</div></body></html>');

if (isset($_GET['view']))
{
    $view = sanitizeString($_GET['view']);

    if ($view == $user )
        $name = "Your";
    else
        $name = "$user's";

    echo "<h3>$name profile</h3>";
    showProfile($view);
    echo "<a class='button' data-transition='slide' href='messages.php?view=$view'>$name messages</a>";
    die('</div></body></html>');
}

if (isset($_GET['add']))
{
    $add = sanitizeString($_GET['add']);

    $result = queryMysql("SELECT * FROM friends WHERE user='$add' AND friend='$user'");
    if (!$result->num_rows)
        queryMysql("INSERT INTO friends VALUES('$add','$user')");
}
elseif (isset($_GET['remove']))
{   
    $remove = sanitizeString($_GET['remove']);
    $result = queryMysql("DELETE FROM friends WHERE user='$remove' AND friend='$user'");
}

$result = queryMysql("SELECT user FROM members ORDER BY user");
$num = $result->num_rows;

echo "<h2>all members</h3><ul>";

for ($i=0;$i<$num;$i++)
{
    $row = $result->fetch_array(MYSQLI_ASSOC);
    if ($row['user'] == $user) continue;

    echo "<li><a data-transition='slide' href='members.php?view=" . $row['user'] . "'>" . $row['user'] . "</a>";
    

    $result1 = queryMysql("SELECT * FROM friends WHERE user='" . $row['user'] . "' AND friend='$user'");
    $t1 = $result1->num_rows;
    $result1 = queryMysql("SELECT * FROM friends WHERE friend='" . $row['user'] . "' AND user='$user'");
    $t2 = $result1->num_rows;

    $follow = "follow";
    if ($t1 + $t2 > 1)
    echo " is your friend";
    elseif ($t1)
    echo " is followed by you";
    elseif ($t2)
    {
        echo " is following you";
    $follow = "recip";
    }

    if (!$t1) 
        echo " [<a data-transition='slide' href='members.php?add=" . $row['user'] . "'>$follow</a>]";
    else   
        echo " [<a data-transition='slide' href='members.php?remove=" . $row['user'] . "'>delete</a>]";
}
?>

        </ul></div>
    </body>
</html>
