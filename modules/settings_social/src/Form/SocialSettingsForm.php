<?php

namespace Drupal\settings_social\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class SettingsForm
 *
 * @package Drupal\settings_social\Form
 */
class SocialSettingsForm extends ConfigFormBase {

  public const CONFIGNAME  = 'settings.settings.social';

  /**
   * @return string[]
   */
  private function socials() : array {
    return ['facebook', 'instagram', 'linkedin', 'youtube', 'vimeo'];
  }

  /**
   * @inheritdoc
   */
  protected function getEditableConfigNames() {
    return [self::CONFIGNAME];
  }

  /**
   * @inheritdoc
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config(self::CONFIGNAME);

    foreach ($this->socials() as $social) {
      $form[$social] = [
        '#type' => 'url',
        '#title' => $social,
        '#description' => $this->t('The %social page where people can reach you.', ['%social' => $social]),
        '#default_value' => $config->get($social),
      ];
    }

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
    foreach ($this->socials() as $social) {
      $config->set($social, $form_state->getValue($social));
    }
    $config->save();
  }

  /**
   * @inheritdoc
   */
  public function getFormId() {
    return 'settings_settings_social_form';
  }
}
