<?php

require_once 'wbartokenmod.civix.php';
use CRM_Wbartokenmod_ExtensionUtil as E;

/**
 * Get the case id when loading tokens.
 *
 * This is hacky for now because of limitations in the token hooks.
 * Ideally case_id would be passed to the hooks; instead we have to rely on _GET and _POST.
 *
 * @return int|null
 */
function _wbartokenmod_get_case_id() {
  // Hack to get case id from the url
  if (!empty($_GET['caseid'])) {
    \Civi::$statics['casetokens']['case_id'] = $_GET['caseid'];
  }
  // Extra hack to get it from the entry url after a form is posted
  if (empty(\Civi::$statics['casetokens']['case_id']) && !empty($_POST['entryURL'])) {
    $matches = array();
    preg_match('#caseid=(\d+)#', $_POST['entryURL'], $matches);
    \Civi::$statics['casetokens']['case_id'] = CRM_Utils_Array::value(1, $matches);
  }
  return isset(\Civi::$statics['casetokens']['case_id']) ? \Civi::$statics['casetokens']['case_id'] : NULL;
}

function wbartokenmod_civicrm_tokens(&$tokens) {
  $tokens['case_custom_date'] = array(
    'case_custom_date.start_date' => ts('Custom Start Date'),
    'case_custom_date.intake_date' => ts('Custom Intake Date'),
    'case_custom_date.dob_cl' => ts('Custom DOB (CL)'),
    'case_custom_date.child_1_dob' => ts('Custom Child 1 DOB'),
    'case_custom_date.child_2_dob' => ts('Custom Child 2 DOB'),
    'case_custom_date.child_3_dob' => ts('Custom Child 3 DOB'),
    'case_custom_date.marriage_date' => ts('Custom Marriage Date'),
    'case_custom_date.separation_date' => ts('Custom Separation Date'),
    'case_custom_date.hearing_1' => ts('Custom Hearing 1 Date'),
    'case_custom_date.support_order' => ts('Custom Support Order Date'),
    'case_custom_date.custody' => ts('Custom Custody Date'),
    'case_custom_date.parenting' => ts('Custom Parenting Date'),
    'case_custom_date.alimony' => ts('Custom Alimony Date'),
    'case_custom_date.gal_assigned' => ts('Custom GAL Assigned Date'),
    'case_custom_date.gal_report' => ts('Custom GAL Report Date'),
    'case_custom_date.restrain_issue' => ts('Custom Restraining Issue Date'),
    'case_custom_date.restrain_exp' => ts('Custom Restraining Expiration Date'),
    'case_custom_date.209a1' => ts('Custom 209A1 Date'),
    'case_custom_date.209a2' => ts('Custom 209A2 Date'),
    'case_custom_date.when_was_it_bought' => ts('Custom When was it bought Date'),
    'case_custom_date.dob_op' => ts('Custom DOB (OP) Date'),
  );
}

function wbartokenmod_civicrm_tokenValues(&$values, $cids, $job = NULL, $tokens = array(), $context = NULL) {
  if (empty($tokens['case_custom_date'])) {
    return;
  }
  else {
    foreach ($cids as $contact) {
      $caseId = _wbartokenmod_get_case_id();
      if ($caseId) {
        $result = civicrm_api3('Case', 'getsingle', [
          'return' => ["start_date", "custom_313", "custom_215", "custom_224", "custom_227", "custom_230", "custom_256", "custom_257", "custom_266", "custom_271", "custom_273", "custom_275", "custom_346", "custom_278", "custom_279", "custom_284", "custom_289", "custom_291", "custom_292", "custom_243", "custom_377"],
          'id' => $caseId,
        ]);
        if ($result['start_date']) {
          $values[$contact]['case_custom_date.start_date'] = DateTime::createFromFormat('Y-m-d', $result['start_date'])->format('m/d/y');
        }
        if ($result['custom_313']) {
          $values[$contact]['case_custom_date.intake_date'] = DateTime::createFromFormat('Y-m-d H:i:s', $result['custom_313'])->format('m/d/y');
        }
        if ($result['custom_215']) {
          $values[$contact]['case_custom_date.dob_cl'] = DateTime::createFromFormat('Y-m-d H:i:s', $result['custom_215'])->format('m/d/y');
        }
        if ($result['custom_224']) {
          $values[$contact]['case_custom_date.child_1_dob'] = DateTime::createFromFormat('Y-m-d H:i:s', $result['custom_224'])->format('m/d/y');
        }
        if ($result['custom_227']) {
          $values[$contact]['case_custom_date.child_2_dob'] = DateTime::createFromFormat('Y-m-d H:i:s', $result['custom_227'])->format('m/d/y');
        }
        if ($result['custom_230']) {
          $values[$contact]['case_custom_date.child_3_dob'] = DateTime::createFromFormat('Y-m-d H:i:s', $result['custom_230'])->format('m/d/y');
        }
        if ($result['custom_256']) {
          $values[$contact]['case_custom_date.marriage_date'] = DateTime::createFromFormat('Y-m-d H:i:s', $result['custom_256'])->format('m/d/y');
        }
        if ($result['custom_257']) {
          $values[$contact]['case_custom_date.separation_date'] = DateTime::createFromFormat('Y-m-d H:i:s', $result['custom_257'])->format('m/d/y');
        }
        if ($result['custom_266']) {
          $values[$contact]['case_custom_date.hearing_1'] = DateTime::createFromFormat('Y-m-d H:i:s', $result['custom_266'])->format('m/d/y');
        }
        if ($result['custom_271']) {
          $values[$contact]['case_custom_date.support_order'] = DateTime::createFromFormat('Y-m-d H:i:s', $result['custom_271'])->format('m/d/y');
        }
        if ($result['custom_273']) {
          $values[$contact]['case_custom_date.custody'] = DateTime::createFromFormat('Y-m-d H:i:s', $result['custom_273'])->format('m/d/y');
        }
        if ($result['custom_275']) {
          $values[$contact]['case_custom_date.parenting'] = DateTime::createFromFormat('Y-m-d H:i:s', $result['custom_275'])->format('m/d/y');
        }
        if ($result['custom_346']) {
          $values[$contact]['case_custom_date.alimony'] = DateTime::createFromFormat('Y-m-d H:i:s', $result['custom_346'])->format('m/d/y');
        }
        if ($result['custom_278']) {
          $values[$contact]['case_custom_date.gal_assigned'] = DateTime::createFromFormat('Y-m-d H:i:s', $result['custom_278'])->format('m/d/y');
        }
        if ($result['custom_279']) {
          $values[$contact]['case_custom_date.gal_report'] = DateTime::createFromFormat('Y-m-d H:i:s', $result['custom_279'])->format('m/d/y');
        }
        if ($result['custom_284']) {
          $values[$contact]['case_custom_date.restrain_issue'] = DateTime::createFromFormat('Y-m-d H:i:s', $result['custom_284'])->format('m/d/y');
        }
        if ($result['custom_289']) {
          $values[$contact]['case_custom_date.restrain_exp'] = DateTime::createFromFormat('Y-m-d H:i:s', $result['custom_289'])->format('m/d/y');
        }
        if ($result['custom_291']) {
          $values[$contact]['case_custom_date.209a1'] = DateTime::createFromFormat('Y-m-d H:i:s', $result['custom_291'])->format('m/d/y');
        }
        if ($result['custom_292']) {
          $values[$contact]['case_custom_date.209a2'] = DateTime::createFromFormat('Y-m-d H:i:s', $result['custom_292'])->format('m/d/y');
        }
        if ($result['custom_243']) {
          $values[$contact]['case_custom_date.dob_op'] = DateTime::createFromFormat('Y-m-d H:i:s', $result['custom_243'])->format('m/d/y');
        }
        if ($result['custom_377']) {
          $values[$contact]['case_custom_date.when_was_it_bought'] = DateTime::createFromFormat('Y-m-d H:i:s', $result['custom_377'])->format('m/d/y');
        }
      }
    }
  }
}

/**
 * Implements hook_civicrm_config().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_config
 */
function wbartokenmod_civicrm_config(&$config) {
  _wbartokenmod_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_xmlMenu().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_xmlMenu
 */
function wbartokenmod_civicrm_xmlMenu(&$files) {
  _wbartokenmod_civix_civicrm_xmlMenu($files);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_install
 */
function wbartokenmod_civicrm_install() {
  _wbartokenmod_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_postInstall().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_postInstall
 */
function wbartokenmod_civicrm_postInstall() {
  _wbartokenmod_civix_civicrm_postInstall();
}

/**
 * Implements hook_civicrm_uninstall().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_uninstall
 */
function wbartokenmod_civicrm_uninstall() {
  _wbartokenmod_civix_civicrm_uninstall();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_enable
 */
function wbartokenmod_civicrm_enable() {
  _wbartokenmod_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_disable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_disable
 */
function wbartokenmod_civicrm_disable() {
  _wbartokenmod_civix_civicrm_disable();
}

/**
 * Implements hook_civicrm_upgrade().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_upgrade
 */
function wbartokenmod_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _wbartokenmod_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implements hook_civicrm_managed().
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_managed
 */
function wbartokenmod_civicrm_managed(&$entities) {
  _wbartokenmod_civix_civicrm_managed($entities);
}

/**
 * Implements hook_civicrm_caseTypes().
 *
 * Generate a list of case-types.
 *
 * Note: This hook only runs in CiviCRM 4.4+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_caseTypes
 */
function wbartokenmod_civicrm_caseTypes(&$caseTypes) {
  _wbartokenmod_civix_civicrm_caseTypes($caseTypes);
}

/**
 * Implements hook_civicrm_angularModules().
 *
 * Generate a list of Angular modules.
 *
 * Note: This hook only runs in CiviCRM 4.5+. It may
 * use features only available in v4.6+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_angularModules
 */
function wbartokenmod_civicrm_angularModules(&$angularModules) {
  _wbartokenmod_civix_civicrm_angularModules($angularModules);
}

/**
 * Implements hook_civicrm_alterSettingsFolders().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_alterSettingsFolders
 */
function wbartokenmod_civicrm_alterSettingsFolders(&$metaDataFolders = NULL) {
  _wbartokenmod_civix_civicrm_alterSettingsFolders($metaDataFolders);
}

/**
 * Implements hook_civicrm_entityTypes().
 *
 * Declare entity types provided by this module.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_entityTypes
 */
function wbartokenmod_civicrm_entityTypes(&$entityTypes) {
  _wbartokenmod_civix_civicrm_entityTypes($entityTypes);
}

// --- Functions below this ship commented out. Uncomment as required. ---

/**
 * Implements hook_civicrm_preProcess().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_preProcess
 *
function wbartokenmod_civicrm_preProcess($formName, &$form) {

} // */

/**
 * Implements hook_civicrm_navigationMenu().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_navigationMenu
 *
function wbartokenmod_civicrm_navigationMenu(&$menu) {
  _wbartokenmod_civix_insert_navigation_menu($menu, 'Mailings', array(
    'label' => E::ts('New subliminal message'),
    'name' => 'mailing_subliminal_message',
    'url' => 'civicrm/mailing/subliminal',
    'permission' => 'access CiviMail',
    'operator' => 'OR',
    'separator' => 0,
  ));
  _wbartokenmod_civix_navigationMenu($menu);
} // */
