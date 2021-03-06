<?php
require_once 'header.php';

if (!$loggedin) die("</div></body></html>");

echo "<h3>Profile<h3>";


$result = queryMysql("SELECT * FROM profiles WHERE user='$user'");

if (isset($_POST['text']))
{
    $text = sanitizeString($_POST['text']);
    $text = preg_replace('/\s\s+/',' ',$text);

    if ($result->num_rows)
        queryMysql("UPDATE profiles SET text='$text' WHERE user='$user'");
    else queryMysql("INSERT INTO profiles VALUES('$user','$text')");
}
else
{
    if ($result->num_rows)
    {
        $row = $result->fetch_array(MYSQLI_ASSOC);
        $text = stripslashes($row['text']);
    }
    else $text = "";
}

$text = stripslashes(preg_replace('/\s\s+/',' ',$text));

if (isset($_FILES['image']['name']))
{
    $saveto = "$user.jpg";
    move_uploaded_file($_FILES['image']['tmp_name'], $saveto);
    $typeok = true;

    switch ($_FILES['image']['type'])
    {
        case "image/gif" : $src = imagecreatefromgif($saveto);break;
        case "image/jpeg" : 
        case "image/pjpeg" : $src = imagecrearefromjpeg($saveto); break;
        case "image/png" : $src = imagecreatefrompng($saveto); break;
        default : $typeok = false; break;
    }

    if ($typeok)
    {
        list($w,$h) = getimagesize($saveto);

        $max = 100;
        $tw = $w;
        $th = $h;

        if ($w > $h && $max < $w)
        {
            $th = $max / $h * $w;
            $tw = $max;
        }
        elseif ($h > $w && $max < $h)
        {
            $tw = $max / $h * $w;
            $th = $max;
        }
        elseif ($max < $w)
        {
            $tw = $th = $max;
        }

        $tmp = imagecreatetruecolor($tw,$th);
        imagecopyresampled($tmp, $src,0,0,0,0,$tw,$th,$w,$h);
        imageconvolution($tmp, array(array(-1,-1,-1),array(-1,16,-1),array(-1,-1,-1)), 8, 0);
        imagejpeg($tmp,$saveto);
        imagedestroy($tmp);
        imagedestroy($src);
    }
}

showProfile($user);

echo <<<_END
<form method='POST' data-ajax='false' action='profile.php' enctype='multipart/form-data'>
    <h3>Edit your profile</h3>
    <textarea name='text'>$text</textarea>
    <br>
    Image: <input type='file' name='image' size='14'>
    <input type='submit' value='save'>
</form>
</div>
<br>
</body>
</html>
_END


?>