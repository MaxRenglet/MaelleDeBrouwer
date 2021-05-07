import $, {
    contains
} from 'jquery';

const parent = document.querySelector('.container.single');

if (parent) {


    var element_position = $('.content_single').offset().top;

    $(window).on('scroll', function () {

        var y_scroll_pos = window.pageYOffset;
        var scroll_pos_test = (element_position - 150);
        var h = $('.side_single').height();
        var related = document.querySelector('section.related');
        // console.log(isScrolledIntoView(related));
        var w = document.body.clientWidth;


 
            
            if (y_scroll_pos > scroll_pos_test) {
      
                $('.side_single').show();
                
            } else {
                $('.side_single').hide();
            }
       

    });



}


function isScrolledIntoView(el) {
    var rect = el.getBoundingClientRect();
    var elemTop = rect.top - 200;
    var elemBottom = rect.bottom;

    // Only completely visible elements return true:
    var isVisible = (elemTop >= 0) && (elemBottom <= window.innerHeight);
    // Partially visible elements return true:
    //isVisible = elemTop < window.innerHeight && elemBottom >= 0;
    return isVisible;
}