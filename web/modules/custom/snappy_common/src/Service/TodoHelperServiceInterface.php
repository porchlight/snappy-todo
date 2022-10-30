<?php

namespace Drupal\snappy_common\Service;

use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Defines an interface for TodoHelperServiceInterface class.
 */
interface TodoHelperServiceInterface {

  /**
   * Delete an array of node ids.
   *
   * @param array $nids
   *   Array of node ids to delete.
   */
  public function delete(array $nids): void;

  /**
   * Redirect to todos page.
   */
  public function redirectToTodos(): RedirectResponse;

}
