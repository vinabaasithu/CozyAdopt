<?php
// header URI
// pesan atau r
preg_match("/(\/CozyAdopt\/)(.+\.php\?)(pesan=|r=)(.*)/", $_SERVER["REQUEST_URI"], $matches);
if (isset($matches[4])) {
  if ($matches[0] === "/CozyAdopt/sign.php?r=reg") {
    header("Location: ".$matches[1]."register/");
  } else if ($matches[2] === "index.php?") {
    header("Location: ".$matches[1]."msg:".$matches[4]);
  } else {
    if (preg_match("/profil.php\?r=(.+)&pesan=(.*)/", $matches[0], $match)) {
      header("Location: ".$matches[1].substr($matches[2], 0, -5)."/".$match[1]."/".$match[2]."/");
    } else {
      header("Location: ".$matches[1].substr($matches[2], 0, -5)."/".$matches[4]."/");
    }
  }
} else if ( preg_match("/(\/CozyAdopt\/)(.+)(\.php)$/", $_SERVER["REQUEST_URI"], $matches) ) {
  // for index and any files without param
  if ($matches[2] === "index") {
    header("Location: ".$matches[1]);
  } else {
    header("Location: ".$matches[1].$matches[2]."/");
  }
} else if( preg_match("/(\/CozyAdopt\/)(.+\.php\?)(nm=)(.+&)(jk=)(.+&)(uk=)(.+&)(wk=)(.+&)(bk=)(.+&)(kuc=)(.+&)(jkel=)(.+&)(img=)(.+)/", $_SERVER["REQUEST_URI"], $matches) ) {
  // header Location from index to adopt_kucing.php
  $param = array(); $end = 18; $ind=0; $full_links = "";
  for ($k=4; $k <= $end; $k+=2) {
    if ($k !== $end) {
      $param[$ind++] = "/".substr($matches[$k], 0, -1);
    } else {
      $param[$ind++] = "-".substr($matches[$k], 0);
    }
    $full_links .= $param[$ind-1];
  }
  // echo "Location: ". $matches[1].substr($matches[2], 0, -5).$full_links;
  header("Location: ". $matches[1].substr($matches[2], 0, -5).$full_links);
} else if( preg_match("/(\/CozyAdopt\/)(.+)(\.php)(\?r=)(.+)(&pesan=)(.*)$/", $_SERVER["REQUEST_URI"], $matches) ) {
  // header("Location: ". $matches[1].$matches[2]."/".$matches[5]. "/". $matches[7]. "/");
  echo "<script>console.log('"."Location: ". $matches[1].$matches[2]."/".$matches[5]. "/". $matches[7]. "/"."')</script>";
}
// print_r($_SERVER["REQUEST_URI"]);

 ?>
