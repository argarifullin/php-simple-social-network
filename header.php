<?php
session_start();
require_once 'functions.php';

echo <<<_INIT
<!DOCTYPE html> 
<html>
  <head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1'> 
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jquerymobile/1.4.5/jquery.mobile.min.css">
    <link rel='stylesheet' href='styles.css' type='text/css'>
    <script src='OSC.js'></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquerymobile/1.4.5/jquery.mobile.min.js"></script>
_INIT;

$userstr = "Welcome guest";

if (isset($_SESSION['user']))
{
  $user = $_SESSION['user'];
  $loggedin = true;
  $userstr = "Welcome $user";
}
else
  $loggedin = false;

echo <<<_MAIN
<title>$userstr</title>
</head>
<body>
    <div data-role='page'>
        <div data-role='header'>
            <div id='logo' class="center">
                 hello
            </div>
            <div class='username'>
                $userstr
            </div>
        </div>
        <div data-role='content'>
_MAIN;

if ($loggedin)
{
  echo <<<_LOGGEDIN
  <div class='center'>
  <a data-role='button' data-inline='true' data-icon='home' data-transition='slide' href='members.php?view=$user'>Home</a>
  <a data-role='button' data-inline='true' data-transition='slide' href='members.php'>Users</a>
  <a data-role='button' data-inline='true' data-transition='slide' href='friends.php'>Friends</a>
  <a data-role='button' data-inline='true' data-transition='slide' href='messages.php'>Messages</a>
  <a data-role='button' data-inline='true' data-transition='slide' href='profile.php'>Edit profile</a>
  <a data-role='button' data-inline='true' data-transition='slide' href='logout.php'>Log out</a>
</div>
_LOGGEDIN;
}
else
{
  echo <<<_GUEST
  <div class='center'>
    <a data-role='button' data-inline='true' data-icon='home' data-transition='slide' href='index.php'>Home</a>
    <a data-role='button' data-inline='true' data-icon='plus' data-transition='slide' href='signup.php'>Sign up</a>
    <a data-role='button' data-inline='true' data-icon='check' data-transition='slide' href='login.php'>Log in</a>
</div>
<p class='info'>Please log in</p>
_GUEST;
}
?>