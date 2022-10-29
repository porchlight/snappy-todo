<?php

namespace Drupal\snappy_common\Service;

use Drupal\node\NodeInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Defines an interface for TodoHelperServiceInterface class.
 */
interface TodoHelperServiceInterface {

  /**
   * Delete an array of nodes.
   *
   * @param array $nodes
   *   Array of todo node objects to delete.
   */
  public function delete(array $nodes): void;

  /**
   * Redirect to todos page.
   */
  public function redirectToTodos(): RedirectResponse;

}
