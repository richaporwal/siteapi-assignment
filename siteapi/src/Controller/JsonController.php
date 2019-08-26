<?php

    namespace Drupal\siteapi\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * JsonController for the siteapi module.
 */
class JsonController extends ControllerBase {

  /**
   * Function to render JSON output for page node type.
   *
   * @param $api_key
   *   A String passed from the request URL
   *
   * @param $id
   *   A integer passed from the request URL
   *
   * @return \Symfony\Component\HttpFoundation\JsonResponse
   *
   *   A Json Response containing Node info or Error Message
   */
  public function renderJson($api_key, $id) {

    $site_api_key = \Drupal::config('system.site')->get('siteapikey');

    if ($api_key === $site_api_key) {
      // Check if the Node ID entered in the URL is Numeric and greater than 0.
      if (is_numeric($id) && $id > 0) {
        // Load the Node using the Node id from the request URL.
        $node_data = \Drupal::entityTypeManager()->getStorage('node')->load($id);

        if (!empty($node_data) && $node_data->getType() == 'page') {
          $json_response = json_encode($node_data->toArray());
          // Return the JSON Response.
          return new JsonResponse($json_response);
        }
        else {
          // Build JSON response.
          $json_response = [
            'Access Denied',
            'Reason : Node ID does not exist of type of page',
          ];
          // Return the JSON Response.
          return new JsonResponse($json_response);

        }

      }

      // Generate Response as Node ID is not Numeric.
      else {
        // Build JSON response.
        $json_response = [
          'Access Denied',
          'Reason : Invalid Node ID. Please enter numeric Node ID value only',
        ];
        // Return the JSON Response.
        return new JsonResponse($json_response);

      }

    }

    // Generate Response as API Key is not Valid.
    else {
      // Build JSON response.
      $json_response = [
        'Access Denied',
        'Reason : API Key Invalid',
      ];
      // Return JSON Response.
      return new JsonResponse($json_response);
    }

  }

}
