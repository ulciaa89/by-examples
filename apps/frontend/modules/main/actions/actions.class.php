<?php

/**
 * main actions.
 *
 * @package    symfony-1-4-social-startup
 * @subpackage main
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class mainActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
  }

 /**
  * Executes show action
  *
  * @param sfRequest $request A request object
  */
  public function executeShow(sfWebRequest $request)
  {
  }

 /**
  * Executes error 500
  *
  * @param sfRequest $request A request object
  */
  public function executeError500(sfWebRequest $request)
  {
      throw new Exception('Lorem ipsum...');
  }


 /**
  * Error 404 page
  *
  * @param sfRequest $request A request object
  */
  public function executeError404(sfWebRequest $request)
  {
  }


}
