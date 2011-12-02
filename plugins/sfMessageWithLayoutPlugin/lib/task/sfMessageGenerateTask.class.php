<?php

/**
 * Generate single page using layout
 *
 * @package    symfony
 * @subpackage task
 * @author     Włodzimierz Gajda <gajdaw@gajdaw.pl>
 */
class sfMessageGenerateTask extends sfBaseTask
{

    /**
     * @see sfTask
     */
    protected function configure()
    {
         $this->addOptions(array(
            new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name', 'frontend'),
            new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
            new sfCommandOption('page', null, sfCommandOption::PARAMETER_REQUIRED, 'The page', 'unavailable'),
          ));

        $this->namespace = 'message';
        $this->name = 'generate';
        $this->briefDescription = 'Generate single page using layout';

        $this->detailedDescription = <<<EOF
The [message:generate|INFO] task creates a file with defined message using layout.

  [./symfony message:generate]
EOF;
    }

    /**
     * @see sfTask
     */
    protected function execute($arguments = array(), $options = array())
    {

        $app  = $options['application'];
        $env  = $options['env'];
        $page = $options['page'];


        $url = $this->getRouting()->generate('_generate_message', array('page' => $page), true);

        $contents = file_get_contents($url);

        $filename = sfConfig::get('app_message_with_layout_' . $page . '_filename');

        //generate all folders for $filename

        file_put_contents($filename, $contents);
    }

}