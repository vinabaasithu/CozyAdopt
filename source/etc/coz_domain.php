<?php
  $coz_domain = "/CozyAdopt/";
  $ttkttk = "";
  // if ( preg_match("/".preg_quote($coz_domain, '/')."(.+)\/(.+)\/(.*)\//", $_SERVER["REQUEST_URI"], $match) ) {
  //   $ttkttk = "../../../";
  // } else if ( preg_match("/".preg_quote($coz_domain, '/')."(.+)\/(.+)\//", $_SERVER["REQUEST_URI"], $match) ) {
  //   $ttkttk = "../../";
  // } else if( preg_match("/".preg_quote($coz_domain, '/')."(.+)\//", $_SERVER["REQUEST_URI"], $match) ) {
  //   $ttkttk = "../";
  // }
  if (!function_exists("ttk_func")) {
    function ttk_func($server, $coz_domain = "/CozyAdopt/") {
      $ttkttk = "";
      if ( preg_match("/".preg_quote($coz_domain, '/')."(.+)\/(.+)\/(.*)\//", $server, $match) ) {
        $ttkttk = "../../../";
      } else if ( preg_match("/".preg_quote($coz_domain, '/')."(adm_coz)\/(.+)\//", $server, $match) ) {
        $ttkttk = "../";
      } else if ( preg_match("/".preg_quote($coz_domain, '/')."(adm_coz)\/(.+)\.php$/", $server, $match) ) {
        $ttkttk = "";
      } else if ( preg_match("/".preg_quote($coz_domain, '/')."(.+)\/(.+)\//", $server, $match) ) {
        $ttkttk = "../../";
      } else if( preg_match("/".preg_quote($coz_domain, '/')."(.+)\//", $server, $match) ) {
        $ttkttk = "../";
      }
      return $ttkttk;
    }
    $ttkttk = ttk_func($_SERVER["REQUEST_URI"], $coz_domain);
  }
 ?>
