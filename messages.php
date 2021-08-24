<?php
require_once 'header.php';

if (!$loggedin) die("</div></body></html>");

if (isset($_GET['view'])) 
    $view = sanitizeString($_GET['view']);
else
    $view = $user;

if (isset($_POST['text']))
{
    $text = sanitizeString($_POST['text']);

    if ($text != '')
    {
        $pm = substr(sanitizeString($_POST['pm']),0,1);
        $time = time();
        queryMysql("INSERT INTO messages VALUES(NULL,'$user','$view','$pm','$time','$text')");
    }
}

if ($view != '')
{
    if ($view == $user) 
        $name1 = $name2 = "Your";
    else   
    {
        $name1 = "<a href='members.php?view=$view'>$view</a>'s";
        $name2 = "$view's";
    }

    echo "<h4> $name1 messages</h4>";
    showProfile($view);

    echo <<<_END
    <form method='POST' action='messages.php?view=$view'>
    <fieldset data-role='controlgroup' data-type='horizontal'>
        <legend>Type here your message</legend>
        <input type='radio' name='pm' id='public' value='0' checked='checked'>
        <label for='public'>Public</label>
        <input type='radio' name='pm' id='private' value='1'>
        <label for='Private'>Private</label>
    </fieldset>
    <textarea name='text'></textarea>
    <input data-transition='slide' type='submit' value='Send message'>
    </form>
    <br>
    _END;

    date_default_timezone_set('Europe/Moscow');

    if (isset($_GET['erase']))
    {
        $erase = sanitizeString($_GET['erase']);
        queryMysql("DELETE FROM messages WHERE id=$erase AND recip='$user'");
    }

    $query = "SELECT * FROM messages WHERE recip='$view' ORDER BY time DESC";
    $result = queryMysql($query);
    $num = $result->num_rows;

    for ($i=0;$i < $num; $i++)
    {
        $row = $result->fetch_array(MYSQLI_ASSOC);

        if ($row['pm'] == 0 || $row['auth'] == $user || $row['recip'] == $user)
        {
            echo date('M jS \'y g:ia', $row['time']);
            echo " <a href='messages.php?view=" . $row['auth'] . "'>" . $row['auth'] . "</a> to " . $row['recip'] . " ";

            if ($row['pm'] == 0)
                echo "wrote: " .$row['message'];
            else    
                echo "whispered: <span class='whisper'>" . $row['message'] . "</span> ";
            
            if ($row['recip'] == $user)
                echo "[<a href='messages.php?view=$view" . "&erase=" . $row['id'] . "'>erase</a>]";

            echo "<br>";
        }
    }
}

if (!$num)
    echo "<br><span class='info'> No messages yet</span><br><br>";

echo "<br><a data-role='button' href='messages.php?view=$view'>Refresh messages</a>";
?>

</div><br>
</body>
</html>