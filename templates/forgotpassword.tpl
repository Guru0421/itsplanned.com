{include(file='header.tpl')}
<div class="content">
Forgot your password? <span class="emailedok">{$emailsent}</span><br />
<br />
Enter your username or emailadress and you will receive a email with a reset option:
<form action="{$url}" method="post">
Username / Email: <input type="username" name="username" />
<input type="submit" value="Send it" />
</form>
</div>
{include(file='footerwithright.tpl')}
