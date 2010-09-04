{include(file='header.tpl')}
<div class="language">
<select name="language">
     {loop $language_list}
    <option value="{$value}">{$language}</option>
     {/loop}
    </select>
</div>
{include(file='footer.tpl')}
