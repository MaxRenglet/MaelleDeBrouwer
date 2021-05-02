import $ from 'jquery';

const x1 = '16px';
const x2 = '32px';
const x3 = '48px';

$(document).ready(function() {

    $('input[type=radio][name=font_size_selector]').change(function() {
        if($(this).val() == 0){
            $('html').css('font-size', x1);
        } else if ($(this).val() == 1){
            $('html').css('font-size', x2);
        } else if ($(this).val() == 2){
            $('html').css('font-size', x3);
        }
    })

});