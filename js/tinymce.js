$().ready(function(){

    $('textarea.taskdescription').tinymce({
        script_url : $("base").attr("href")+'js/tiny_mce/tiny_mce.js',
        theme : "advanced",
        plugins : "pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist",
        content_css : "css/content.css",

        theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,fontselect,fontsizeselect",
        theme_advanced_buttons2 : "bullist,numlist,outdent,indent,blockquote",
        theme_advanced_buttons3 : "cleanup,removeformat",
        theme_advanced_buttons4 : "",

        theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "left",
        theme_advanced_statusbar_location : "bottom",
        theme_advanced_resizing : true,
    });
    

});
