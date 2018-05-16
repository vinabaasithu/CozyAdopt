var checkText = function() {
  var dis = $(".pesanE h1");
  var teks = dis.text();
  switch (teks) {
    case "Terimakasih.. Pesan Anda Sudah Terkirim :)": dis.addClass("success").show(); break;

    default: dis.show(); break;      
  }
}
checkText();
$(document).on("change", ".pesanE h1", function(){
  checkText();
});
