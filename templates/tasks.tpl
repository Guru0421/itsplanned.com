{include(file='headerloggedin.tpl')}
<div class="tasks">
<div class="tasktop">{$tasklist}</div>
{$selectedtask}:
{loop $m_list}
<span>{$sepstart}<a class="bold linkimp" href="{$breadcrumburl}">{$breadcrumbitem}</a>{$sepend}</span>
{/loop}
<div class="activewrapper leftmargin">
<div class="activetitle"><span class="bold">{$task}:</span> {$taskname}</div>
<div class="activetitle"><span class="bold">{$description}:</span> {$taskdescription}</div>
</div>
<div class="newtask"><a href="{$newtaskurl}">{$newtask}</a></div>
<div class="hand movehere {$moveherevisible}">{$movetaskshere}</div>
<div class="tasklistoption">
    {$options} <img src="images/downarrows.png" />
    <div class="options">
        <div class="showallinfo">{$showallinfo} <input type="checkbox" class="showallinfocheck" {$showallinfochecked}/></div>
        <div class="showcompactmode">{$showcompactmode} <input type="checkbox" class="showcompactmodecheck" {$showcompactmodechecked}/></div>
        <div class="showclosed">{$showclosedtasks} <input type="checkbox" class="showclosedcheck" {$showclosedchecked}/></div>
    </div>
</div>
<div class="clear"></div>
<div class="tasklist">
{loop $p_list}
    <div id={$liid} class="leftmargin {$liclass} {$state}">
        <div class="tt">
            <div class="tasktitle"><a class="tasktitle1" href="{$taskurl}">{$licontent}</a> <a href="{$edittaskurl}"><span class="whitelink taskedit">({$edittask})</span></a></div>
            <div class="taskdescription">{$taskdescription}</div>
            <div class="taskstatus">
                {$statustxt}: <span onclick="javascript:switchopentask('{$id}');" class="bold switchopen hand link">{$status}</span> | 
                {$createdtxt}: {$created} | {$subtaskstxt}: {$subtasks} | 
                {$opensubtaskstxt}: {$opensubtasks} | 
                <span class="togglefields link bold {$toggleonoff}">{$toggleinfomsg}</span> | 
                <span onclick="javascript:movethistask('{$id}');" class="moveable link hand bold {$moveableonoff}">{$moveablemsg}</span>
            </div>
        </div>
        <div class="taskdraghandle"><img src="images/move.png"></div>
        <div class="clear"></div>
    </div>
{/loop}
</div>

</div>
</div>
{include(file='footer.tpl')}
