<?php

namespace Drupal\snappy_common\Controller;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Access\AccessResultInterface;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\node\NodeInterface;
use Drupal\snappy_common\Service\TodoHelperServiceInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Controller to delete individual todo nodes.
 *
 * Deletes the todo node and redirects back to todo page.
 */
class DeleteTodoController implements ContainerInjectionInterface {

  /**
   * The todo helper service.
   *
   * @var \Drupal\snappy_common\TodoHelperServiceInterface
   */
  protected $todoHelper;

  /**
   * Constructor.
   *
   * @param \Drupal\snappy_common\TodoHelperServiceInterface $todo_helper
   *   The todo helper service.
   */
  public function __construct(TodoHelperServiceInterface $todo_helper) {
    $this->todoHelper = $todo_helper;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('snappy_common.todo_helper'),
    );
  }

  /**
   * Deletes an individual node and returns to todos page
   *
   * @param \Drupal\node\NodeInterface $node
   *   The node.
   *
   * @return \Symfony\Component\HttpFoundation\RedirectResponse
   *   The redirect response.
   */
  public function delete(NodeInterface $node): RedirectResponse {
    $this->todoHelper->delete($node);
    return $this->todoHelper->redirectToTodos();
  }

  /**
   * Check user has access to delete the todo.
   *
   * @param \Drupal\Core\Session\AccountInterface $account
   *   The current users account.
   *
   * @return \Drupal\Core\Access\AccessResultInterface
   *   The access result.
   */
  public function access(AccountInterface $account): AccessResultInterface {
    // Check if they access to delete their own todos and they created the todo.
    return AccessResult::allowedIf($account->hasPermission('do example things') && $this->deletedByAuthor($account));
  }

  /**
   * Check user has access to delete the todo.
   *
   * @param \Drupal\Core\Session\AccountInterface $account
   *   The current users account.
   *
   * @return bool
   *   Whether or not the current user created the node.
   */
  public function deletedByAuthor(AccountInterface $account): bool {
    $access = FALSE;
    // Get the current route match
    return $access;
  }

}
