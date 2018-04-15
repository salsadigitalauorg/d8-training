<?php

/**
 * @file
 * Contains \Drupal\rsvplist\Plugin\Block\RSVPBlock.
 */

namespace Drupal\rsvplist\Plugin\Block;

use \Drupal\Core\Block\BlockBase;
use \Drupal\Core\Session\AccountInterface;
use \Drupal\Core\Access\AccessResult;

/**
 * Provies a RSVP List block.
 *
 * @Block(
 *   id = "rsvp_block",
 *   admin_label = @Translation("RSVP Block"),
 *   category = @Translation("Blocks")
 * )
 */

class RSVPBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    return \Drupal::formBuilder()->getForm('\Drupal\rsvplist\Form\RSVPForm');
  }

  public function blockAccess(AccountInterface $account) {
    $node = \Drupal::routeMatch()->getParameter('node');
    $nid = !empty($node->nid->value) ? $node->nid->value : NULL;

    if (!empty($nid) && is_numeric($nid)) {
      return AccessResult::allowedIfHasPermission($account, 'view rsvplist');
    }

    return AccessResult::forbidden();
  }
}