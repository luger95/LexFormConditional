<?php

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2015 Leo Feyer
 *
 * Formerly known as TYPOlight Open Source CMS.
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 3 of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 * 
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at <http://www.gnu.org/licenses/>.
 *
 * PHP version 5
 * @copyright  Cliff Parnitzky 2012-2015
 * @author     Cliff Parnitzky
 * @package    LexFormConditional
 * @license    LGPL
 */

/**
 * Error messages
 */
$GLOBALS['TL_LANG']['ERR']['dependentErrorMandatory']['Single']   = 'Le champ "%s" ne doit pas être vide, parce que le champ "%s" contient une valeur.';
$GLOBALS['TL_LANG']['ERR']['dependentErrorMandatory']['Multiple'] = 'Le champ "%s" ne doit pas être vide, parce que les champs "%s" contiennent des valeurs.';
$GLOBALS['TL_LANG']['ERR']['dependentErrorEmpty']['Single']       = 'Le champ "%s" doit être vide, parce que le champ "%s" ne contient pas de valeur.';
$GLOBALS['TL_LANG']['ERR']['dependentErrorEmpty']['Multiple']     = 'Le champ "%s" doit être vide, parce que les champs "%s" ne contiennent pas de valeurs.';

?>