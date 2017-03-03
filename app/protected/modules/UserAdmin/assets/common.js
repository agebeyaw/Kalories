$(function(){
        $('.hide-on-click').on('click', function(){
                $(this).slideUp();
        });

        /*=========== Controllers ===========*/

        // Toggle controller actions
        $('.commonControllerName').on('click', function(){
                $('.commonController' + $(this).attr('param')).toggle();
        });

        // Show all common controllers
        $('.commonOpener').on('click', function(){
                $('.commonControllerHide').show();
        });

        // Hide all common controllers
        $('.commonHider').on('click', function(){
                $('.commonControllerHide').hide();
        });


        /*=========== Module ===========*/

        // Toggle controller actions
        $('.moduleControllerName').on('click', function(){
                $('.moduleController' + $(this).attr('param')).toggle();
        });


        // Show all common controllers
        $('.moduleOpener').on('click', function(){
                $('.module' + $(this).attr('param')).show();
        });

        // Hide all common controllers
        $('.moduleHider').on('click', function(){
                $('.module' + $(this).attr('param')).hide();
        });

});
