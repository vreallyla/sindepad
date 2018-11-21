
$("form").on("submit", function(e){
    if ($("#next").is(":visible") || $("fieldset.current").index() < 2){
        e.preventDefault();
    }
});

function goToSection(i){

        setTimeout(
            function()
            {
                $("fieldset:gt("+i+")").removeClass("current bounceOutLeft").addClass("next");
                $("fieldset:lt("+i+")").removeClass("current bounceOutLeft");
                if ($("fieldset.current").index() === 2){
                    $("#next").hide();
                } else {
                    $("#next").show();
                }
            }, 500);

        $("#section-tabs li").eq(i).addClass("current").siblings().removeClass("current");
        setTimeout(function(){
            $("fieldset").eq(i).removeClass("next").addClass("current active bounceInRight");
            $("fieldset").eq(i-1).addClass("bounceOutLeft");

        }, 80);
}

function nextSection(){
    var i = $("fieldset.current").index();
    if (i < 3){
        $("#section-tabs li").eq(i+1).addClass("active");
        goToSection(i+1);
    }
}
