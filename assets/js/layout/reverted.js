import $ from 'jquery';

$(document).ready(function() {
    //set initial state.
    $('.reverse').val(this.checked);

    $('.reverse').change(function() {
        if(this.checked) {
            $('body').addClass('reverse');
        } else {
            $('body').removeClass('reverse');
        }
            
    });
});