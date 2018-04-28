$(window).scroll(function() {
    var height = $(window).scrollTop();
    if (height >= 15) {
      $("header").attr("class", "header-after warna-putih");
      $(".nav-head li").attr("class", "warna-putih");
      $("div.burger-menu").css("margin-right", "25px");
      $(".menu-nav-min").css("position", "fixed");
      $(".menu_dp_header").css("background", "#0009");
      $(".logo div, .min-logo div").css("color", "#fff");
    } else {
      $("header").attr("class", "");
      $(".nav-head li").attr("class", "");
      $("div.burger-menu").css("margin-right", "0");
      $(".menu-nav-min").css("position", "absolute");
      $(".menu_dp_header").css("background", "#fff");
      $(".logo div, .min-logo div").css("color", "#000");
    }
});

$(document).ready(function(){
  $(".burger-menu").click(function(){
    $(".menu-nav-min").slideToggle();
  })
});

$(document).ready(function(){
  $(".click-dp").click(function(){
      $(".menu_dp_header").fadeToggle(800);
  });
});

$(document).ready(function(){
  var o = $(".pesanE");
  var p = $(".pesanE h1");
  var a = p.text();
  if(p.length) {
    setTimeout(function(){
      o.fadeOut("slow");
    }, 3000);
  }
  o.click(function(){
    o.fadeOut("slow");
  });
});

$(document).ready(function(){
  $(".dp_header_min .click-dp").click(function(){
    $(".dp_header_min ul").slideToggle(400);
  });
});
