<?php
if (!isset($title)) $title = '';

?>
<nav class="navbar navbar-expand-lg bg-light" style="height:5vh">
  <div class="container-fluid" style="width:98%">
    <a class="navbar-brand" href="index.php">小農樂活</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0" style="visibility:hidden">
        <li class="nav-item">
          <a class="nav-link" href="#">列表</a>
        </li>
      </ul>
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="#"><?= $title ?></a>
        </li>
      </ul>
      <!-- 登入登出 -->
      <ul class="navbar-nav mb-2 mb-lg-0">
        <?php if (isset($_SESSION['admin'])) : ?>
          <li class="nav-item">
            <a class="nav-link"><?= $_SESSION['admin']['account'] ?></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="logout.php">登出</a>
          </li>
        <?php else : ?>

          <li class="nav-item">
            <a class="nav-link <?= $page_name == 'login' ? 'active' : '' ?> " href="login.php">登入</a>
          </li>
          <!-- <li class="nav-item ">
            <a class="nav-link " href="#">註冊</a>
          </li> -->

        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>