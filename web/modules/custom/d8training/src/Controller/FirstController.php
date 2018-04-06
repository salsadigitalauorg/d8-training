<?php

/**
 * @file
 * Contains \Drupal\d8training\Controller\FirstController.
 */

namespace Drupal\d8training\Controller;

use \Drupal\Core\Controller\ControllerBase;

class FirstController extends ControllerBase {
  public function content() {
    return [
      '#type' => 'markup',
      '#markup' => t('This is my first, menu-linked page'),
    ];
  }
}