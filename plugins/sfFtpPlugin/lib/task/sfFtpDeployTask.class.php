<?php

/*
 * This file is part of the symfony package.
 * (c) Fabien Potencier <fabien.potencier@symfony-project.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Deploy project using ftp
 *
 * @package    symfony
 * @subpackage task
 * @author     Wlodzimierz Gajda <gajdaw@kul.lublin.pl>
 */
class sfFtpDeployTask extends sfBaseTask
{

    /**
     * @see sfTask
     */
    protected function configure()
    {
        $this->addArguments(array(
            new sfCommandArgument('server', sfCommandArgument::REQUIRED, 'The server name'),
        ));

        $this->addOptions(array(
            new sfCommandOption('go', null, sfCommandOption::PARAMETER_NONE, 'A flag to force deployment', null),
            new sfCommandOption('all-files', null, sfCommandOption::PARAMETER_NONE, 'A flag to force update of all the files', null),
            new sfCommandOption('application', null, sfCommandOption::PARAMETER_OPTIONAL, 'The application name', 'frontend'),
            new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'prod'),
        ));


        $this->namespace = 'ftp';
        $this->name = 'deploy';
        $this->briefDescription = 'Deploy project using ftp';

        $this->detailedDescription = <<<EOF
The [ftp:deploy|INFO] task deploys project on a server:
    
  [./symfony ftp:deploy]    
  
Use --go flag to force deployment.

  [./symfony ftp:deploy --go]
EOF;
    }

    /**
     * @see sfTask
     */
    protected function execute($arguments = array(), $options = array())
    {

        $env = $arguments['server'];

        $ini = sfConfig::get('app_ftp_plugin_ftp_server', sfConfig::get('sf_config_dir') . '/ftp.ini');

        if (!file_exists($ini)) {
            throw new sfCommandException(sprintf('You must create a "%s" file', $ini));
        }

        $properties = parse_ini_file($ini, true);

        if (!isset($properties[$env])) {
            throw new sfCommandException(sprintf('You must define the configuration for server "%s" in "%ini"', $env, $ini));
        }

        $properties = $properties[$env];

        if (!isset($properties['host'])) {
            throw new sfCommandException('You must define a "host" entry.');
        }

        if (!isset($properties['user'])) {
            throw new sfCommandException('You must define a "user" entry.');
        }

        if (!isset($properties['password'])) {
            throw new sfCommandException('You must define a "password" entry.');
        }

        if (!isset($properties['dir'])) {
            throw new sfCommandException('You must define a "dir" entry.');
        }

        $host = $properties['host'];
        $remoteBaseDir = $properties['dir'];
        $user = $properties['user'];
        $password = $properties['password'];

        /* !!!!!
         * 
         * $remoteBaseDir must exist
         * Check it
         * Maybe: add chDir() command and remove basePath from destination files?
         * 
         */



        /*
         * 
         * Exclusions implemented after the search
         * Problem with sfFind: exclusion rule can not contain multiple folders, e.g.:
         * 
         *   ->not_name('web/frontend_dev.php')->discard('web/uploads/*')->
         * 
         * doesnt work!
         * 
         * 
         * Add path_to_search to options!
         * It will allow batch upload of arbitrary files (not necessarily files
         * of current project).
         * 
         */
        $path_to_serach = sfConfig::get('sf_root_dir');
        $files = sfFinder::type('file')->relative()->in($path_to_serach);


        /*
         * 
         * Exclusions have to be correct regular expressions!
         * Validate regular expressions!
         * 
         * 
         */
        $exclusions_filename = sfConfig::get('ftp_plugin_exclude_filename', sfConfig::get('sf_config_dir') . '/ftp_exclude.txt');
        $excludes = array();
        if (file_exists($exclusions_filename)) {
            foreach (file($exclusions_filename) as $exclude_item) {
                $exclude_item = trim($exclude_item);
                if ($exclude_item && !preg_match('/^;/', $exclude_item)) {
                    $excludes[] = $exclude_item;
                }
            }
        }

        
        /*
         * Remove excluded files.
         */
        foreach ($files as $k => $f) {
            foreach ($excludes as $re) {
                if (preg_match($re, $f)) {
                    unset($files[$k]);
                    break;
                }
            }
        }



        $updater = new FtpUpdater($host, $user, $password);

        $updater->setBaseDir($remoteBaseDir);
        $updater->setDryRun(!$options['go']);
        $updater->setOnlyIfModified(!$options['all-files']);

        foreach ($files as $f) {
            $updater->addFile($f, realpath(sfConfig::get('sf_apps_dir') . '/../' . $f));
        }

        $updater->updateFiles();
        $updater->close();
    }

}