<?php

namespace Drupal\snappy_common\Service;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Url;
use Drupal\node\NodeInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Todo helper service class for snappy_common.
 */
class TodoHelperService implements TodoHelperServiceInterface {

  /**
   * Entity Type Manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected EntityTypeManagerInterface $entityTypeManager;

  /**
   * Creates a new TodoHelperService instance.
   *
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   Entity type manager parameter.
   */
  public function __construct(EntityTypeManagerInterface $entity_type_manager) {
    $this->entityTypeManager = $entity_type_manager;
  }

  /**
   * {@inheritdoc}
   */
  public function delete(NodeInterface $node): void {
    $this->entityTypeManager->getStorage('node')->delete([$node]);
  }

  /**
   * {@inheritdoc}
   */
  public function redirectToTodos(): RedirectResponse {
    $url = Url::fromRoute('<front>');
    return new RedirectResponse($url->toString());
  }

}
