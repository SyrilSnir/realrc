
$(function(){
    window.select_point = function(a){
        alert('select');
    }
    $('#carrierTable input').on('change',function() {         
        var $selectedItem = $(this);
            $btnNext = $('.cart_navigation > input.exclusive'),
            $bxContainer = $('.bx_container'),
            $bxList = $('#pickups_list');
        console.log($selectedItem);
        if ($selectedItem.hasClass('boxberry')) {
            $btnNext.attr('disabled','');
            $btnNext.addClass('exclusive_disabled');
            if (!$bxContainer.hasClass('loaded')) {
                $bxContainer.addClass('loaded');
            }
            $bxContainer.removeClass('hide');           
        } else {
            $bxContainer.addClass('hide');
        }
    });
});

