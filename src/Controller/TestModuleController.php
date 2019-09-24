<?php

namespace Drupal\test_module\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Drupal\Core\Controller\ControllerBase;


/**
 * Class TestModuleController
 * @package Drupal\test_module\Controller
 */

class TestModuleController extends ControllerBase
{
    
   /**
   * @param string $siteapikey
   * @param int $nid
   *
   * @return object JsonResponse
   */

  public  function myPage($siteapikey,$nid) {
  	

  	$siteapikey_saved = \Drupal::config('system.site')->get('siteapikey');

  	$data = \Drupal\node\Entity\Node::load($nid);

  	// $response = \Drupal::entityTypeManager()->getStorage('node')->loadByProperties(['type' => 'page','nid' => $nid]);

  	if (($siteapikey === $siteapikey_saved)&&isset($data)) {
	  	$response = array(
	  		'title' => $data->title->value,
	  		'body' => $data->body->value
	  	);

  	}
  	else {
  		$response = array('error-msg' => 'access denied');
  	}

    return new JsonResponse($response);
  }

  /**
   *
   * @param array $form
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   */

  public static function test_form_submit(&$form, \Drupal\Core\Form\FormStateInterface $form_state) {
  	$siteapikey = $form_state->getValue('siteapikey');
  	$siteapikey = ($siteapikey)? $siteapikey: 'No API Key';

  	$config = \Drupal::service('config.factory')->getEditable('system.site')->set('siteapikey',$siteapikey)->save();

  	dsm('Site API Key - '.$siteapikey);
  }

}