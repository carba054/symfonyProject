
function imgType(type) {

    $('img.type').not('.type'+type).css({"width": "200px", "height": "100px"});
    $('input:radio.type').attr('checked', false);
    $('.type'+type).eq(0).css({"width": "400px", "height": "200px"});
    $('.type'+type).eq(1).attr('checked', true);

}


function imgMagic(magic) {

    $('img.magic').not('.magic'+magic).css({"width": "128px", "height": "128px"});
    $('input:radio.magic').attr('checked', false);
    $('.magic'+magic).eq(0).css({"width": "155px", "height": "155px"});
    $('.magic'+magic).eq(1).attr('checked', true);

}
function createNext(next) {


     $('.form-group').addClass( "hidden");
     $('#'+next).removeClass( "hidden" );
}

function byStats(e) {
    let money = Number($('.money').html());
    let stats = Number($('td.'+e).html());
    let sum = stats*3;
        stats ++;
        money -= sum;
        if(money >= 0){
            $('td.'+e).html(stats);
            $('input.'+e).val(stats);
            $('span.'+e).html(stats*3);
            $('span.money').html(money);
            // $('input.money').val(money);
        }
}


$( document ).ready(function() {
    $('#reportView > tbody > tr > td:empty').parent().hide();
});


$(document).ready(function (e) {
    
    $("#type1").click(function(){
       $(".type1").show();
        $(".type0").hide()
        $(".type0 input").attr('value', 0);

    });
    $("#type0").click(function(){
        $(".type0").show();
        $(".type1").hide()
        $(".type1 input").attr('value', 0);
    });


});

function myFunction() {
    var popup = document.getElementById("myPopup");
    popup.classList.toggle("show");
}
