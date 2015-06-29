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
$GLOBALS['TL_LANG']['tl_form_field']['dependentActive']         = array('Activer la dépendance pour ce champ', "Cocher si ce champ doit apparaitre, en fonction de la valeur d'un autre champ.");
$GLOBALS['TL_LANG']['tl_form_field']['dependentSuperiorFields'] = array('Champs supérieurs', "Choisissez les champs supérieurs rendant ce champ visible et obligatoire.");
$GLOBALS['TL_LANG']['tl_form_field']['dependentValidationRule'] = array('Règle de validation', 'Sélectionnez comment le champ supérieur sera conditionné.');
$GLOBALS['TL_LANG']['tl_form_field']['dependentEmpty']          = array("Le champ doit-être vide si la règle de validation n'est pas satisfait", "Sélectionnez si le champ doit être vide si la règle de validation est pas satisfaite.");

// mcw fields
$GLOBALS['TL_LANG']['tl_form_field']['dependentSuperiorFieldName']      = array('Champ du formulaire', 'Selectionnez le champ du formulaire.');
$GLOBALS['TL_LANG']['tl_form_field']['dependentSuperiorFieldCondition'] = array('Condition', 'Selectionnez la condition pour la validation du champ.');
$GLOBALS['TL_LANG']['tl_form_field']['dependentSuperiorFieldValue']     = array('Valeur', "Indiquez la valeur à tester lors de la validation. Comme un espace réservé pour une valeur de champ un \'*\' (astérisque) peut être utilisé.");

// legends
$GLOBALS['TL_LANG']['tl_form_field']['dependent_legend'] = "Dépendante obligatoire champ de formulaire";

// fields
$GLOBALS['TL_LANG']['tl_form_field']['dependentValidationRuleOptions']['0'] = 'Au moins 1 champ ne doit pas être vide.';
$GLOBALS['TL_LANG']['tl_form_field']['dependentValidationRuleOptions']['1'] = 'Tous les champs ne doivent pas être vide.';

// options
$GLOBALS['TL_LANG']['tl_form_field']['dependentSuperiorFieldOptions']['eq'] = '= (égal)';
$GLOBALS['TL_LANG']['tl_form_field']['dependentSuperiorFieldOptions']['ne'] = '!= (non égal)';
$GLOBALS['TL_LANG']['tl_form_field']['dependentSuperiorFieldOptions']['lt'] = '< (plus petit)';
$GLOBALS['TL_LANG']['tl_form_field']['dependentSuperiorFieldOptions']['le'] = '<= (plus petit ou égal)';
$GLOBALS['TL_LANG']['tl_form_field']['dependentSuperiorFieldOptions']['gt'] = '> (plus grand)';
$GLOBALS['TL_LANG']['tl_form_field']['dependentSuperiorFieldOptions']['ge'] = '>= (plus grand ou égal)';
$GLOBALS['TL_LANG']['tl_form_field']['dependentSuperiorFieldOptions']['lk'] = 'LIKE (similair à)';

?>