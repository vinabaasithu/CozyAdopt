$(document).on('click', '.fa-window-close', function(){
  $(".pelihara-container").hide(800);
});
$(document).on('click', '.isi-con-cari', function(){
  kucingajax($(this));
});
// data from index
$(document).ready(function(){
  var div = $("#isi-con-cari-from-index");
  var len = div.length;
  if (len > 0) {
    kucingajax(div);
  }
});
var kucingajax = function(i) {
  var nama = i.attr("nm");
  var img = i.attr("img");
  var jenis_kucing = i.attr("jk");
  var umur_kucing = i.attr("uk");
  var warna_kucing = i.attr("wk");
  var bulu_kucing = i.attr("bk");
  var jk_kucing = i.attr("jkel");
  var id_kucing = i.attr("kuc");
  $.ajax({
    url: "source/etc/pelihara.php",
    method: "POST",
    data: {nama:nama, img:img, jenis_kucing:jenis_kucing, umur_kucing:umur_kucing, warna_kucing:warna_kucing, bulu_kucing:bulu_kucing, jk_kucing:jk_kucing, id_kucing:id_kucing},
    dataType: "html",
    success: function(response){
      $(".pelihara-container").html(response).show(800);
    }
  });
}
