
function imgType(type) {

    $('img.type').not('.type'+type).css({"width": "200px", "height": "100px"});
    $('input:radio.type').attr('checked', false);
    $('.type'+type).eq(0).css({"width": "400px", "height": "200px"});
    $('.type'+type).eq(1).attr('checked', true);

}


function imgMagic(magic) {

    $('img.magic').not('.magic'+magic).css({"width": "100px", "height": "50px"});
    $('input:radio.magic').attr('checked', false);
    $('.magic'+magic).eq(0).css({"width": "200px", "height": "100px"});
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


