<?php

/**
 * @file
 * Contains \Drupal\rsvplist\Form\RSVPForm.
 */

namespace Drupal\rsvplist\Form;

use \Drupal\Core\Database\Database;
use \Drupal\Core\Form\FormBase;
use \Drupal\Core\Form\FormStateInterface;
use \Drupal\Core\Messenger\MessengerInterface;
use \Drupal\user\Entity\User;

/**
 * Provides an RSVP Capture email form.
 */
class RSVPForm extends FormBase {

  /**
   * { @inheritdoc }
   */
  public function getFormId() {
    return 'rsvplist_email_form';
  }

  /**
   * { @inheritdoc }
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $node = \Drupal::routeMatch()->getParameter('node');
    $nid = !empty($node->nid->value) ? $node->nid->value : NULL;

    $form['email'] = [
      '#title' => t('Email address'),
      '#type' => 'email',
      '#size' => 25,
      '#descripton' => t('We\'ll send updates to the email address you provide.'),
      '#required' => TRUE,
    ];

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => t('RSVP'),
    ];

    $form['nid'] = [
      '#type' => 'hidden',
      '#value' => $nid,
    ];

    return $form;
  }

  /**
   * { @inheritdoc }
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    $value = $form_state->getValue('email');
    if (\Drupal::service('email.validator')->isValid($value) == FALSE) {
      $form_state->setErrorByName('email', t('The email address %mail is not valid', ['%mail' => $value]));
    }
  }

  /**
   * { @inheritdoc }
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $user = \Drupal\user\Entity\User::load(\Drupal::currentUser()->id());
    db_insert('rsvplist')
      ->fields([
        'mail' => $form_state->getValue('email'),
        'nid' => $form_state->getValue('nid'),
        'uid' => $user->id(),
        'created' => time(),
      ])
      ->execute();
    \Drupal::messenger()->addMessage(t('Thank you for your RSVP, you are on the list for the event.'));
  }

}