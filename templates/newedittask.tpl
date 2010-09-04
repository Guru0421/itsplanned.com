{include(file='headerloggedin.tpl')}
{$selectedtask}:
{loop $m_list}
<span>{$sepstart}<a class="bold linkimp" href="{$breadcrumburl}">{$breadcrumbitem}</a>{$sepend}</span>
{/loop}
<div class="newedittask">

    <form class="taskform" action="{$submiturl}" method="post">
    <fieldset>
    <input type="hidden" name="func" value="{$func}" />
    <input type="hidden" name="taskid" value="{$taskid}" />
    {$tasktitletxt}:<br />
    <input type="input" value="{$tasktitle}" name="tasktitle" class="tasktitle" /><br />
    {$taskdescriptiontxt}:
    <br /> <textarea name="taskdescription" class="taskdescription">{$taskdescription}</textarea><br />
    {$taskprogress}:
    <br /> <select name="taskprogress" class="taskprogress">
    <option {$t0} value="0">0 % ({$tasknotstarted})</option>;
    <option {$p10} value="10">10 %</option>;
    <option {$p20} value="20">20 %</option>;
    <option {$p30} value="30">30 %</option>;
    <option {$p40} value="40">40 %</option>;
    <option {$p50} value="50">50 %</option>;
    <option {$p60} value="60">60 %</option>;
    <option {$p70} value="70">70 %</option>;
    <option {$p80} value="80">80 %</option>;
    <option {$p90} value="90">90 %</option>;
    <option {$p100} value="100">100 % ({$taskfinished})</option>;
    </select><br />
    <input type="submit" name="submit" value="{$submitbtn}">
    </fieldset>
    </form>
    
</div>
</div>
{include(file='footer.tpl')}
