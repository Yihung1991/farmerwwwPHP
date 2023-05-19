<?php

session_start();

// 依據有無登入顯示list畫面
if (isset($_SESSION['admin'])) {
  include './member-list-login.php';
} else {
  include './member-list-logout.php';
}
