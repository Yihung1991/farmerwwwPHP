<?php

//啟動session
if(! isset($_SESSION)){
  session_start();
};

// 如果還沒登入，轉向登入頁
if(! isset($_SESSION['admin'])){
  header('Location: login.php');
  exit;
};

?>