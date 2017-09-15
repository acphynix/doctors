$(function(){
    $.ajax({
       url: "/ajax/get_keywords_jq.php",
       success:function(data){
           var keywords = data.split("__");
            $("#ikeyword_search").autocomplete({
                minLength: 2,
                delay: 0,
                source: keywords
            });
       }
    });
});