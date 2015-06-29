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

// fields
$GLOBALS['TL_DCA']['tl_form_field']['fields']['dependentActive'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_form_field']['dependentActive'],
	'exclude'                 => true,
	'filter'                  => true,
	'inputType'               => 'checkbox',
	'eval'                    => array('submitOnChange'=>true),
	'sql'                     => "char(1) NOT NULL default ''"
);
$GLOBALS['TL_DCA']['tl_form_field']['fields']['dependentSuperiorFields'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_form_field']['dependentSuperiorFields'],
	'exclude'                 => true,
	'filter'                  => false,
	'inputType'               => 'multiColumnWizard',
	'eval'                    => array
	(
			'mandatory'    => true,
			'style'        => 'min-width: 100%;',
			'tl_class'     =>'clr',
			'columnFields' => array
			(
					'superiorFieldName' => array
					(
							'label'            => &$GLOBALS['TL_LANG']['tl_form_field']['dependentSuperiorFieldName'],
							'exclude'          => true,
							'inputType'        => 'select',
							'options_callback' => array('LexFormConditional', 'getAllInputFormFields'),
							'eval'             => array('mandatory'=>true, 'style'=>'width: 400px;')
					),
					'superiorFieldCondition' => array
					(
							'label'            => &$GLOBALS['TL_LANG']['tl_form_field']['dependentSuperiorFieldCondition'],
							'exclude'          => true,
							'inputType'        => 'select',
							'options'          => array('eq', 'ne', 'lt', 'le', 'gt', 'ge', 'lk'),
							'reference'        => &$GLOBALS['TL_LANG']['tl_form_field']['dependentSuperiorFieldOptions'],
							'eval'             => array('mandatory'=>true, 'style'=>'width: 100px;')
					),
					'superiorFieldValue' => array
					(
							'label'            => &$GLOBALS['TL_LANG']['tl_form_field']['dependentSuperiorFieldValue'],
							'exclude'          => true,
							'inputType'        => 'text',
							'eval'             => array('mandatory'=>true, 'style'=>'width: 200px;')
					)
			)
	),
	'sql'                     => "blob NULL"
);
$GLOBALS['TL_DCA']['tl_form_field']['fields']['dependentValidationRule'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_form_field']['dependentValidationRule'],
	'exclude'                 => true,
	'filter'                  => false,
	'inputType'               => 'radio',
	'default'                 => '0',
	'options'                 => array('0', '1'),
	'reference'               => &$GLOBALS['TL_LANG']['tl_form_field']['dependentValidationRuleOptions'],
	'eval'                    => array('mandatory'=>true),
	'sql'                     => "char(1) NOT NULL default '0'"
);

$GLOBALS['TL_DCA']['tl_form_field']['fields']['dependentEmpty'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_form_field']['dependentEmpty'],
	'exclude'                 => true,
	'filter'                  => true,
	'inputType'               => 'checkbox',
	'sql'                     => "char(1) NOT NULL default ''"
);

// Palettes
$GLOBALS['TL_DCA']['tl_form_field']['palettes']['__selector__'][] = 'dependentActive';

foreach ($GLOBALS['TL_DCA']['tl_form_field']['palettes'] as $name=>$palette) {
	$GLOBALS['TL_DCA']['tl_form_field']['palettes'][$name] = str_replace("{expert_legend:hide}", "{dependent_legend},dependentActive;{expert_legend:hide}", $palette);
}

// Subpalettes
array_insert($GLOBALS['TL_DCA']['tl_form_field']['subpalettes'], count($GLOBALS['TL_DCA']['tl_form_field']['subpalettes']),
	array('dependentActive' => 'dependentSuperiorFields,dependentValidationRule,dependentEmpty')
);

?>