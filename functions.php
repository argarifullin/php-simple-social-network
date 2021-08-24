<?php
//db connect
$hn = 'localhost';
$db = 'test';
$un = 'root';
$pw = 'root';

$link = new mysqli($hn,$un,$pw,$db);
if ($link->connection_error) die("Connection Error");

function createTable($name,$query)
{
    queryMysql("CREATE TABLE IF NOT EXISTS $name($query)");
    echo "Table $name created<br>";
}

function queryMysql($query)
{
    global $link;
    $result = $link->query($query);
    if (!$result) die ("Query error");
    return $result;
}

function destroySession()
{
    $_SESSION = array();
    if (session_id() != "" || isset($_COOKIE[session_name()]))
        setcookie(session_name(), '', time() - 10000,'/');
    session_destroy();
}

function sanitizeString($var)
{
    global $link;
    $var = strip_tags($var);
    $var = htmlentities($var);
    $var = stripslashes($var);
    return $link->real_escape_string($var);
}

function showProfile($user)
{
    if (file_exists("$user.jpg"))
        echo "<img src='$user.jpg' align='left'>";
    
    $result = queryMysql("SELECT * FROM profiles WHERE user='$user'");

    if ($result->num_rows)
    {
        $row = $result->fetch_array(MYSQLI_ASSOC);
        echo stripslashes($row['text']) . "<br style='clear:left;'><br>";
    }
    else echo "<p> no info</p><br>";
}

?>