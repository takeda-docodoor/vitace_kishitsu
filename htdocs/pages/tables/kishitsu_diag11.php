<?php

//

require('../../config.php');
require('../../lib.php');
require('../../system_tbl.php');

//
session_set_cookie_params(365 * 24 * 3600);

session_start();

if ($_SESSION['passwd'] != '') {
  if ($_SESSION['passwd'] == $passwd_img) {
    header('Location: ' . $csctm_url_img);
    exit;
  }
} else {
  header('Location: ../../index.php');
  exit;
}

