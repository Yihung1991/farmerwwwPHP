<?php

session_start();

if (isset($_SESSION['admin'])) {
  include './comment-list-admin.php';
} else {
  include './comment-list-noadmin.php';
}
