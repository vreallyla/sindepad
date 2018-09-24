$("body").on("keyup", "form", function(e){
    if (e.which == 13){
        if ($("#next").is(":visible") && $("fieldset.current").find("input, textarea").valid() ){
            e.preventDefault();
            nextSection();
            return false;
        }
    }
});


$("#next").on("click", function(e){
    nextSection();
});

$("form").on("submit", function(e){
    if ($("#next").is(":visible") || $("fieldset.current").index() < 3){
        e.preventDefault();
    }
});

function goToSection(i){
    setTimeout(
        function()
        {
            $("fieldset:gt("+i+")").removeClass("current bounceOutLeft").addClass("next");
            $("fieldset:lt("+i+")").removeClass("current bounceOutLeft");
            if ($("fieldset.current").index() == 3){
                $("#next").hide();
                $("input[type=submit]").show();
            } else {
                $("#next").show();
                $("input[type=submit]").hide();
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

$("#section-tabs li").on("click", function(e){
    var i = $(this).index();
    if ($(this).hasClass("active")){
        $("fieldset.current").addClass('bounceOutLeft');
        goToSection(i);
    } else {
        swalcustom('isi form yang tersedia terlebih dahulu!','B9F448','3C3C3C');
    }
});