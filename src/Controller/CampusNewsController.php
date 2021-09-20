<?php

namespace Drupal\unt_news\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\unt_news\UntNewsClient;
use Drupal\user\Plugin\views\filter\Name;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class CampusStaffController.
 */
class CampusNewsController extends ControllerBase {

  private $untNewsClient;

  public function __construct(UntNewsClient $untNewsClient){

    $this->untNewsClient = $untNewsClient;
  }

  public static function create(ContainerInterface $container) {
    $untNewsClient = $container->get('unt_news_client');

    return new static($untNewsClient);
  }

  /**
   * Show the profile of a single staff member.
   *
   * @return Response
   *
   */
  public function showStory($storyId) {
    $api_response = $this->untNewsClient->getStory($storyId);

    $image = $api_response[0]['newsImage'] != '' ? $api_response[0]['newsImage'] : NULL;
    return [
      '#theme' => 'unt_news_story',
      '#name' => 'News Article',
      '#type' => 'markup',
      '#title' => $api_response[0]['newsHeadline'],
      '#content' =>  ['#markup' => $api_response[0]['newsBody']],
      '#department' => ['#markup' => $api_response[0]['newsDept']],
      '#image' => $image,
    ];
  }
}
