<?xml version="1.0" encoding="iso-8859-1"?>
<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="da_DK" lang="da_DK"><html>
<head>
<title>{$headertitle} - ItsPlanned.com</title>
<base href="{$basehref}" />
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
<img src="images/itsplogo2.png" />
</div>
<div class="login">
<span class="bold1">{$headerLoggedinas} <a href="{$myinfourl}" class="linkimp">{$username}</a></span> - <a href="{$logouturl}" class="bold linkimp">{$headerLogout}</a>
</div>
</div>
</div>
<div class="menuline">
    <div class="right">
        <div class="menu1"><a href="{$myinfourl}">{$headerMyInfo}</a></div>
        <div class="menu1"><a href="{$tasksurl}">{$headerMyTasks}</a></div>
    </div>
</div>
<div class="main">
