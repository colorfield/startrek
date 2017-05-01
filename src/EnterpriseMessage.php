<?php

namespace Drupal\startrek;

use Drupal\Core\Render\Markup;
use Drupal\Core\Render\Renderer;
use Drupal\Core\Entity\EntityTypeManager;

/**
 * Class EnterpriseMessage.
 *
 * @package Drupal\startrek
 */
class EnterpriseMessage implements EnterpriseMessageInterface {

  const MESSAGE_TYPE_LOGIN  = 'login';
  const MESSAGE_TYPE_LOGOUT = 'logout';

  /**
   * Drupal\Core\Render\Renderer definition.
   *
   * @var \Drupal\Core\Render\Renderer
   */
  protected $renderer;

  /**
   * Drupal\Core\Entity\EntityTypeManager definition.
   *
   * @var \Drupal\Core\Entity\EntityTypeManager
   */
  protected $entityTypeManager;

  /**
   * Drupal\startrek\StarTrekParserYAML definition.
   *
   * @var \Drupal\startrek\StarTrekParserYAML
   */
  protected $startrekYamlParser;

  /**
   * Constructor.
   */
  public function __construct(Renderer $renderer,
                              EntityTypeManager $entity_type_manager,
                              StarTrekParserYAML $startrek_yaml_parser) {
    $this->renderer = $renderer;
    $this->entityTypeManager = $entity_type_manager;
    $this->startrekYamlParser = $startrek_yaml_parser;
  }

  /**
   * Displays a login message.
   */
  public function setLoginMessage() {
    $this->setMessageType(self::MESSAGE_TYPE_LOGIN);
  }

  /**
   * Displays a logout message.
   */
  public function setLogoutMessage() {
    $this->setMessageType(self::MESSAGE_TYPE_LOGOUT);
  }

  /**
   * Displays a message.
   *
   * @param string $message_type
   *   Type of the message.
   */
  private function setMessageType($message_type) {
    // Parse the quotes file.
    $modulePath = drupal_get_path('module', 'startrek');
    $yamlPath = $modulePath . '/content/startrek.quote.yml';
    $parsedFile = $this->startrekYamlParser->parse($yamlPath);
    $availableQuotes = [];

    // @todo fallback message
    if (!empty($parsedFile['content'])) {
      foreach ($parsedFile['content'] as $quote) {
        if ($quote['type'] == $message_type) {
          $availableQuotes[] = $quote;
        }
      }
      // Pick a random quote and display it.
      $key = array_rand($availableQuotes, 1);
      $quote = $availableQuotes[$key]['body']['value'];
      $markup = Markup::create($quote);

      $build = [
        '#theme' => 'message',
        '#message' => $markup,
        '#attributes' => [
          'class' => [
            'startrek',
            'enterprise-message',
            $message_type,
          ],
        ],
        '#attached' => array(
          'library' => array(
            'startrek/startrek.styling',
          ),
        ),
      ];

      drupal_set_message($this->renderer->render($build));
    }
  }

}
