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
        </div>
    </div>
</div>
<div class="menuline t2">
    <div class="menu1">
    Install Wizard<br />
    </div>
</div>
<div class="main">
<div class="content noborder">
This is the install wizard for itsplanned.com.<br />
<br />
There is not found a valid configuration. Please fill out the form below and generate a default configuration:<br /><br />
<form action="" method="post">
<fieldset>
<input type="hidden" name="install" value="on" />
<table>
<tr>
<td>MySQL Username:</td>
<td><input type="text" name="mysqlusername" /></td>
</tr>
<tr>
<td>MySQL Password:</td>
<td><input type="password" name="mysqlpassword" /></td>
</tr>
<tr>
<td>MySQL Hostname:</td>
<td><input type="text" name="mysqlhostname" value="localhost" /></td>
</tr>
<tr>
<td>MySQL Database:</td>
<td><input type="text" name="mysqldatabase" /></td>
</tr>
<tr>
<td>MySQL Table Prefix:</td>
<td><input type="text" name="mysqlprefix" value="itsp_"/></td>
</tr>
<tr>
<tr>
<td colspan="2"><hr /></td>
</tr>
<td>Host name:</td>
<td><input type="text" name="hostname" value="{$hostname}" /></td>
</tr>
<tr>
<td>Install Path:</td>
<td><input type="text" name="installpath" value="{$installpath}" /></td>
</tr>
<tr>
<td>Pretty URLs:</td>
<td><input type="checkbox" name="prettyurls" checked="checked" /></td>
</tr>
<tr>
<td colspan="2"><hr /></td>
</tr>
<tr>
<td>New user from-email:</td>
<td><input type="text" name="newuseremail" value="{$newuseremail}" /></td>
</tr>
<tr>
<td>Reset password from-email:</td>
<td><input type="text" name="resetpassword" value="{$resetpassword}"/></td>
</tr>
<tr>
<td></td>
<td><input type="submit" value="Generate configuration" name="setdefault" /></td>
</tr>
</table>
</fieldset>
</form>
</div>
{include(file='footerwithright.tpl')}
