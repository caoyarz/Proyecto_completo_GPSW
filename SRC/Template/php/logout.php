<?php
session_start();
session_destroy();
header( 'Location: /SRC/Template/login.php');
