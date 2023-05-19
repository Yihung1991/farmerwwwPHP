<?php

session_start();

if (isset($_SESSION['admin'])) {
  include './coupon-list-admin.php';
} else {
  include './coupon-list-noadmin.php';
}
