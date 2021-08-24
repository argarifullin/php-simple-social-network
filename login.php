<?php
require_once 'header.php';
$error = $user = $pass = "";

if (isset($_POST['user']))
{
    $user = sanitizeString($_POST['user']);
    $pass = sanitizeString($_POST['pass']);

    if ($user == "" || $pass == "")
        $error = 'enter fields';
    else
    {
        $result = queryMysql("SELECT user,pw FROM members WHERE user='$user' AND pw='$pass'");

        if ($result->num_rows == 0)
        {
            $error = "invalid user or password";
        }
        else
        {
            $_SESSION['user'] = $user;
            die("You are now logged in <a data-transition='slide' href='members.php?view=$user'>continue</a></div></body><?html>");
        }
    }
}

echo <<<_END
<form method='post' action='login.php'>
    <div data-role='fieldcontain'>
        <label></label>
        <span class='error'>$error</span>
    </div>
    <div data-role='fieldcontain'>
        <label></label>
        Please enter username and password
    </div>
    <div data-role='fieldcontatin'>
        <label>Username</label>
        <input type='text' maxlength='16' name='user' value='$user'>
    </div>
    <div data-role='fieldcontain'>
        <label>Password</label>
        <input type='password' maxlength='16' name='pass' value='$pass'>
    </div>
    <div data-role='fieldcontain'>
        <label></label>
        <input data-transition='slide' type='submit' value='login'>
    </div>
</form>
</div>
</body>
</html>
_END
?>