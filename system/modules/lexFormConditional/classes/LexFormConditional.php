<?php

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2015
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
 * Class LexFormConditional
 *
 * @copyright  Cliff Parnitzky 2012-2015
 * @author     Cliff Parnitzky
 */
class LexFormConditional extends Backend {
	
	const RULE_ONE = '0';
	const RULE_ALL = '1';
	
	/**
	 * Constructor, initialize the object.
	 */
	public function __construct() {
		parent::__construct();
		$this->import('Database');
		$this->import('Input');
	}
	 
	/**
	 * Execute Hook: loadFormField to add special classes
	 */
	public function loadField(Widget $objWidget, $strFormId, $arrData) {
		if ($objWidget->dependentActive) {
                    /*dump($objWidget);exit;*/
			$objWidget->class = "dependent";
			$objWidget->enveloppe = array('class'=> "enveloppe", 'conditional' => json_encode(deserialize($objWidget->dependentSuperiorFields)));
		}
		return $objWidget;
	}
	
	/**
	 * Execute Hook: validateFormField to check if the dependent form field is valid
	 */
	public function validateField(Widget $objWidget, $strFormId, $arrData) {
		if ($objWidget->dependentActive) {
			$arrdependentSuperiorFields = deserialize($objWidget->dependentSuperiorFields);
			
			// collect all conditions for each field
			$arrSuperiorFields = array();
			foreach ($arrdependentSuperiorFields as $field) {
				$fieldName = $field['superiorFieldName'];
				if (!array_key_exists($fieldName, $arrSuperiorFields)){
					$arrSuperiorFields[$fieldName] = array();
				}
				$arrSuperiorFields[$fieldName][] = array('condition' => $field['superiorFieldCondition'], 'value' => $field['superiorFieldValue']);
			}
			
			$method = strtolower($this->getFormMethod($arrData['id']));

			$formFields = $this->getFormFields($arrData['id']);
			$filledSuperiorFields = array();
			$allSuperiorFields = array();
			$filledSuperiorFieldsCount = 0;
			foreach ($arrSuperiorFields as $field => $rules) {
				$values = array();
				
				$postValue = $this->Input->$method($field);
				if ($postValue == null && $this->isFormFileUpload($field, $arrData['id'])) {
					$values[] = $_SESSION['FILES'][$field]['name'];
				} else {
					if (is_array($postValue)) {
						$values = $postValue;
					} else {
						$values[] = $postValue;
					}
				}
				
				// check against rules
				$blnMatched = false;
				
				foreach ($values as $value) {
					foreach ($rules as $rule) {
						if (!$blnMatched) {
							// compare the entered value with the expected value
							$expectedValue = $rule['value'];
							$condition = $rule['condition'];
							
							if ($expectedValue == '*') {
								if (($condition == 'eq' || $condition == 'lk') && $value != null && strlen($value) > 0) {
									$blnMatched = true;
								} else if ($condition == 'ne' && $value == null && strlen($value) == 0) {
									$blnMatched = true;
								}
							} else {
								//convert $value / $expectedValue into numbers if possible
								if (is_int($value) && is_int($expectedValue)) {
									$value = intval($value);
									$expectedValue = intval($expectedValue);
								} else if (is_float ($value) && is_float ($expectedValue)) {
									$value = floatval($value);
									$expectedValue = floatval($expectedValue);
								}
								
								switch ($condition) {
									case 'eq' : $blnMatched = ($value ==  $expectedValue); break;
									case 'ne' : $blnMatched = ($value !=  $expectedValue); break;
									case 'lt' : $blnMatched = ($value <  $expectedValue); break;
									case 'le' : $blnMatched = ($value <=  $expectedValue); break;
									case 'gt' : $blnMatched = ($value >  $expectedValue); break;
									case 'ge' : $blnMatched = ($value >=  $expectedValue); break;
									case 'lk' : $blnMatched = (strpos($value, $expectedValue) !== FALSE); break;
								}
							}
						}
					}
				}
				if ($blnMatched) {
					$filledSuperiorFields[] = $formFields[$field];
					$filledSuperiorFieldsCount++;
				}
				
				$allSuperiorFields[] = $formFields[$field];
			}
			
			$widgetValue = $this->Input->$method($objWidget->name);
			if ($widgetValue == null && $this->isFormFileUpload($objWidget->name, $arrData['id'])) {
					$widgetValue = $_SESSION['FILES'][$objWidget->name]['name'];
			}
			
			if ($filledSuperiorFieldsCount > 0 && $widgetValue == null) {
				if (($objWidget->dependentValidationRule == self::RULE_ALL && count($arrSuperiorFields) == $filledSuperiorFieldsCount) ||
					($objWidget->dependentValidationRule == self::RULE_ONE)) {
					
					$objWidget->addError($this->getErrorMessage('dependentErrorMandatory', $objWidget, $filledSuperiorFieldsCount, $filledSuperiorFields));
				}
			} else if ($objWidget->dependentEmpty && $widgetValue != null) {
				if (($objWidget->dependentValidationRule == self::RULE_ALL && count($arrSuperiorFields) != $filledSuperiorFieldsCount) ||
					($objWidget->dependentValidationRule == self::RULE_ONE && $filledSuperiorFieldsCount == 0)) {
					
					$objWidget->addError($this->getErrorMessage('dependentErrorEmpty', $objWidget, count($arrSuperiorFields), $allSuperiorFields));
				}
			}
		}
		
		return $objWidget;
	}

	/**
	 * Determine the forms method.
	 */
	private function getFormMethod ($formId) {
		return $this->Database->prepare("SELECT method FROM tl_form WHERE id = ?")->limit(1)->execute($formId)->method;
	}
	
	/**
	 * Return all possible form fields as array
	 * @return array
	 */
	public function getFormFields($formId) {
		$this->loadLanguageFile('tl_form_field');

		$fields = array();

		// Get all form fields which can be used
		$obFormFields = $this->Database->prepare("SELECT * FROM tl_form_field WHERE pid = ? ORDER BY label, name ASC")
							->execute($formId);

		while ($obFormFields->next()) {
			$fields[$obFormFields->name] = (strlen($obFormFields->label) > 0) ? $obFormFields->label : $obFormFields->name;
		}

		return $fields;
	}
	
	/**
	 * Creates a special error message for each case.
	 */
	private function getErrorMessage ($msgKey, $objWidget, $superiorFieldsCount, $filledSuperiorFields) {
		if ($superiorFieldsCount > 0) {
			$singularPluralErrorKey = 'Single';
			if ($superiorFieldsCount > 1) {
				$singularPluralErrorKey = 'Multiple';
			}
			return sprintf($GLOBALS['TL_LANG']['ERR'][$msgKey][$singularPluralErrorKey], $objWidget->label, implode(', ', $filledSuperiorFields));
		}
		
		return '';
	}
	
	/**
	 * Return all possible form fields as array ... to configure superior fields in dca
	 * @return array
	 */
	public function getAllInputFormFields(MultiColumnWizard $mcw) {
		$this->loadLanguageFile('tl_form_field');
		
		$fields = array();
		
		$intPid = -1;

		if ($this->Input->get('act') == 'overrideAll' || $this->Input->get('act') == 'editAll') {
			$intPid = $this->Input->get('id');
		} else {
			$intPid = $this->Database->prepare("SELECT pid FROM tl_form_field WHERE id = ?")
									  ->limit(1)
									  ->execute($this->Input->get('id'))
									  ->pid;
		}

		// Get all form fields which can be used
		$obFormFields = $this->Database->prepare("SELECT * FROM tl_form_field WHERE pid = ? AND NOT id = ? ORDER BY label, name ASC")
							->execute(array($intPid, $this->Input->get('id')));

		while ($obFormFields->next()) {
			$strClass = $GLOBALS['TL_FFL'][$obFormFields->type];

			// Continue if the class is not defined
			if (!$this->classFileExists($strClass)) {
				continue;
			}
			
			// Continue if the class is not an input submit
			$widget = new $strClass;
			if (!$widget->submitInput() && !$widget instanceof FormFileUpload) {
				continue;
			}
			
			$fields[$obFormFields->name] = ((strlen($obFormFields->label) > 0) ? $obFormFields->label . " [" . $GLOBALS['TL_LANG']['tl_form_field']['name'][0] . ": " . $obFormFields->name . " / " : $obFormFields->name . " [") . $GLOBALS['TL_LANG']['tl_form_field']['type'][0] . ": " . $GLOBALS['TL_LANG']['FFL'][$obFormFields->type][0] . "]";
		}

		return $fields;
	}
	
	/**
	 * Return if the field with given id is of type file upload
	 * @return boolean
	 */
	private function isFormFileUpload ($fieldName, $formId) {
		$obFormField = $this->Database->prepare("SELECT * FROM tl_form_field WHERE name = ? AND pid = ?")
							->limit(1)
							->execute(array($fieldName, $formId));

		if ($obFormField->next()) {
			$strClass = $GLOBALS['TL_FFL'][$obFormField->type];

			// Continue if the class is not defined
			if ($this->classFileExists($strClass)) {
				// check if the class correct type
				$widget = new $strClass;
				return ($widget instanceof FormFileUpload);
			}			
		}

		return false;
	}
}

?>