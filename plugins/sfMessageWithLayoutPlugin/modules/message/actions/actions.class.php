<?php

class messageActions extends sfActions
{
    public function executeShow(sfWebRequest $request)
    {
        $p = $request->getParameter('page', 'unavailable');
        $this->title = sfConfig::get('app_message_with_layout_' . $p . '_title');
        $this->text  = sfConfig::get('app_message_with_layout_' . $p . '_text');
        sfConfig::set('sf_web_debug', false);
    }
}
