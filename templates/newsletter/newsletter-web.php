<?php

use MtHaml\Autoloader;
use MtHaml\Environment;

require_once __DIR__ . '/../../vendor/lib/mthaml/lib/MtHaml/Autoloader.php';
require_once __DIR__ . '/../../vendor/lib/twig/lib/Twig/Autoloader.php';

Twig_Autoloader::register();
Autoloader::register();

$loader = new Twig_Loader_String();
$twig = new Twig_Environment($loader);
$twig->addExtension(new MtHaml\Support\Twig\Extension());

$haml = new Environment('twig', array('enable_escaper' => false));

$template = __DIR__ . '/newsletter-web.php.haml';
$compiled = $haml->compileString(file_get_contents($template), $template);

$template_data = $newsletter;

echo $twig->render($compiled, $template_data);
