<?php
session_start();

if (isset($_SESSION['admin'])) {
  include './product_list-admin.php';
} else {
  include './product_list-no-admin.php';
}
