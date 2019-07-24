<?php

use CRM_Movesmanagement_ExtensionUtil as E;

/**
 * Form controller class
 *
 * @see https://docs.civicrm.org/dev/en/latest/framework/quickform/
 */
class CRM_Movesmanagement_Form_Movesactivity extends CRM_Core_Form {

  public function activityFields() {
    return [
      'activity_type_id' => [
        'add' => 'addEntityRef',
        'label' => ts('Activity Type'),
        'required' => TRUE,
        'entityRefDetails' => array(
          'entity' => 'option_value',
          'placeholder' => ts('- Select Activity Type -'),
          'api' => array(
            'params' => array('option_group_id' => 'activity_type'),
          ),
          'select' => array(
            'minimumInputLength' => 0,
          ),
        ),
      ],
      'custom_65' => [
        'add' => 'addElement',
        'type' => 'text',
        'label' => ts('Other Activity Type'),
        'required' => FALSE,
      ],
      'target_id' => [
        'add' => 'addEntityRef',
        'label' => ts('Contact Name'),
        'required' => TRUE,
        'entityRefDetails' => array(
          'api' => array(
            'params' => array('contact_type' => 'Individual'),
          ),
          'create' => TRUE,
          'multiple' => TRUE,
        ),
      ],
      'activity_date_time' => [
        'add' => 'add',
        'type' => 'datepicker',
        'label' => ts('Date Scheduled'),
        'required' => TRUE,
      ],
      'created_date' => [
        'add' => 'add',
        'type' => 'datepicker',
        'label' => ts('Date Added'),
        'required' => TRUE,
      ],
      'assignee_id' => [
        'add' => 'addEntityRef',
        'label' => ts('Assigned to'),
        'required' => TRUE,
        'entityRefDetails' => array(
          'api' => array(
            'params' => array('contact_type' => 'Individual'),
          ),
          'create' => TRUE,
          'multiple' => TRUE,
        ),
      ],
      'custom_66' => [
        'add' => 'addEntityRef',
        'label' => ts('Activity Suggested By'),
        'required' => FALSE,
        'entityRefDetails' => array(
          'api' => array(
            'params' => array('contact_type' => 'Individual'),
          ),
          'placeholder' => ts('- Select Contact -'),
          'create' => TRUE,
          'multiple' => TRUE,
        ),
      ],
      'status_id' => [
        'add' => 'addEntityRef',
        'label' => ts('Activity Status'),
        'required' => TRUE,
        'entityRefDetails' => array(
          'entity' => 'option_value',
          'api' => array(
            'params' => array('option_group_id' => 'activity_status'),
          ),
          'placeholder' => ts('- Select Activity Status -'),

          'select' => array('minimumInputLength' => 0),
        ),
      ],

      // TODO need to set up customization to track this
      'reason' => [
        'add' => 'addElement',
        'type' => 'text',
        'label' => ts('Reason'),
        'required' => FALSE,
      ],

      // TODO need to set up customization to track this
      'modified_date' => [
        'add' => 'add',
        'type' => 'datepicker',
        'label' => ts('Status Change Date'),
        'required' => FALSE,
      ],

      'details' => [
        'add' => 'addElement',
        'type' => 'textarea',
        'label' => ts('Additional Notes'),
        'required' => FALSE,
      ],

      'custom_67' => [
        'add' => 'addEntityRef',
        'label' => ts('Ask Made'),
        'required' => FALSE,
        'entityRefDetails' => array(
          'entity' => 'option_value',
          'placeholder' => ts('- Select Ask Type -'),
          'api' => array(
            'params' => array('option_group_id' => 'activity_type'),
          ),
          'select' => array(
            'minimumInputLength' => 0,
          ),
        ),
      ],
      'custom_68' => [
        'add' => 'addElement',
        'type' => 'text',
        'label' => ts('Other Ask Type'),
        'required' => FALSE,
      ],
      'custom_69' => [
        'add' => 'addMoney',
        'label' => ts('Ask Amount'),
      ],
      // TODO need to figure out how to save files appropriately
      'file_id' => [
        'add' => 'addElement',
        'type' => 'file',
        'label' => ts('Upload Document'),
      ],
    ];
  }

  public function buildQuickForm() {
    $resources = CRM_Core_Resources::singleton();
    $resources->addScriptFile('com.aghstrategies.movesmanagement', 'js/movesactivity.js');
    $resources->addStyleFile('com.aghstrategies.movesmanagement', 'css/movesactivity.css');
    $fields = self::activityFields();
    $numberOfActivities = 0;
    $defaults = [];
    while ($numberOfActivities <= 3) {
      foreach ($fields as $fieldName => $fieldDetails) {
        $name = $fieldName . "-$numberOfActivities";
        switch ($fieldDetails['add']) {
          case 'addEntityRef':
            if ($numberOfActivities > 0 && $fieldName == 'activity_type_id') {
              $this->addEntityRef($name, "Follow Up Activity {$numberOfActivities}", $fieldDetails['entityRefDetails'], FALSE);
            }
            else {
              $this->addEntityRef($name, $fieldDetails['label'], $fieldDetails['entityRefDetails'], FALSE);
            }
            break;

          case 'addElement':
            $this->addElement($fieldDetails['type'], $name, $fieldDetails['label'], FALSE);
            break;

          case 'add':
            $this->add($fieldDetails['type'], $name, $fieldDetails['label'], [], FALSE);
            break;

          case 'addMoney':
            $this->addMoney($name, $fieldDetails['label'], FALSE, NULL, FALSE, 'currency', NULL, FALSE);
            break;

          default:
            // code...
            break;
        }
      }
      // Set defaults
      $defaults["created_date" . "-$numberOfActivities"] = date('Y-m-d G:i:s');
      $defaults["modified_date" . "-$numberOfActivities"] = date('Y-m-d G:i:s');

      // TODO need to create a susan ryan contact and hard code this here
      $defaults["assignee_id" . "-$numberOfActivities"] = 202;

      $numberOfActivities++;
    }

    $this->setDefaults($defaults);

    $this->addButtons(array(
      array(
        'type' => 'submit',
        'name' => E::ts('Submit'),
        'isDefault' => TRUE,
      ),
    ));

    // export form elements
    $this->assign('elementNames', $this->getRenderableElementNames());
    parent::buildQuickForm();
  }

  public function postProcess() {
    $values = $this->exportValues();
    $fields = self::activityFields();
    $numberOfActivities = 0;
    while ($numberOfActivities <= 3) {
      foreach ($fields as $field => $fieldDetails) {
        $name = $field . "-$numberOfActivities";
        if (!empty($values[$name])) {
          $activityParams[$numberOfActivities][$field] = $values[$name];
        }
      }
      if (!empty($values["activity_type_id-{$numberOfActivities}"])) {
        $activityParams[$numberOfActivities]['source_contact_id'] = "user_contact_id";
        $activityParams[$numberOfActivities]['priority_id'] = "Normal";
        try {
          $activity = civicrm_api3('Activity', 'create', $activityParams[$numberOfActivities]);
        }
        catch (CiviCRM_API3_Exception $e) {
          $error = $e->getMessage();
          CRM_Core_Error::debug_log_message(ts('API Error %1', array(
            'domain' => 'com.aghstrategies.movesmanagement',
            1 => $error,
          )));
        }
        if ($activity['is_error'] == 0) {
          CRM_Core_Session::setStatus(E::ts('Activities Created Successfully'), E::ts('Activities Created Successfully'), 'success');
        }
        else {
          CRM_Core_Session::setStatus(E::ts('Looks like something went wrong. This activity has not been saved. see the error log for more details'), E::ts('Activity Not Saved'), 'error');
        }
        // process attachments
        if (!empty($this->_submitFiles)) {
          if (!empty($this->_submitFiles['file_id-' . $numberOfActivities]['size']) &&
          $this->_submitFiles['file_id-' . $numberOfActivities]['size'] > 0 &&
          !empty($this->_submitFiles['file_id-' . $numberOfActivities]['name']) &&
          !empty($this->_submitFiles['file_id-' . $numberOfActivities]['type']) &&
          !empty($activity['id'])) {
            try {
              $file = civicrm_api3('Attachment', 'create', array(
                'entity_table' => 'civicrm_activity',
                'entity_id' => $activity['id'],
                'name' => $this->_submitFiles['file_id-' . $numberOfActivities]['name'],
                'mime_type' => $this->_submitFiles['file_id-' . $numberOfActivities]['type'],
                'content' => 'Activity Attachment',
              ));
            }
            catch (CiviCRM_API3_Exception $e) {
              $error = $e->getMessage();
              CRM_Core_Error::debug_log_message(ts('API Error %1', array(
                'domain' => 'com.aghstrategies.movesmanagement',
                1 => $error,
              )));
            }
            if ($file['is_error'] == 0) {
              CRM_Core_Session::setStatus(E::ts('Activity Attachment Created Successfully'), E::ts('Activity Attachment'), 'success');
            }
            else {
              CRM_Core_Session::setStatus(
                E::ts('Looks like something went wrong. This activity attachment has not been saved. see the error log for more details'),
                E::ts('Activity Attachment Not Saved'),
                'error'
              );
            }
          }
        }
      }
      $numberOfActivities++;
    }

    parent::postProcess();
  }

  /**
   * Get the fields/elements defined in this form.
   *
   * @return array (string)
   */
  public function getRenderableElementNames() {
    // The _elements list includes some items which should not be
    // auto-rendered in the loop -- such as "qfKey" and "buttons".  These
    // items don't have labels.  We'll identify renderable by filtering on
    // the 'label'.
    $elementNames = array();
    foreach ($this->_elements as $element) {
      /** @var HTML_QuickForm_Element $element */
      $label = $element->getLabel();
      if (!empty($label)) {
        $elementNames[substr($element->getName(), -1)][] = $element->getName();
      }
    }
    // print_r($elementNames); die();
    return $elementNames;
  }

  // TODO handle all validation in here
  // public function validate() {
  //   // TODO if user selects Activity id other require 'custom_65'
  // }

}
