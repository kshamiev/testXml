<?php
/**
 * The entry point to the application.
 * Initialize and run.
 */

// Including the class App
require 'config.php';

Zero_Logs::Init('app.log');

Zero_DB::Init();

$xml = new Xml_Parser;
$xml->Parser(PATH_EXCHANGE . '/test.xml', 'Xml_Handler_Test');

die('Done');
