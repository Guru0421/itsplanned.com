{include(file='header.tpl')}
<div class="content">
Please type in your new password:
<div class="error">{$errormsg}</div>
<form action="{$url}" method="post">
<input type="hidden" name="reset" value="{$reset}" />
Password: <input type="password" name="password" value="        " />
<input type="submit" value="Login" />
</form>
</div>
<div class="rightside"></div>
<div class="clear"></div>
</div>
{include(file='footer.tpl')}
