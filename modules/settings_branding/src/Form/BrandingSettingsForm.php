<?php

namespace Drupal\settings_branding\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class BrandingSettingsForm
 */
class BrandingSettingsForm extends ConfigFormBase {

  public const CONFIGNAME  = 'settings.settings.branding';

  /**
   * @inheritdoc
   */
  protected function getEditableConfigNames() {
    return [self::CONFIGNAME, 'system.site'];
  }

  /**
   * @inheritdoc
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config(self::CONFIGNAME);

    $form['site_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Site name'),
      '#description' => $this->t('The name of the website which will also appear in the browser tab.'),
      '#default_value' => $config->get('site_name'),
    ];

    $form['site_slogan'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Site slogan'),
      '#description' => $this->t('The slogan of the website which will also appear in the browser tab.'),
      '#default_value' => $config->get('site_slogan'),
    ];

    $form['site_tagline'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Site tagline'),
      '#description' => $this->t('The tagline of the website.'),
      '#default_value' => $config->get('site_tagline'),
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * @inheritdoc
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
  }

  /**
   * @inheritdoc
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);

    $config = $this->config(self::CONFIGNAME);

    $config->set('site_name', $form_state->getValue('site_name'));
    $config->set('site_slogan', $form_state->getValue('site_slogan'));
    $config->set('site_tagline', $form_state->getValue('site_tagline'));
    $config->save();

    // Keep Drupal config in sync.
    $drupalConfig = $this->config('system.site');
    $drupalConfig->set('name',  $form_state->getValue('site_name'));
    $drupalConfig->set('slogan',  $form_state->getValue('site_slogan'));
    $drupalConfig->save();

  }

  /**
   * @inheritdoc
   */
  public function getFormId() {
    return 'settings_settings_branding_form';
  }
}
