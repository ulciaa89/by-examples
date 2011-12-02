<?php

/**
 * sample actions.
 *
 * @package    symfony-1-4-social-startup
 * @subpackage sample
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class sampleActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->samples = Doctrine_Core::getTable('Sample')
      ->createQuery('a')
      ->where('a.created_by = ?', $this->getUser()->getGuardUser()->getId())
      ->execute();
  }

  public function executeShow(sfWebRequest $request)
  {
    $this->sample = Doctrine_Core::getTable('Sample')->find(array($request->getParameter('id')));
    $this->forward404Unless($this->sample);

    if ($this->getUser()->getGuardUser()->getId() != $this->sample->getCreatedBy()) {
        $this->forward404();
    }
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new SampleForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new SampleForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {

    $sample = Doctrine_Core::getTable('Sample')->find(array($request->getParameter('id')));
    $this->forward404Unless($sample, sprintf('Object sample does not exist (%s).', $request->getParameter('id')));

    if ($this->getUser()->getGuardUser()->getId() != $sample->getCreatedBy()) {
        $this->forward404();
    }

    $this->form = new SampleForm($sample);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $sample = Doctrine_Core::getTable('Sample')->find(array($request->getParameter('id')));
    $this->forward404Unless($sample, sprintf('Object sample does not exist (%s).', $request->getParameter('id')));

    if ($this->getUser()->getGuardUser()->getId() != $sample->getCreatedBy()) {
        $this->forward404();
    }

    $this->form = new SampleForm($sample);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();
    $sample = Doctrine_Core::getTable('Sample')->find(array($request->getParameter('id')));
    $this->forward404Unless($sample, sprintf('Object sample does not exist (%s).', $request->getParameter('id')));

    if ($this->getUser()->getGuardUser()->getId() != $sample->getCreatedBy()) {
        $this->forward404();
    }

    $sample->delete();

    $this->redirect('sample/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $sample = $form->save();

      $this->redirect('sample/edit?id='.$sample->getId());
    }
  }
}
