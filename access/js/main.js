jQuery(document).ready(function($) {
    $('#form').submit(function() {
        event.preventDefault();
        $.ajax({
            type: 'POST',
            url: '/wp-content/plugins/realty-test-task/search-property.php',
            data: $('#form').serialize(),
            success: function (data) {
                $('.filter__view').css('display','block');
                $('.filter__view').append(data);
            }
        });
    });


    $(document).on('click','.page-block a', function(){
        event.preventDefault();
        var page = $(this).attr('href');
        console.log(page);
        $(this).closest('#form').find('#page').attr('value',page);
        $.ajax({
            type: 'POST',
            url: '/wp-content/plugins/realty-test-task/search-property.php',
            data: $('#form').serialize(),
            success: function (data) {

                $('.filter__view').html(data);
            }
        });
    });




});