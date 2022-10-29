<?php

namespace Drupal\snappy_common\Controller;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Access\AccessResultInterface;
use Drupal\Core\Database\Connection;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Session\AccountProxyInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\node\NodeInterface;
use Drupal\snappy_common\Service\TodoHelperServiceInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Controller to delete complete todos.
 *
 * Deletes completed todos and redirects back to todo page.
 */
class DeleteCompleteTodosController implements ContainerInjectionInterface {

  use StringTranslationTrait;

  /**
   * The todo helper service.
   *
   * @var \Drupal\snappy_common\TodoHelperServiceInterface
   */
  protected TodoHelperServiceInterface $todoHelper;

  /**
   * The current user.
   *
   * @var \Drupal\Core\Session\AccountProxyInterface
   */
  protected AccountProxyInterface $currentUser;

  /**
   * Entity Type Manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected EntityTypeManagerInterface $entityTypeManager;

  /**
   * Database Connection.
   *
   * @var \Drupal\Core\Database\Connection
   */
  protected Connection $database;

  /**
   * Constructor.
   *
   * @param \Drupal\snappy_common\TodoHelperServiceInterface $todo_helper
   *   The todo helper service.
   * @param \Drupal\Core\Session\AccountProxyInterface $current_user
   *   The current user.
   * @param \Drupal\Core\Database\Connection $database_connection
   *   The database connection.
   */
  public function __construct(
    TodoHelperServiceInterface $todo_helper,
    AccountProxyInterface $current_user,
    Connection $database_connection,
  ) {
    $this->todoHelper = $todo_helper;
    $this->currentUser = $current_user;
    $this->database = $database_connection;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('snappy_common.todo_helper'),
      $container->get('current_user'),
      $container->get('database'),
    );
  }

  /**
   * Deletes completed todos and redirects back to todo page.
   *
   * @return \Symfony\Component\HttpFoundation\RedirectResponse
   *   The redirect response.
   */
  public function deleteCompleteTodos(): RedirectResponse {
    // Use a query.
    $query = $this->database
      ->select('flagging', 'f')
      ->fields('f',['entity_id'])
      ->condition('flag_id', 'complete')
      ->condition('uid', $this->currentUser->id());
    $result = $query->execute()->fetchCol();
    if ($result) {
      $this->todoHelper->delete($result);
      \Drupal::messenger()->addMessage($this->t('Cleared all complete todos!'), 'status');
    }
    // Get all the completed todos.
    return $this->todoHelper->redirectToTodos();
  }

}
