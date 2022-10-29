<?php

namespace Drupal\snappy_common\Service;

use Drupal\node\NodeInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Defines an interface for TodoHelperServiceInterface class.
 */
interface TodoHelperServiceInterface {

  /**
   * Delete an individual node.
   */
  public function delete(NodeInterface $node): void;

  /**
   * Redirect to todos page.
   */
  public function redirectToTodos(): RedirectResponse;

}
