<?php
include($_SERVER["DOCUMENT_ROOT"]."/core/init.php");

session_destroy();
redirect("/index.php");
