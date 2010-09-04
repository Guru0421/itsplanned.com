{include(file='headerloggedin.tpl')}
<div class="myinfo">
<div class="error">{$pageMyinfoErrorMsg}</div>
<form action="{$myinfourl}" method="post">
<fieldset>
<table>
<tr><td class="{$usernameError}">{$pageMyinfoUsername}:</td><td><input name="username" type="text" value="{$username}" />*</td></tr>
<tr><td class="{$passwordError}">{$pageMyinfoNewPassword}:</td><td><input name="password" type="password" value="{$password}" />*</td></tr>
<tr><td class="{$passwordError}">{$pageMyinfoNewPasswordRepeat}:</td><td><input name="repeatpassword" type="password" value="{$password}" />*</td></tr>
<tr><td class="{$emailError}">{$pageMyinfoEmail}:</td><td><input type="text" name="email" value="{$email}" />*</td></tr>
<tr><td class="{$realnameError}">{$pageMyinfoRealname}:</td><td><input type="text" name="realname" value="{$realname}" /></td></tr>
<tr><td class="">{$pageMyinfoLayoutLanguage}:</td><td><select name="language"><option value="en" {$languageset} {$languageseten}>English</option><option {$languagesetdk} value="dk">Dansk</option></select></td></tr>
<tr><td></td><td><input type="submit" value="{$pageMyinfoUpdate}" /></td></tr>
</table>
</fieldset>
</form>
</div>
</div>
{include(file='footer.tpl')}
