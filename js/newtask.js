$(document).ready(function(){

    var newtitle = 1;
    var newdescription = 1;

    $(".newtasktitle").click( function() {
        if (newtitle) {
            newtitle = 0;
            $(this).val("");
        }
    });
    $(".newtaskdescription").click( function() {
        if (newdescription) {
            newdescription = 0;
            $(this).val("");
        }
    });

});
