<?php
$t_sql = "SELECT COUNT(1) FROM sidebars";
?>


<main class="d-flex flex-nowrap h-100" style="justify-content:left;">
  <div class="d-flex flex-column p-3" style="width: 200px; height:100vh;background-color: #1F3D3C;border-top-right-radius:30px;border-bottom-right-radius:30px;">
    <ul class="nav nav-pills mb-auto" style="margin-bottom:500px;">

      <li>
        <?php
        $ctgsql = ("SELECT * FROM `sidebars` where nid = 0");
        $sidebars = $pdo->query($ctgsql)->fetchAll(); ?>

        <?php foreach ($sidebars as $s) : ?>
          <a href="./<?= $s['button_href'] ?>" class="nav-link text-white <?= $pageSid == $s['sid'] ? 'active' : '' ?>">
            <option value="<?= $s['sid'] ?>"><?= $s['button_name'] ?></option>
          </a>

        <?php endforeach ?>
      </li>
    </ul>
  </div>