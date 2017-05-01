<?php

namespace Drupal\startrek\EventSubscriber;

use Drupal\Core\Entity\EntityTypeManager;
use Drupal\Core\Session\AccountInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Drupal\Core\Authentication\AuthenticationManager;
use Symfony\Component\HttpKernel\Event\PostResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Class CrewSubscriber.
 *
 * @package Drupal\startrek
 */
class CrewSubscriber implements EventSubscriberInterface {

  /**
   * Drupal\Core\Entity\EntityTypeManager definition.
   *
   * @var \Drupal\Core\Entity\EntityTypeManager
   */
  protected $entityTypeManager;

  /**
   * Drupal\Core\Authentication\AuthenticationManager definition.
   *
   * @var \Drupal\Core\Authentication\AuthenticationManager
   */
  protected $authentication;

  /**
   * The current account.
   *
   * @var \Drupal\Core\Session\AccountInterface
   */
  protected $account;

  /**
   * Constructor.
   */
  public function __construct(EntityTypeManager $entity_type_manager,
                              AuthenticationManager $authentication,
                              AccountInterface $account) {
    $this->entityTypeManager = $entity_type_manager;
    $this->authentication = $authentication;
    $this->account = $account;
  }

  /**
   * Called whenever the kernel.terminate event i dispatched.
   *
   * @param \Symfony\Component\HttpKernel\Event\PostResponseEvent $event
   *   The event to process.
   */
  public function enterpriseSetMessage(PostResponseEvent $event) {
    drupal_set_message('Event kernel.terminate thrown by Subscriber in module startrek.', 'status', TRUE);
  }

  /**
   * {@inheritdoc}
   */
  static public function getSubscribedEvents() {
    drupal_set_message('getSubscribedEvents');
    $events[KernelEvents::TERMINATE][] = ['enterpriseSetMessage'];
    return $events;
  }

}
