<?php
require_once 'header.php';

if (!$loggedin) die("</div></body></html>");

if (isset($_GET['view']))
    $view = sanitizeString($_GET['user']);
else
    $view = $user;

if ($view == $user)
{
    $name1 = $name2 = "Your";
    $name3 = "You are";
}
else
{
    $name1 = "<a data-transition='slide' href='members.php?view=$view'>$view</a>'s";
    $name2 = "$view's";
    $name3 = "$view is";
}

$followers = array();
$following = array();

$result = queryMysql("SELECT * FROM friends WHERE user='$view'");
$num = $result->num_rows;

for ($i=0; $i<$num; $i++)
{
    $row = $result->fetch_array(MYSQLI_ASSOC);
    $followers[$i] = $row['friend'];
}

$result = queryMysql("SELECT * FROM friends WHERE friend='$view'");
$num = $result->num_rows;

for ($i=0; $i<$num; $i++)
{
    $row = $result->fetch_array(MYSQLI_ASSOC);
    $following[$i] = $row['user'];
}

$mutual = array_intersect($followers,$following);
$followers = array_diff($followers,$mutual);
$following = array_diff($following,$mutual);
$friends = false;

echo "<br>";

if (sizeof($mutual))
{
    echo "<span class='subhead'>$name2 mutual friends</span><ul>";
    foreach ($mutual as $friend)
        echo "<li><a data-transition='slide' href='members.php?view=$friend'>$friend</a></li>";
    echo "</ul>";
    $friends = true;
}

if (sizeof($followers))
{
    echo "<span class='subhead'>$name2 followers</span><ul>";
    foreach ($followers as $follower)
        echo "<li><a data-transition='slide' href='members.php?view=$follower'>$follower</a></li>";
    echo "</ul>";
    $friends = true;
}

if (sizeof($following))
{
    echo "<span class='subhead'>$name2 outcomig requests</span><ul>";
    foreach ($following as $follow)
        echo "<li><a data-transition='slide' href='members.php?view=$follow'>$follow</a></li>";
    echo "</ul>";
    $friends = true;
}

if (!$friends)
    echo "<br><h4>You have no friends yet</h4><br>";

echo "<a data-role='button' data-transition='slide' href='messages.php?view=$view'>View $name2 messages</a>";
?>
</div>
</body>
</html>