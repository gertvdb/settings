<?php

namespace Drupal\settings_communication\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class CommunicationSettingsForm
 */
class CommunicationSettingsForm extends ConfigFormBase {

  public const CONFIGNAME  = 'settings.settings.communication';

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

    $form['email'] = [
      '#type' => 'email',
      '#title' => $this->t('Email'),
      '#description' => $this->t('The main email address used for communication. This should be an address ending in your site\'s domain to prevent this email being flagged as spam'),
      '#default_value' => $config->get('email'),
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

    $config->set('email', $form_state->getValue('email'));
    $config->save();

    // Keep Drupal config in sync.
    $drupalConfig = $this->config('system.site');
    $drupalConfig->set('mail',  $form_state->getValue('email'));
    $drupalConfig->save();

  }

  /**
   * @inheritdoc
   */
  public function getFormId() {
    return 'settings_settings_communication_form';
  }
}
