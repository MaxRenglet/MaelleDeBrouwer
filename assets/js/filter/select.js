import $ from 'jquery';
import 'select2'; // globally assign select2 fn to $ element
import 'select2/dist/css/select2.css';


const parent = document.querySelector('section.filters');

if (parent) {

    $( document ).ready(function() {
       

        $.ajax({
            url: themosis.ajaxurl, // Global access to the WordPress ajax handler file
            type: 'POST',
            data: {
                action: 'filter', // Your custom hook/action name
                security: themosis.nonce, // A nonce value defined by the user with the "add-posts" action
                post_type:cpt
            }
        }).done(function (data) {
            $('.result').html(data);
        });

    });


    var cpt = parent.getAttribute('data-cpt');
    $('.each_filter').select2({
        placeholder: 'Selectionner une option',
        width: '100%',
        minimumResultsForSearch: -1
    });

    $('.each_filter').on("change.select2", function (e) {

        var cats = [];
        $('.category_filter').find(":selected").each(function () {
            cats.push($(this).val());
        })

        var tags = [];
        $('.tag_filter').find(":selected").each(function () {
            tags.push($(this).val());
        })

        var order = $('.order_filter').find(":selected").val();

        $.ajax({
            url: themosis.ajaxurl, // Global access to the WordPress ajax handler file
            type: 'POST',
            data: {
                action: 'filter', // Your custom hook/action name
                security: themosis.nonce, // A nonce value defined by the user with the "add-posts" action
                cat_val: cats,
                tag_val: tags,
                order:order,
                post_type:cpt
            }
        }).done(function (data) {
            $('.result').html(data);
        });


    });

}