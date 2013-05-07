<?php

use MtHaml\Autoloader;
use MtHaml\Environment;

require_once __DIR__ . '/../../vendor/lib/mthaml/lib/MtHaml/Autoloader.php';

Autoloader::register();

$haml = new Environment('php', array('enable_escaper' => false));

$template_data = array( "title" => "LSE Cities Newsletter | Issue 14", "content" => "Paragraph");

$template = __DIR__ . '/example.php.haml';
$compiled = $haml->compileString(file_get_contents($template), $template);

echo "rendered template:\n";

eval($compiled);
