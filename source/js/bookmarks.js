$(document).on("click", ".bookmarks", function(){
    bookmarks(this);
    if ($(this).attr("val") === "fav") {
        var id = "favorit_saya";
        var r = userparam;
        var usersess = userses;
        if (userparam === usersess) {
          $.post("source/etc/profil.php", {id:id, r:r}, function(result){
            $(".isi").html(result);
          });
        }
    }
});
var bookmarks = function(classbookmarks) {
  var bookmarks = "bookmarks";
  var fa_star = $(classbookmarks).find(".fa-star");
  var id_kucing = fa_star.attr("val");
  var isbookmarked = fa_star.hasClass("bookmarked");
  var r = userparam;
  var usersess = userses;
  if (!userses) {
    alert("Maaf, Anda harus login untuk menggunakan fitur ini");
    return false;
  }
  var nama = "";
  if ($(classbookmarks).parents(".kucing_saya_container").find("p.h1.nm-kucing-profil").length) {
    nama = $(classbookmarks).parents(".kucing_saya_container").find("p.h1.nm-kucing-profil").text();
  } else if ($(classbookmarks).parents(".klik-to-temukan").length) {
    nama = $(classbookmarks).parents(".klik-to-temukan").attr("nm");
  } else if ($(classbookmarks).parents(".isi-con-cari").length) {
    nama = $(classbookmarks).parents(".isi-con-cari").attr("nm");
  }
  var dialog = "";
  var torh = "";
  if (isbookmarked) {
    dialog = "Hapus "+nama+" dari daftar Kucing Favorit ?";
    torh = "dihapus dari daftar Kucing Favorit";
  } else {
    dialog = "Tambahkan "+nama+" ke dalam daftar Kucing Favorit ?";
    torh = "ditambahkan ke dalam daftar Kucing Favorit";
  }
  if (confirm(dialog)) {
    $.post("source/etc/bookmarks.php", {bookmarks:bookmarks, id_kucing:id_kucing}, function(result){
      if (isbookmarked) {
        fa_star.removeClass("bookmarked");
      } else if(result === "INSERT BERHASIL") {
        fa_star.addClass("bookmarked");
      }
    });
    alert(nama+" berhasil " + torh);
  } else {
    alert(nama+" batal " + torh);
  }
}
