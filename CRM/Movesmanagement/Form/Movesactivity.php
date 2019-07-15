<?php

use CRM_Movesmanagement_ExtensionUtil as E;

/**
 * Form controller class
 *
 * @see https://docs.civicrm.org/dev/en/latest/framework/quickform/
 */
class CRM_Movesmanagement_Form_Movesactivity extends CRM_Core_Form {

  public function buildQuickForm() {

    // Use the 'option_value' entity for most "option" lists, e.g. event types, activity types, gender, individual_prefix, custom field options, etc.
    $this->addEntityRef('act_type', ts('Activity Type'), array(
      'entity' => 'option_value',
      'placeholder' => ts('- Select Activity Type -'),
      'api' => array(
        'params' => array('option_group_id' => 'activity_type'),
      ),
      'select' => array(
        'minimumInputLength' => 0,
      ),
    ), TRUE);

    $this->addEntityRef('with_contact', ts('Contact Name'), array(
      'api' => array(
        'params' => array('contact_type' => 'Individual'),
      ),
      'create' => TRUE,
      'multiple' => TRUE,
    ), TRUE);

    $this->add('datepicker', 'added_date', ts('Date Added'));

    $this->addEntityRef('assigned_to', ts('Assigned to'), array(
      'api' => array(
        'params' => array('contact_type' => 'Individual'),
      ),
      'create' => TRUE,
      'multiple' => TRUE,
    ), TRUE);

    $this->addEntityRef('suggested_by', ts('Activity Suggested By'), array(
      'api' => array(
        'params' => array('contact_type' => 'Individual'),
      ),
      'placeholder' => ts('- Select Contact -'),
      'create' => TRUE,
      'multiple' => TRUE,
    ));

    $this->addEntityRef('act_status', ts('Activity Status'), array(
      'entity' => 'option_value',
      'api' => array(
        'params' => array('option_group_id' => 'activity_status'),
      ),
      'placeholder' => ts('- Select Activity Status -'),

      'select' => array('minimumInputLength' => 0),
    ), TRUE);

    $this->add('datepicker', 'status_date', ts('Status Change Date'));

    $this->addElement('text', 'reason', ts('Reason'));
    $this->addElement('textarea', 'details', ts('Additional Notes'));

    $this->addEntityRef('ask_made', ts('Ask Made'), array(
      'entity' => 'option_value',
      'placeholder' => ts('- Select Ask Type -'),
      'api' => array(
        'params' => array('option_group_id' => 'activity_type'),
      ),
      'select' => array(
        'minimumInputLength' => 0,
      ),
    ));

    $this->addMoney('ask_amount', ts('Ask Amount'));

    $this->addElement('file', "file_id", ts('Upload Document'), 'size=30 maxlength=255');
    $this->addUploadElement('file_id');

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
    $options = $this->getColorOptions();
    CRM_Core_Session::setStatus(E::ts('You picked color "%1"', array(
      1 => $options[$values['favorite_color']],
    )));
    parent::postProcess();
  }

  public function getColorOptions() {
    $options = array(
      '' => E::ts('- select -'),
      '#f00' => E::ts('Red'),
      '#0f0' => E::ts('Green'),
      '#00f' => E::ts('Blue'),
      '#f0f' => E::ts('Purple'),
    );
    foreach (array('1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e') as $f) {
      $options["#{$f}{$f}{$f}"] = E::ts('Grey (%1)', array(1 => $f));
    }
    return $options;
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
