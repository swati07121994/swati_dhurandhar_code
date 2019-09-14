<?php
/**
 * @file
 * Contains \Drupal\siteapikey\Controller\siteapikeyController.
 */
namespace Drupal\siteapikey\Controller;
use Drupal\node\NodeInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
class siteapikeyController{
    /**
     * @param $siteapikey- the API key parameter
     * @param NodeInterface $node - the node built from the node id parameter
     * @return JsonResponse
     */
    public function content($siteapikey, NodeInterface $node){
        // Site API Key configuration value
        $site_api_key_saved = \Drupal::config('system.site')->get('siteapikey');
        // Make sure the supplied node is a page, the configuration key is set and matches the supplied key
        if($node->getType() == 'page' && $site_api_key_saved != 'No API Key yet' && $site_api_key_saved == $siteapikey){
            // Respond with the json representation of the node
            return new JsonResponse($node->toArray(), 200, ['Content-Type'=> 'application/json']);
        }
        // Respond with access denied
        return new JsonResponse(array("error" => "access denied"), 401, ['Content-Type'=> 'application/json']);
    }
}