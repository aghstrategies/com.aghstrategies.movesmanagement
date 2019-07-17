<?php

require_once 'movesmanagement.civix.php';
use CRM_Movesmanagement_ExtensionUtil as E;

/**
 * Implements hook_civicrm_buildForm().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_buildForm/
 */
function movesmanagement_civicrm_buildForm($formName, &$form) {
  if ($formName == 'CRM_Activity_Form_Activity') {
    $form->add('text', 'reason', ts('Reason for Status Change'));
    $form->add('datepicker', 'date_change', ts('Date Status Changed'));
    CRM_Core_Resources::singleton()->addScriptFile('com.aghstrategies.movesmanagement', 'js/statusChange.js');
    $templatePath = realpath(dirname(__FILE__) . "/templates");
    CRM_Core_Region::instance('form-body')->add(array(
      'template' => "{$templatePath}/actChange.tpl",
    ));
    $defaults['date_change'] = date('Y-m-d G:i:s');
    $form->setDefaults($defaults);
  }
}

/**
 * Implements hook_civicrm_post().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_post/
 */
// function movesmanagement_civicrm_post($op, $objectName, $objectId, &$objectRef) {
//   if ($objectName == 'Activity' && $op == 'edit') {
//     $sql = "INSERT INTO civicrm_activity_status_change (activity_id, status_to_id) VALUES ({$objectRef->id}, {$objectRef->status_id});";
//     $dao = CRM_Core_DAO::executeQuery($sql);
//   }
// }

/**
 * Implements hook_civicrm_postProcess().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_postProcess/
 */
function movesmanagement_civicrm_postProcess($formName, &$form) {
  if ($formName == 'CRM_Activity_Form_Activity') {
    $reason = "na";
    if (!empty($form->_submitValues['reason'])) {
      $reason = $form->_submitValues['reason'];
    }
    // Check if status has changed

    $sql = "INSERT INTO civicrm_activity_status_change (activity_id, status_to_id, reason) VALUES ({$form->_activityId}, {$form->_submitValues['status_id']}, '" . $reason . "', );";
    $dao = CRM_Core_DAO::executeQuery($sql);
  }
}

function movesmanagement_checkForExisting($activityId, $status_to_id, $reason, $status_changed) {
  $sql = "SELECT id FROM civicrm_activity_status_change WHERE activity_id = {$activityId} AND status_to_id = {$status_to_id} AND date_changed = {$status_changed}";
  $dao = CRM_Core_DAO::executeQuery($sql);
  if ($dao->fetch()) {
    $dao->id;
  }

  $sql = "SELECT * civicrm_activity_status_change WHERE ;";
  $dao = CRM_Core_DAO::executeQuery($sql);
}

/**
 * Implements hook_civicrm_config().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_config/
 */
function movesmanagement_civicrm_config(&$config) {
  _movesmanagement_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_xmlMenu().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_xmlMenu
 */
function movesmanagement_civicrm_xmlMenu(&$files) {
  _movesmanagement_civix_civicrm_xmlMenu($files);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_install
 */
function movesmanagement_civicrm_install() {
  /* Create Activity Status Change Table */
  CRM_Core_DAO::executeQuery('CREATE TABLE IF NOT EXISTS civicrm_activity_status_change (
    id int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT "Change Id",
    activity_id int(10) unsigned NULL COMMENT "Activity Changed",
    status_to_id int(10) unsigned NULL COMMENT "Status changed to ID",
    status_from_id int(10) unsigned NULL COMMENT "Status changed from ID",
    reason varchar(64) COLLATE utf8_unicode_ci NULL COMMENT "Reason Changed",
    date_changed timestamp,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`activity_id`) REFERENCES civicrm_activity(`id`) ON DELETE CASCADE,
    UNIQUE KEY (`id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;');
  _movesmanagement_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_postInstall().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_postInstall
 */
function movesmanagement_civicrm_postInstall() {
  _movesmanagement_civix_civicrm_postInstall();
}

/**
 * Implements hook_civicrm_uninstall().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_uninstall
 */
function movesmanagement_civicrm_uninstall() {
  _movesmanagement_civix_civicrm_uninstall();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_enable
 */
function movesmanagement_civicrm_enable() {
  _movesmanagement_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_disable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_disable
 */
function movesmanagement_civicrm_disable() {
  _movesmanagement_civix_civicrm_disable();
}

/**
 * Implements hook_civicrm_upgrade().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_upgrade
 */
function movesmanagement_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _movesmanagement_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implements hook_civicrm_managed().
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_managed
 */
function movesmanagement_civicrm_managed(&$entities) {
  _movesmanagement_civix_civicrm_managed($entities);
}

/**
 * Implements hook_civicrm_caseTypes().
 *
 * Generate a list of case-types.
 *
 * Note: This hook only runs in CiviCRM 4.4+.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_caseTypes
 */
function movesmanagement_civicrm_caseTypes(&$caseTypes) {
  _movesmanagement_civix_civicrm_caseTypes($caseTypes);
}

/**
 * Implements hook_civicrm_angularModules().
 *
 * Generate a list of Angular modules.
 *
 * Note: This hook only runs in CiviCRM 4.5+. It may
 * use features only available in v4.6+.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_angularModules
 */
function movesmanagement_civicrm_angularModules(&$angularModules) {
  _movesmanagement_civix_civicrm_angularModules($angularModules);
}

/**
 * Implements hook_civicrm_alterSettingsFolders().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_alterSettingsFolders
 */
function movesmanagement_civicrm_alterSettingsFolders(&$metaDataFolders = NULL) {
  _movesmanagement_civix_civicrm_alterSettingsFolders($metaDataFolders);
}

/**
 * Implements hook_civicrm_entityTypes().
 *
 * Declare entity types provided by this module.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_entityTypes
 */
function movesmanagement_civicrm_entityTypes(&$entityTypes) {
  _movesmanagement_civix_civicrm_entityTypes($entityTypes);
}

// --- Functions below this ship commented out. Uncomment as required. ---

/**
 * Implements hook_civicrm_preProcess().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_preProcess
 *
function movesmanagement_civicrm_preProcess($formName, &$form) {

} // */

/**
 * Implements hook_civicrm_navigationMenu().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_navigationMenu
 *
function movesmanagement_civicrm_navigationMenu(&$menu) {
  _movesmanagement_civix_insert_navigation_menu($menu, 'Mailings', array(
    'label' => E::ts('New subliminal message'),
    'name' => 'mailing_subliminal_message',
    'url' => 'civicrm/mailing/subliminal',
    'permission' => 'access CiviMail',
    'operator' => 'OR',
    'separator' => 0,
  ));
  _movesmanagement_civix_navigationMenu($menu);
} // */
