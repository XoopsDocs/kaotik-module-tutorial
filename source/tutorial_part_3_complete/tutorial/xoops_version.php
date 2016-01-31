<?php
// Tutorial Module                    										
// Created by kaotik													

$modversion['name'] = "Tutorial";
$modversion['version'] = 2.00;
$modversion['description'] = "This is a tutorial module to teach how to build a simple module";
$modversion['author'] = "KaotiK";
$modversion['credits'] = "KaotiK";
$modversion['help'] = "";
$modversion['license'] = "GPL see LICENSE";
$modversion['official'] = 0;
$modversion['image'] = "images/tutorial.png";
$modversion['dirname'] = "tutorial";

// Admin
$modversion['hasAdmin'] = 0;

// Menu
$modversion['hasMain'] = 1;

$modversion['sqlfile']['mysql'] = "sql/mysql.sql";
$modversion['tables'][0] = "tutorial_myform";

// Templates
$modversion['templates'][1]['file'] = 'tut_form.html';
$modversion['templates'][1]['description'] = '';

$modversion['templates'][2]['file'] = 'tut_client_list.html';
$modversion['templates'][2]['description'] = '';

$modversion['templates'][3]['file'] = 'tut_main.html';
$modversion['templates'][3]['description'] = '';


?>