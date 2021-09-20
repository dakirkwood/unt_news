<?php

namespace Drupal\unt_news;

use Drupal\Component\Serialization\Json;

class UntNewsClient {
  /**
   * @var \GuzzleHttp\Client
   */

  protected $client;

  /**
   * UntStaffClient constructor
   * @param $http_client_factory \Drupal\Core\Http\ClientFactory
   */

  public function __construct(\Drupal\Core\Http\ClientFactory $http_client_factory){
    $this->client = $http_client_factory->fromOptions([
      'base_uri' => 'http://news.d9.loc'
    ]);
  }

  /**
   * Get the list of articles for this department
   *
   * @param int $deptId
   *
   * @return array
   */
  public function getList($deptId = 1){
    $response = $this->client->get('api/news', [
      'query' => [
        'department' => $deptId,
        '_format' => 'json',
      ],
    ]);
    return Json::decode($response->getBody());
  }

  /**
   * Show a single article.
   *
   * @param int $storyId
   *
   * @return array
   */
  public function getStory($storyId){
    $response = $this->client->get('api/story', [
      'query' => [
        'id' => $storyId,
        '_format' => 'json',
      ],
    ]);

    return Json::decode($response->getBody());

  }
}

