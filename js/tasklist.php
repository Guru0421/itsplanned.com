<?
    include_once("../init_backend.php");
    $init = new init_backend();

    $openmsg    = $init->bLang->getLL("open");
    $closedmsg  = $init->bLang->getLL("closed");

    $movethis       = $init->bLang->getLL("page.tasks.movethis");
    $dontmovethis   = $init->bLang->getLL("page.tasks.dontmovethis");

    $thisTask = $_GET["t"];
?>


$(document).ready(function(){
        $(".tasklist").sortable({
            handle: '.taskdraghandle',
            placeholder: 'ui-state-highlight',
            zIndex: 5,
            update: function(event, ui) {
                $(".tasklist").children("div").removeClass("zebraeven");
                $(".tasklist").children("div").removeClass("zebraodd");
                $(".tasklist").children("div:even").addClass("zebraeven");
                $(".tasklist").children("div:odd").addClass("zebraodd");

                var info = $(this).sortable("serialize");
                $.ajax({
                    type: "POST",
                    data: info,
                    url:  $("base").attr("href")+"js/updateSorting.php",
                    dataType: "script"
                });
            }
        });

        $(".tasklist").children("div:even").addClass("zebraeven");
        $(".tasklist").children("div:odd").addClass("zebraodd");

        if ($(".showallinfocheck").attr("checked")) {
            $(".taskdescription").show();
        } else {
            $(".taskdescription").hide();
        }
        if ($(".showclosedcheck").attr("checked")) {
            $(".tasklist .closed").show();
        } else {
            $(".tasklist .closed").hide();
        }
        if ($(".showcompactmodecheck").attr("checked")) {
            $(".tasklist .taskstatus").hide();
        } else {
            $(".tasklist .taskstatus").show();
        }

        $('.tasklist').show();


        $(".taskdraghandle").mousedown( function() {
            $(this).parent().css("opacity", "0.5");
        });
        $(".taskdraghandle").mouseup( function() {
            $(this).parent().css("opacity", "1");
        });

        $(".tasklistoption").css("width", $(".tasklistoption .options").width()+10);

        $(".togglefields").click( function() {
            var t = $(this).parent().parent().children(".taskdescription");
            if (t.is(":visible")) {
                t.slideUp('fast');
            } else {
                t.slideDown('fast');
            }
        });

        $(".showallinfocheck").click( function() {
            if ($(this).attr("checked")) {
                $(".taskdescription").slideDown();
                setUserSetting("showAllField", "on");
            } else {
                $(".taskdescription").slideUp();
                setUserSetting("showAllField", "off");
            }
        });
        $(".showclosedcheck").click( function() {
            if ($(this).attr("checked")) {
                $(".tasklist .closed").fadeIn();
                setUserSetting("showClosedTasks", "on");
            } else {
                $(".tasklist .closed").fadeOut();
                setUserSetting("showClosedTasks", "off");
            }
        });
        $(".showcompactmodecheck").click( function() {
            if ($(this).attr("checked")) {
                $(".tasklist .taskstatus").hide();
                setUserSetting("showCompactMode", "on");
            } else {
                $(".tasklist .taskstatus").show();
                setUserSetting("showCompactMode", "off");
            }
        });

        $(".movehere").click( function() {
            $.ajax({
                type: "POST",
                data: "moveto=<?=$thisTask?>",
                url:  $("base").attr("href")+"js/movetask.php",
                dataType: "script"
           });
        });

        $(".tasklistoption").mouseenter( function() {
            $(this).children(".options").show();   
        });
        $(".tasklistoption").mouseleave( function() {
            $(this).children(".options").hide();   
        });

//        $(".movehere").css("margin-left", $("main").width()/2+"px");


        function setUserSetting(field, value) {
            $.ajax({
                type: "POST",
                data: "field="+field+"&value="+value,
                url:  $("base").attr("href")+"js/updateUserSetting.php",
                dataType: "script"
           });
        }

});

        function movethistask(task) {
            $.ajax({
                type: "POST",
                data: "task="+task,
                url:  $("base").attr("href")+"js/movetask.php",
                success: function(msg){
                    var s = msg.split("-");
                    $(".movecount").html(s[1]);
                    if (s[0] == "off") {
                        $("#liid_"+task+ " .moveable").html('<?=$movethis?>');
                    } else if (s[0] == "on") {
                        $("#liid_"+task+ " .moveable").html('<?=$dontmovethis?>');
                    }
                    if (s[1] > 0) {
                        $(".movehere").show();
                    } else {
                        $(".movehere").hide();
                    }
                }
           });
        }

        function switchopentask(task) {
            $("#liid_"+task).toggleClass("open");   
            $("#liid_"+task).toggleClass("closed");   

            var state = "100";
            if ($("#liid_"+task).hasClass("open")) {
                $("#liid_"+task+ " .switchopen").html('<?=$openmsg?>');
                state = "0";
            } else {
                $("#liid_"+task+ " .switchopen").html('<?=$closedmsg?>');
            }

            $.ajax({
                type: "POST",
                data: "task="+task+"&progress="+state,
                url:  $("base").attr("href")+"js/updateTask.php",
                dataType: "script"
           });
           
        }
