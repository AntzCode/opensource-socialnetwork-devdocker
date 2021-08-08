<?php

$thisDir = dirname(__FILE__).DIRECTORY_SEPARATOR;
$stylesDir = realpath(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'styles').DIRECTORY_SEPARATOR;

rename($thisDir.'account.orig.php', $thisDir.'account.php');
rename($thisDir.'settings.orig.php', $thisDir.'settings.php');
rename($thisDir.'installed.orig.php', $thisDir.'installed.php');
unlink($stylesDir.'antzcode-logo.svg');
unlink($stylesDir.'antzcode-background.svg');
unlink($thisDir.'cleanup.php');



