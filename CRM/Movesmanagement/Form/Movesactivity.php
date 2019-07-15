<?php

use CRM_Movesmanagement_ExtensionUtil as E;

/**
 * Form controller class
 *
 * @see https://docs.civicrm.org/dev/en/latest/framework/quickform/
 */
class CRM_Movesmanagement_Form_Movesactivity extends CRM_Core_Form {

  // public function validate() {
  //   // TODO if user selects Activity id other require 'custom_65'
  // }

  public function buildQuickForm() {

    CRM_Core_Resources::singleton()->addScriptFile('com.aghstrategies.movesmanagement', 'js/movesactivity.js');

    $this->addEntityRef('activity_type_id', ts('Activity Type'), array(
      'entity' => 'option_value',
      'placeholder' => ts('- Select Activity Type -'),
      'api' => array(
        'params' => array('option_group_id' => 'activity_type'),
      ),
      'select' => array(
        'minimumInputLength' => 0,
      ),
    ), TRUE);

    $this->addElement('text', 'custom_65', ts('Other Activity Type'));

    $this->addEntityRef('target_id', ts('Contact Name'), array(
      'api' => array(
        'params' => array('contact_type' => 'Individual'),
      ),
      'create' => TRUE,
      'multiple' => TRUE,
    ), TRUE);

    $this->add('datepicker', 'activity_date_time', ts('Date Scheduled'), [], TRUE);
    $this->add('datepicker', 'created_date', ts('Date Added'), [], TRUE);

    $this->addEntityRef('assignee_id', ts('Assigned to'), array(
      'api' => array(
        'params' => array('contact_type' => 'Individual'),
      ),
      'create' => TRUE,
      'multiple' => TRUE,
    ));

    $this->addEntityRef('custom_66', ts('Activity Suggested By'), array(
      'api' => array(
        'params' => array('contact_type' => 'Individual'),
      ),
      'placeholder' => ts('- Select Contact -'),
      'create' => TRUE,
      'multiple' => TRUE,
    ));

    $this->addEntityRef('status_id', ts('Activity Status'), array(
      'entity' => 'option_value',
      'api' => array(
        'params' => array('option_group_id' => 'activity_status'),
      ),
      'placeholder' => ts('- Select Activity Status -'),

      'select' => array('minimumInputLength' => 0),
    ), TRUE);

    // TODO need to set up customization to track
    // TODO need to write js to hide reason unless status is canceled to onhold
    $this->addElement('text', 'reason', ts('Reason'));

    // TODO need to set up customization to track this instead of using modified date
    $this->add('datepicker', 'modified_date', ts('Status Change Date'));

    $this->addElement('textarea', 'details', ts('Additional Notes'));

    $this->addEntityRef('custom_67', ts('Ask Made'), array(
      'entity' => 'option_value',
      'placeholder' => ts('- Select Ask Type -'),
      'api' => array(
        'params' => array('option_group_id' => 'activity_type'),
      ),
      'select' => array(
        'minimumInputLength' => 0,
      ),
    ));

    $this->addElement('text', 'custom_68', ts('Other Ask Type'));

    $this->addMoney('custom_69', ts('Ask Amount'), FALSE, NULL, FALSE, 'currency', NULL, FALSE);

    // TODO need to figure out how to save files appropriately
    $this->addElement('file', "file_id", ts('Upload Document'), 'size=30 maxlength=255');
    $this->addUploadElement('file_id');

    $defaults = [
      'created_date' => date('Y-m-d G:i:s'),
      'modified_date' => date('Y-m-d G:i:s'),

      // TODO need to create a susan ryan contact and hard code this here
      'assignee_id' => 202,
    ];

    $this->setDefaults($defaults);

    $this->addButtons(array(
      array(
        'type' => 'submit',
        'name' => E::ts('Submit'),
        'isDefault' => TRUE,
      ),
      array(
        'type' => 'follow',
        'name' => E::ts('Add Follow Up Activity'),
        'isDefault' => TRUE,
      ),
    ));

    // export form elements
    $this->assign('elementNames', $this->getRenderableElementNames());
    parent::buildQuickForm();
  }

  public function postProcess() {
    $values = $this->exportValues();
    $activityParams = [
      'source_contact_id' => "user_contact_id",
      'priority_id' => "Normal",
    ];

    $activityFields = [
      'activity_type_id',

      // Other Activity Type
      'custom_65',

      // Activity Suggested By
      'custom_66',

      // Ask Made
      'custom_67',

      // Other Ask Type
      'custom_68',

      // Ask Amount
      'custom_69',

      'activity_date_time',
      'subject',
      'target_id',
      'assignee_id',
      'created_date',
      'status_id',
      'details',
    ];

    foreach ($activityFields as $key => $field) {
      if (!empty($values[$field])) {
        $activityParams[$field] = $values[$field];
      }
    }

    try {
      $activity = civicrm_api3('Activity', 'create', $activityParams);
    }
    catch (CiviCRM_API3_Exception $e) {
      $error = $e->getMessage();
      CRM_Core_Error::debug_log_message(ts('API Error %1', array(
        'domain' => 'com.aghstrategies.movesmanagement',
        1 => $error,
      )));
    }
    if ($activity['is_error'] == 0) {
      CRM_Core_Session::setStatus(E::ts('Activity Created Successfully'), E::ts('Activity Created Successfully'), 'success');
    }
    else {
      CRM_Core_Session::setStatus(E::ts('Looks like something went wrong. This activity has not been saved. see the error log for more details'), E::ts('Activity Not Saved'), 'error');
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
        $elementNames[] = $element->getName();
      }
    }
    return $elementNames;
  }

}
