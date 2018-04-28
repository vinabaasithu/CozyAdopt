function readURL(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function(e) {
      $('#view-img').attr('src', e.target.result);
    }
    reader.readAsDataURL(input.files[0]);
    setTimeout(function(){
      $("#view-img").show("800");
    }, 300);
  }
}
function readURL1(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function(e) {
      $('#view-img1').attr('src', e.target.result);
    }
    reader.readAsDataURL(input.files[0]);
    setTimeout(function(){
      $("#view-img1").show("800");
    }, 300);
  }
}
function readURL2(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function(e) {
      $('#view-img2').attr('src', e.target.result);
    }
    reader.readAsDataURL(input.files[0]);
    setTimeout(function(){
      $("#view-img2").show("800");
    }, 300);
  }
}
function readURL3(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function(e) {
      $('#view-img3').attr('src', e.target.result);
    }
    reader.readAsDataURL(input.files[0]);
    setTimeout(function(){
      $("#view-img3").show("800");
    }, 300);
  }
}


$(document).on("change", "#upl", function(){
  $("#view-img").hide("800");
  readURL(this);
});
$(document).on("change", "#upl1", function(){
  $(this).parents(".img-upl-front").toggle();
  $("#view-img1").hide("800");
  readURL1(this);
});

$(document).on("change", "#upl2", function(){
  $(this).parents(".img-upl-front").toggle();
  $("#view-img2").hide("800");
  readURL2(this);
});

$(document).on("change", "#upl3", function(){
  $(this).parents(".img-upl-front").toggle();
  $("#view-img3").hide("800");
  readURL3(this);
});
