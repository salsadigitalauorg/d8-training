<?php

/**
 * @file
 * Contains \Drupal\rsvplist\EnablerService.
 */

namespace Drupal\rsvplist;

use Drupal\Core\Database\Database;
use Drupal\node\Entity\Node;

/**
 * Defines a service for managing RSVP list enabler for nodes.
 */
class EnablerService {

  public function __construct() {

  }

  /**
   * Sets an individual node to be RSVP-enabled.
   *
   * @param \Drupal\Core\Entity\Node $node
   *   Node object.
   *
   * @throws \Exception
   *   Exception.
   */
  public function setEnabled(Node $node) {
    if (!$this->isEnabled($node)) {
      $insert = Database::getConnection()->insert('rsvplist_enabled');
      $insert->fields(['nid'], [$node->id()]);
      $insert->execute();
    }
  }

  /**
   * Checks if individual node is RSVP-enabled.
   *
   * @param \Drupal\Core\Entity\Node $node
   *  Node object.
   *
   * @return bool
   *  TRUE if node is enabled, or FALSE.
   */
  public function isEnabled(Node $node) {
    if ($node->isNew()) {
      return FALSE;
    }
    $select = Database::getConnection()->select('rsvplist_enabled', 're');
    $select->fields('re', ['nid']);
    $select->condition('nid', $node->id());
    $results = $select->execute();

    return !empty($results->fetchCol());
  }

  /**
   * Deletes enabled settings for an individual node.
   *
   * @param \Drupal\Core\Entity\Node $node
   *  Node object.
   */
  public function delEnabled(Node $node) {
    $delete = Database::getConnection()->delete('rsvplist_enabled');
    $delete->condition('nid', $node->id());
    $delete->execute();
  }

}