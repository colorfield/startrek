<?php

namespace Drupal\startrek\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Class DefaultController.
 *
 * @package Drupal\startrek\Controller
 */
class DefaultController extends ControllerBase {

  /**
   * Test.
   *
   * @return string
   *   Return Shacha string.
   */
  public function test() {
    \Drupal::service('startrek.enterprise.message')->setLoginMessage();
    return [
      '#type' => 'markup',
      '#markup' => $this->t('Implement method: test')
    ];
  }

}
