<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="da_DK" lang="da_DK">
<head>
<base href="{$basehref}" />
<title>{$headertitle} - ItsPlanned.com</title>
<link rel="stylesheet" href="css/style.css" type="text/css" />
{loop $css_list}
<link rel="stylesheet" href="{$cssfile}" type="text/css" />
{/loop}

<script type="text/javascript" src="js/jquery.js"></script>
{loop $js_list}
<script type="text/javascript" src="{$jsfile}"></script>
{/loop}

</head>
<body>
<div class="header">
<div class="maincenter">
<div class="logo">
<a href="{$rooturl}"><img src="images/itsplogo2.png" alt="ItsPlanned Logo" /></a>
</div>
<div class="loginerror">{$loginerror}</div>
<div class="login t1">
<form action="{$loggedinurl}" method="post">
<table>
    <tr>
        <td class="loginfield">{$username}:</td>
        <td><input type="text" name="username" value="" /></td>
        <td></td>
    </tr>
    <tr>
        <td class="loginfield">{$password}:</td>
        <td><input type="password" name="password" value="" /></td>
        <td><input type="submit" name="login" value="{$loginbtn}" /></td>
    </tr>
</table>    
</form>
</div>
</div>
</div>
<div class="menuline t2">
<div class="menu1">
<a href="{$rooturl}">Home</a>
</div>
<div class="right">
<div class="menu1">
    <a href="{$newuserurl}">Create new user</a>
</div>
<div class="menu1"></div>
<div class="menu1">
    <a href="{$forgotpasswordurl}">Forgot password?</a>
</div>
</div>
</div>
<div class="main">
