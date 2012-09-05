<?php

Autoloader::map(array(
	'Modules\\Modules' => __DIR__.DS.'modules.php',
));

Autoloader::alias('Modules\\Modules', 'Modules');
