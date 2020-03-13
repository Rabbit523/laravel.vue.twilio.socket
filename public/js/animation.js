        //  $(".input-group").click(function () {
        //      $(".input-group-text", this).css({"background":"white","box-shadow":"-10px 5px 50px #e4e4e4"});
        //                   $(".input-group input", this).css({"background":"white","box-shadow":"-10px 5px 50px #e4e4e4"});
        //  });
         
        //  $(".input-group input").blur(function () {
        //      $(".input-group-text").css({"background":"#f4f5fd","box-shadow":"none"});
        //                                $(".input-group input", this).css({"background":"#f4f5fd","box-shadow":"none"});
        //  });


        $(".inpt-focus input").focus(function () {
            $(this).parent().addClass('popout-inpt');
        });
        $(".inpt-focus input").blur(function () {
            $(this).parent().removeClass('popout-inpt');
        });

        $(".inpt-focus select").focus(function () {
            $(this).parent().addClass('popout-inpt');
        });
        $(".inpt-focus select").blur(function () {
            $(this).parent().removeClass('popout-inpt');
        });