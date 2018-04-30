$(document).on("click", ".rawatpelihara", function(){
  var val = $(this).attr("val");
  $.ajax({
    url: "source/etc/getMajikan.php",
    method: "POST",
    data: {val:val},
    dataType: "html",
    success: function(response){
      $(".getmj").html(response);
      $(".getMajikan").hide();
      $(".getMajikan").show(800);
    }
  });
});
$(document).on("click", ".getMajikan", function(e){
  if (this === e.target) {
    $(this).hide(800);
    setTimeout(function(){
      $(".getmj").empty();
    }, 900);
  }
});
