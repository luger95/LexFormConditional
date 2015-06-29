<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2015 Leo Feyer
 *
 * @license LGPL-3.0+
 */


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	// Classes
	'LexFormConditional' => 'system/modules/lexFormConditional/classes/LexFormConditional.php',
));


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
	'j_lexconditionnal' => 'system/modules/lexFormConditional/templates/jquery',
));
