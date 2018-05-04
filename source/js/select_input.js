$(document).ready(function(){
  $(".container-select-input .grid").click(function(){
    var val = $(this).attr("val");
    $("."+val+"-isi").fadeToggle(800);
  });

  $("form").submit(function(en){
    var namaKucing = $("#nama-kucing").val();
    var prov = $("input[val='prov']").val();
    var kab = $("input[val='kab']").val();
    var kec = $("input[val='kec']").val();
    var kel = $("input[val='kel']").val();
    if (namaKucing === "" || prov === "" || kab === "" || kec === "" || kel === "") {
      en.preventDefault();
    }
  });

  $(".teks").attr("ind", "0");
  $(".prov-isi li, .kab-isi li, .kec-isi li, .kel-isi li").attr("style", "display: block;");

});

$(document).on("keyup", ".teks", function(e){
  var isiInput = $(this).val();
  var thisVal = $(this).attr("val");
  $("."+thisVal+"-isi").fadeIn(800);
  if (isiInput[1] === undefined) {
    $(this).val(isiInput.toUpperCase());
  }
  var isi = "."+thisVal+"-isi li";
  var banyakIsi = $(isi).length;
  var regex = new RegExp(isiInput, "i");
  for (var i = 0; i < banyakIsi; i++) {
    var a = $("."+thisVal+"-isi li")[i].innerText;
    if(regex.test(a)) {
      $(".text-filter-"+thisVal).text(a);
      // on enter
      if (e.keyCode === 13) {
        $(".text-filter-"+thisVal).text("");
        // $(this).val(a);
        $(this).attr("idnya", $("."+thisVal+"-isi li")[i].getAttribute("val"));
        var idn = $(this).attr("idnya");
        $("#hidden_id_"+thisVal).val(idn);
        if (thisVal === "prov") {
          selesaiKlikProv(idn);
        } else if(thisVal === "kab") {
          selesaiKlikKab(idn);
        } else if(thisVal === "kec") {
          selesaiKlikKec(idn);
        }
      }
      break;
    } else {
      $(".text-filter-"+thisVal).text("");
    }
  }

  // on bottom arrow
  if(e.keyCode === 40) {
    $(".text-filter-"+thisVal).text("");
    var ind = $(this).attr("ind");
    if (ind+1 > $("."+thisVal+"-isi li[style='display: block;']").length) {
      ind = -1;
    }
    $(this).attr("ind", ++ind);
    $(this).attr("ind", ind);
    $(this).val($("."+thisVal+"-isi li[style='display: block;']")[ind].innerText);
    $(this).attr("idnya", $(".prov-isi li[style='display: block;']")[ind].getAttribute("val"));
    var idn = $(this).attr("idnya");
    $("#hidden_id_"+thisVal).val(idn);
    if (thisVal === "prov") {
      selesaiKlikProv(idn)
    } else if(thisVal === "kab") {
      selesaiKlikKab(idn);
    } else if(thisVal === "kec") {
      selesaiKlikKec(idn);
    }
  } else if(e.keyCode === 38) {
    // on up arrow
    $(".text-filter-"+thisVal).text("");
    var ind = $(this).attr("ind");
    if (ind-1 < 0) {
      ind = $("."+thisVal+"-isi li[style='display: block;']").length;
    }
    $(this).attr("ind", --ind);
    $(this).attr("ind", ind);
    $(this).val($("."+thisVal+"-isi li[style='display: block;']")[ind].innerText);
    $(this).attr("idnya", $("."+thisVal+"-isi li[style='display: block;']")[ind].getAttribute("val"));
    var idn = $(this).attr("idnya");
    $("#hidden_id_"+thisVal).val(idn);
    if (thisVal === "prov") {
      selesaiKlikProv(idn)
    } else if(thisVal === "kab") {
      selesaiKlikKab(idn);
    } else if(thisVal === "kec") {
      selesaiKlikKec(idn);
    }
  } else {
    // refresh div
    $(this).attr("ind", "0");
    for (var i = 0; i < banyakIsi; i++) {
      var a = $("."+thisVal+"-isi li")[i].innerText;
      if(!regex.test(a)) {
        $("."+thisVal+"-isi li")[i].style.display = "none";
      } else {
        $("."+thisVal+"-isi li")[i].style.display = "block";
      }
    }
  }
  if (isiInput[0] === undefined || (e.keyCode === 13 && $("."+thisVal+"-isi li[style='display: block;']").length <= 1)) {
   $("."+thisVal+"-isi").fadeOut(200);
   // exit div
  }
});
$(document).on('click', '.isi-select-input li', function(){
  $(".isi-select-input li").click(function(){
    var da = $(this).attr("da");
    $("input[val='"+da+"']").val($(this).text());
    $("."+da+"-isi").attr("idnya", $(this).attr("val"));
    $("."+da+"-isi").fadeOut(200);
    var idn = $(this).attr("val");
    $("#hidden_id_"+da).val(idn);
    if (da === "prov") {
      selesaiKlikProv(idn)
    } else if(da === "kab") {
      selesaiKlikKab(idn);
    } else if(da === "kec") {
      selesaiKlikKec(idn);
    }
    // onclick && exit div
  })
});
$(document).on("keyup", "#prov-text-id", function(e){
  var isiInput = $(this).val();
  var thisVal = $(this).attr("val");
  if (isiInput[0] === undefined || (e.keyCode === 13 && $("."+thisVal+"-isi li[style='display: block;']").length <= 1)) {
    $("input[val='kab']").val("");
    $("input[val='kec']").val("");
    $("input[val='kel']").val("");
   $("."+thisVal+"-isi").fadeOut(200);
   // exit div
  }
});

// ajax on change
// khusus untuk prov
var selesaiKlikProv = function(idnya) {
  $.ajax({
  url: "/CozyAdopt/source/etc/select_lokasi.php",
  method: "POST",
  data: {id_prov:idnya},
  dataType: "html",
  success: function(response){
    $(".isi-select-input.kab-isi ul").html(response);
  }
})
}
var selesaiKlikKab = function(idnya) {
  $.ajax({
  url: "/CozyAdopt/source/etc/select_lokasi.php",
  method: "POST",
  data: {id_kab:idnya},
  dataType: "html",
  success: function(response){
    $(".isi-select-input.kec-isi ul").html(response);
  }
})
}
var selesaiKlikKec = function(idnya) {
  $.ajax({
  url: "/CozyAdopt/source/etc/select_lokasi.php",
  method: "POST",
  data: {id_kec:idnya},
  dataType: "html",
  success: function(response){
    $(".isi-select-input.kel-isi ul").html(response);
  }
})
}
$(document).on("input", "#prov-text-id", function(){
  $("input[val='kab']").val("");
  $("input[val='kec']").val("");
  $("input[val='kel']").val("");
});
// $(document).on("focusout", "input.teks", function(e) {
//   alert(e.keyCode);
//   var val = $(this).attr("val");
//   var isi = $("."+val+"-isi");
//   var inputText = $("input[val='"+val+"']");
//   var li = $("."+val+"-isi li[style='display: block;']")[0].innerText;
//   inputText.val(li);
//   isi.fadeOut(100);
// })
