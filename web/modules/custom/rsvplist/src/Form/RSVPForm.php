<?php

/**
 * @file
 * Contains \Drupal\rsvplist\Form\RSVPForm
 */

namespace Drupal\rsvplist\Form;

use \Drupal\Core\Database\Database;
use \Drupal\Core\Form\FormBase;
use \Drupal\Core\Form\FormStateInterface;
use \Drupal\Core\Messenger\MessengerInterface;

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
  public function submitForm(array &$form, FormStateInterface $form_state) {
    \Drupal::messenger()->addMessage(t('This RSVP form is working'));
    \Drupal::logger('rsvpform')->notice(t('The form is working'));
  }

}