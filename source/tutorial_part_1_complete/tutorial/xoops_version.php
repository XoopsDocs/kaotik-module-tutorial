<?php
// Tutorial Module                    										
// Created by kaotik													

$modversion['name'] = "Tutorial";
$modversion['version'] = 1.00;
$modversion['description'] = "This is a tutorial module to teach how to build a simple module";
$modversion['author'] = "KaotiK";
$modversion['credits'] = "KaotiK";
$modversion['help'] = "";
$modversion['license'] = "GPL";
$modversion['official'] = 0;
$modversion['image'] = "images/tutorial.png";
$modversion['dirname'] = "tutorial";

// Admin
$modversion['hasAdmin'] = 0;

// Menu
$modversion['hasMain'] = 1;

$modversion['sqlfile']['mysql'] = "sql/mysql.sql";
$modversion['tables'][0] = "tutorial_myform";
?>