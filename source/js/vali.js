var preventDefault = function(e) {
  e.preventDefault();
}
$(document).on("keyup", ".UnameCheck input", function(e) {
  var ortu = $(this).parents(".UnameCheck");
  var pola = /^[a-zA-Z0-9_-]+$/;
  var val = $(this).val();
  var vali = 0;
  if (!pola.test(val)) {
    vali = 0;
  } else {
    vali = 1;
  }
  if (!vali) {
    $("form.formc").bind("submit", preventDefault);
    ortu.find(".fa-times").show();
    ortu.find(".fa-check").hide();
  } else {
    $.post("/CozyAdopt/source/etc/vali.php", {vali_uname:val}, function(result){
      if (result.substr(0, 3) === "<h1") {
        $("form.formc").bind("submit", preventDefault);
        ortu.find(".fa-times").show();
        ortu.find(".fa-check").hide();
      } else {
        ortu.find(".fa-times").hide();
        ortu.find(".fa-check").show();
      }
    });
  }
});
$(document).on("keyup", ".FullNameCheck input", function(e) {
  var ortu = $(this).parents(".FullNameCheck");
  var pola = /^([a-zA-Z]+)([a-zA-Z ]*)$/;
  var val = $(this).val();
  var vali = 0;
  if (!pola.test(val)) {
    vali = 0;
  } else {
    vali = 1;
  }
  if (!vali) {
    $("form.formc").bind("submit", preventDefault);
    ortu.find(".fa-times").show();
    ortu.find(".fa-check").hide();
  } else {
    ortu.find(".fa-check").show();
    ortu.find(".fa-times").hide();
  }
});
$(document).on("keyup", ".EmailCheck input", function(e) {
  var ortu = $(this).parents(".EmailCheck");
  var pola = /^[a-zA-Z0-9_-]+\.?[a-zA-Z0-9_-]*@[a-zA-Z0-9_-]+\.[a-zA-Z0-9_-]+$/;
  var val = $(this).val();
  var vali = 0;
  if (!pola.test(val)) {
    vali = 0;
  } else {
    vali = 1;
  }
  if (!vali) {
    $("form.formc").bind("submit", preventDefault);
    ortu.find(".fa-times").show();
    ortu.find(".fa-check").hide();
  } else {
    ortu.find(".fa-check").show();
    ortu.find(".fa-times").hide();
  }
});
$(document).on("keyup", ".NoHPCheck input", function(e) {
  var ortu = $(this).parents(".NoHPCheck");
  var pola = /^(0|62|\+62)([0-9]{9,12})$/;
  var val = $(this).val();
  var vali = 0;
  if (!pola.test(val)) {
    vali = 0;
  } else {
    vali = 1;
  }
  if (!vali) {
    $("form.formc").bind("submit", preventDefault);
    ortu.find(".fa-times").show();
    ortu.find(".fa-check").hide();
  } else {
    ortu.find(".fa-check").show();
    ortu.find(".fa-times").hide();
  }
});
$(document).on("keyup", ".PasswordCheck input", function(e) {
  var ortu = $(this).parents(".PasswordCheck");
  var pola = /^[a-zA-Z0-9!@#\$\^\*\-\=_\+\.,]+$/;
  var val = $(this).val();
  var vali = 0;
  if (!pola.test(val)) {
    vali = 0;
  } else {
    vali = 1;
  }
  if (!vali) {
    $("form.formc").bind("submit", preventDefault);
    ortu.find(".fa-times").show();
    ortu.find(".fa-check").hide();
  } else {
    ortu.find(".fa-check").show();
    ortu.find(".fa-times").hide();
  }
});

$(document).on("keyup", ".UnameCheck input, .FullNameCheck input, .EmailCheck input, .NoHPCheck input, .PasswordCheck input", function(e) {
  var len = $("form .fa-check[style='display: inline;']").length;
  if (len >= 5) {
    $("form.formc").unbind("submit", preventDefault);
  }
});
