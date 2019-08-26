<?php

namespace Drupal\siteapi\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\system\Form\SiteInformationForm;

/**
 * Class ExtendedSiteInformation.
 */
class ExtendedSiteInformationForm extends SiteInformationForm {

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    // Get system config settings.
    $site_config = $this->config('system.site');
    $form = parent::buildForm($form, $form_state);
    // Add new Field in existing Site Information Form.
    $form['site_information']['siteapikey'] = [
      '#type' => 'textfield',
      '#title' => t('Site API Key'),
      '#default_value' => $site_config->get('siteapikey') ?: 'No API Key yet',
      '#description' => t("Custom field to set the API Key"),
    ];
    // Update Form submit button value.
    if (!empty($site_config->get('siteapikey'))) {
      $form['actions']['submit']['#value'] = t('Update Configuration');
    }

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $site_api_key = $form_state->getValue('siteapikey');
    // Save value of siteapikey in system site config.
    $this->config('system.site')
      ->set('siteapikey', $site_api_key)
      ->save();
    parent::submitForm($form, $form_state);
    if (!empty($site_api_key) && $site_api_key != 'No API Key yet') {
      \Drupal::messenger()->addMessage(t('Site API Key has been saved with @siteapi', ['@siteapi' => $site_api_key]));
    }
  }

}
