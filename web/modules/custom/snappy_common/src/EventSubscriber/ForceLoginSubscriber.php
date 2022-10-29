<?php

namespace Drupal\snappy_common\EventSubscriber;

use Drupal\Core\Path\CurrentPathStack;
use Drupal\Core\Path\PathValidatorInterface;
use Drupal\Core\Session\AccountProxyInterface;
use Drupal\Core\State\StateInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

/**
 * Class ForceLoginSubscriber.
 *
 * @package Drupal\snappy_common
 */
class ForceLoginSubscriber implements EventSubscriberInterface {

  /**
   * The state system.
   *
   * @var \Drupal\Core\State\StateInterface
   */
  protected $state;

  /**
   * The instantiated account.
   *
   * @var \Drupal\Core\Session\AccountProxy
   */
  protected $currentUser;

  /**
   * The current path.
   *
   * @var \Drupal\Core\Path\CurrentPathStack
   */
  protected $currentPath;

  /**
   * The Server API for this build of PHP.
   *
   * @var string
   */
  protected $sapi;

  /**
   * Constructor of a new ForceLoginSubscriber.
   *
   * @param \Drupal\Core\State\StateInterface $state
   *   The state system.
   * @param \Drupal\Core\Session\AccountProxyInterface $current_user
   *   The instantiated account.
   * @param \Drupal\Core\Path\CurrentPathStack $current_path
   *   The current path.
   * @param string $sapi
   *   (Optional) The Server API for this build of PHP.
   *   We need it to prevent skipping during tests.
   */
  public function __construct(
    StateInterface $state,
    AccountProxyInterface $current_user,
    CurrentPathStack $current_path,
    $sapi = PHP_SAPI
  ) {
    $this->state = $state;
    $this->currentUser = $current_user;
    $this->currentPath = $current_path;
    $this->sapi = $sapi;
  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    $events[KernelEvents::REQUEST][] = ['redirect', 100];
    return $events;
  }

  /**
   * Perform the anonymous user redirection, if needed.
   *
   * This method is called whenever the KernelEvents::REQUEST event is
   * dispatched.
   *
   * @param \Symfony\Component\HttpKernel\Event\GetResponseEvent $event
   *   The Event to process.
   */
  public function redirect(GetResponseEvent $event) {
    // Skip if maintenance mode is enabled.
    if ($this->state->get('system.maintenance_mode')) {
      return;
    }

    // Skip if running from the command-line.
    if ($this->sapi === 'cli') {
      return;
    }

    // Skip if the user is not anonymous.
    if (!$this->currentUser->isAnonymous()) {
      return;
    }

    // Get current request.
    $routeName = \Drupal::routeMatch()->getRouteName();
    if ($routeName != 'user.login'
      && $routeName != 'user.reset'
      && $routeName != 'user.reset.form'
      && $routeName != 'user.reset.login'
      && $routeName != 'user.pass'
    ) {
      $login_page = '/user/login';
      $event->setResponse(new RedirectResponse($login_page));
    }
    // // Determine the current path and alias.
    // $current_path = $this
    //   ->aliasManager
    //   ->getPathByAlias($this->currentPath->getPath($request));
    // $current = [
    //   'path' => $current_path,
    //   'alias' => $this->aliasManager->getAliasByPath($current_path),
    // ];

    // // Ignore PHP file requests.
    // if (substr($current['path'], -4) == '.php') {
    //   return;
    // }

    // $login_page = '/user/login';
    // $event->setResponse(new RedirectResponse($login_page));
  }
}
