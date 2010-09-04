{include(file='header.tpl')}
<div class="content">
Create a new user by filling out the form below.<br />
Registration is FREE and without any limitations.<br />
<div class="error">{$pageMyinfoErrorMsg}</div>
<form action="{$myinfourl}" method="post">
<fieldset>
<table>
<tr><td class="{$usernameError}">{$pageMyinfoUsername}:</td><td><input name="username" type="text" value="{$usernamefield}" />*</td></tr>
<tr><td class="{$passwordError}">{$pageMyinfoNewPassword}:</td><td><input name="password" type="password" value="asdfjkl3" />*</td></tr>
<tr><td class="{$passwordError}">{$pageMyinfoNewPasswordRepeat}:</td><td><input name="repeatpassword" type="password" />*</td></tr>
<tr><td class="{$emailError}">{$pageMyinfoEmail}:</td><td><input type="text" name="email" value="{$email}" />*</td></tr>
<tr><td class="{$realnameError}">{$pageMyinfoRealname}:</td><td><input type="text" name="realname" value="{$realname}" /></td></tr>
<tr><td></td><td><input type="submit" value="{$pageMyinfoUpdate}" /></td></tr>
</table>
</fieldset>
</form>
</div>
{include(file='footerwithright.tpl')}
