<?php

if (isset($_COOKIE["user"])) { unset($_COOKIE["user"]); }
if (isset($_COOKIE["sectionNum"])) { unset($_COOKIE["sectionNum"]); }
if (isset($_COOKIE["sectionOpen"])) { unset($_COOKIE["sectionOpen"]); }
header('LOCATION:../index.php'); die();

?>