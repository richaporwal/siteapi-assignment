<?php

namespace Drupal\siteapi\Routing;

use Drupal\Core\Routing\RouteSubscriberBase;
use Symfony\Component\Routing\RouteCollection;

/**
 * Class SiteInfoRouteSubscriber.
 *
 * Listens to the dynamic route events.
 */
class SiteInfoRouteSubscriber extends RouteSubscriberBase {

  /**
   * {@inheritdoc}
   */
  protected function alterRoutes(RouteCollection $collection) {
  	//Alter Existing Routing.
    if ($route = $collection->get('system.site_information_settings')) {
      $route->setDefault('_form', 'Drupal\siteapi\Form\ExtendedSiteInformationForm');
    }
  }

}
