<?php

class mainComponents extends sfComponents
{

  public function executeFirst(sfWebRequest $request)
  {
    $tmp = Doctrine_Core::getTable('Article')
      ->createQuery('a')
      ->limit(1)
      ->execute();

    $this->article = $tmp[0];

  }

}

