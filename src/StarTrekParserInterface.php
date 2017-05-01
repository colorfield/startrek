<?php

namespace Drupal\startrek;

/**
 * Interface StarTrekParserInterface.
 *
 * @package Drupal\startrek
 */
interface StarTrekParserInterface {

  /**
   * Parses a file and returns startrek content values.
   *
   * @param string $file_path
   *   The path to the file.
   * @param array $replacements
   *   An array of replacements to perform.
   *
   * @return array
   *   An array of values from the file.
   */
  public function parse($file_path, array $replacements = []);

}
