<?php

namespace Drupal\unt_news\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a 'UntNewsBlock' block.
 *
 * @Block(
 *  id = "unt_news_block",
 *  admin_label = @Translation("UNT News block"),
 *  context_definitions = {
 *    "node" = @ContextDefinition ("entity:node", label = @Translation ("Node"), required = FALSE,)
 *   }
 * )
 */
class UntNewsBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * @var \Drupal\unt_news\UntNewsClient
   */
  protected $untNewsClient;

  /**
   * UntEvents constructor
   * @param array $configuration
   * @param $plugin_id
   * @param $plugin_definition
   * @param $unt_news_client \Drupal\unt_news\UntNewsClient
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, \Drupal\unt_news\UntNewsClient $unt_news_client) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);

    $this->untNewsClient = $unt_news_client;
  }

  /**
   * {@inheritdoc }
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('unt_news_client')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build() {

    $node = $this->getContextValue('node');
    if($node){
      $dept = $node->get('field_department')->getValue();
      $deptId = $dept[0]['target_id'];
      $dept_news = $this->untNewsClient->getList($deptId);

      $build = [
        '#theme' => 'unt_news_block',
        '#content' => $dept_news,
      ];

      return $build;
    }
  }
}
