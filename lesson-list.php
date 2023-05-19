<?php
session_start();

// 依據有無登入顯示list畫面
if (isset($_SESSION['admin'])) {
  include './lesson-list-admin.php';
} else {
  include './lesson-list-noadmin.php';
}
