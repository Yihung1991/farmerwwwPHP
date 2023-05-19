<?php
// 依據所在頁面的$title變數顯示網站名稱
if(! isset($title)) {
  $title='小農';
} else {
  $title= $title;
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="fontawesome/css/all.css" />
  <link rel="canonical" href="https://getbootstrap.com/docs/5.2/examples/sidebars/">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css"rel="stylesheet"/>
  <link href="./fontawesome/css/all.css" rel="stylesheet"/>
  <title><?= $title ?></title>

  </head>

  <body>