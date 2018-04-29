$(document).on("click", ".bookmarks", function(){
    bookmarks(this);
});
var bookmarks = function(classbookmarks) {
  var bookmarks = "bookmarks";
  var fa_star = $(classbookmarks).find(".fa-star");
  var id_kucing = fa_star.attr("val");
  var isbookmarked = fa_star.hasClass("bookmarked");
  $.post("source/etc/bookmarks.php", {bookmarks:bookmarks, id_kucing:id_kucing}, function(result){
    if (isbookmarked) {
      fa_star.removeClass("bookmarked");
    } else if(result === "INSERT BERHASIL") {
      fa_star.addClass("bookmarked");
    }
  });
}
