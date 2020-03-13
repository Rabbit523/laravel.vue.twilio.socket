 console.log("das");
$(document).ready(function () {
    $(".nav-item").click(function () {
        $(".nav-item").removeClass("active");
        $(this).addClass("active");
    });
});

$('#creditcard').on('keyup', function(e){
    var val = $(this).val();
    if(e.which != 4)
    {
      if(val.replace(/\s/g, '').length % 4 == 0)
      {
        $(this).val(val + ' ' + ' ');
      }
    }
    else
    {
      $(this).val(val);        
    }
  }) 

  

var input = $("input[name='exp']");
input.on("keyup", function(e) {
    var value = input.val();
    // catching backspace
    if(e.keyCode === 8) {
        if(value.length == 4) {
            input.val(value.substr(0, 3));
        } else if(value.length == 7) {
            input.val(value.substr(0, 6));
        }
    } else {
        if(value.length == 2) {
            input.val(value + "/");
        } else if(value.length == 7) {
            input.val(value + ".");
        }
    }
});

$(document).ready(function(){
                          $('.chateroption').click(function() {
   $('.chatoptions', this).slideToggle('fast').addClass( "show" );
    return false;
});

                          $('.viewall').click(function() {
   $('.hidingcomment').slideToggle('fast').addClass( "view");
    return false;
});

$('.smilereact').click(function() {
 $(".reaction").animate({width: 'toggle'}, 50);

    return false;
});

});

$('.viewes').click(function() {
  $(".viewes").css("display", "none");
    $(".lesses").css("display", "block");
});

$('.lesses').click(function() {
  $(".lesses").css("display", "none");
    $(".viewes").css("display", "block");
});