<?php

class FtpUpdater
{
    /*
     *  Array contains filenames to copy:
     *
     *  $_files[destination_filename] => source_filename
     *
     */

    private $_files = array();
    private $_ftp_server = '';
    private $_ftp_user_name = '';
    private $_ftp_user_pass = '';
    
/*
 * _remote_base_dir is deprecated - we perform ftp_chdir() and use relative path!
 * it is always empty string
 * 
 * 
 */
    private $_remote_base_dir = '';
    private $_ftp_conn_id = '';
    private $_dry_run = true;
    private $_only_if_modified = true;
    private $_dirs_to_create = array();

    public function __construct($server, $username, $password)
    {
        $this->_ftp_server = $server;
        $this->_ftp_user_name = $username;
        $this->_ftp_user_pass = $password;

        $this->_ftp_conn_id = ftp_connect($this->_ftp_server);
        $login_result = ftp_login($this->_ftp_conn_id, $this->_ftp_user_name, $this->_ftp_user_pass);

        if ((!$this->_ftp_conn_id) || (!$login_result)) {
            throw new sfException('Cannnot ftp_connect() or ftp_login()');
        } else {
            ftp_pasv($this->_ftp_conn_id, true);
        }
    }

    public function updateFile($destination_filename, $source_filename)
    {
        if ($this->getDryRun()) {
            echo 'File to update: ' . $destination_filename . "\n";
            return true;
        }

        $result = ftp_put($this->_ftp_conn_id, $destination_filename, $source_filename, FTP_BINARY);
        if ($result) {
            echo 'File ' . $destination_filename . " - updated\n";
        } else {
            echo '********ERROR / updateFile() / Destination ===> ' . $destination_filename . "\n";
        }
    }

    public function updateFiles()
    {
        $this->createDirectories();

        foreach ($this->_files as $remote => $local) {
            $this->updateFile($remote, $local);
        }
    }

    public function close()
    {
        ftp_close($this->_ftp_conn_id);
    }

    public function addFile($destination_filename, $source_filename)
    {
        /*
         * !!!!!
         * Do not use realpath() - this is not a local path! 
         * 
         */

        if ($this->getOnlyIfModified()) {

            if (filemtime($source_filename) > ftp_mdtm($this->_ftp_conn_id, $destination_filename)) {
                $index = $this->_remote_base_dir . $destination_filename;
                $this->_files[$index] = $source_filename;
            }
        } else {
            $index = $this->_remote_base_dir . $destination_filename;
            $this->_files[$index] = $source_filename;
        }
    }

    public function setBaseDir($remote_base_dir)
    {

        $result = ftp_chdir($this->_ftp_conn_id, $remote_base_dir);
        if (!$result) {
            throw new Exception(sprintf('Remote directory "%s" does not exists!', $remote_base_dir));
        }
        
        /*
          $this->_remote_base_dir = str_replace('\\', '/', $remote_base_dir);
          $this->_remote_base_dir = rtrim($this->_remote_base_dir, '/');
          if ($this->_remote_base_dir) {
          $this->_remote_base_dir .= '/';
          }
         */
    }

    public function createDirectory($directory)
    {
        if ($this->getDryRun()) {
            echo 'Directory to create: ' . $directory . "\n";
            return true;
        }

        $result = ftp_mkdir($this->_ftp_conn_id, $this->_remote_base_dir . $directory);
        if ($result) {
            echo 'Directory ' . $directory . " created.\n";
        } else {
            echo '********ERROR / createDirectory() ===> ' . $directory . "\n";
        }
    }

    public function createDirectories()
    {
        $this->discoverDirsToCreate();
        foreach ($this->_dirs_to_create as $dir_to_create) {
            $this->createDirectory($dir_to_create);
        }
    }

    public function discoverDirsToCreate()
    {
        foreach (array_keys($this->_files) as $f) {
            $tmp_dir = dirname($f);

            /*
             * !!!!!
             * Alert: file 'symfony' returns '.' dir
             * Remove it!
             * 
             */
            if ($tmp_dir && ($tmp_dir != '.')) {
                $parts = explode('/', $tmp_dir);
                $nb_parts = count($parts);
                $partial = $parts[0];
                $this->_dirs_to_create[] = $partial;
                for ($i = 1; $i < $nb_parts; $i++) {
                    $partial .= '/' . $parts[$i];
                    $this->_dirs_to_create[] = $partial;
                }
            }
        }
        sort($this->_dirs_to_create);
        $this->_dirs_to_create = array_unique($this->_dirs_to_create);
    }

    public function setDryRun($dry = true)
    {
        $this->_dry_run = $dry;
    }

    public function getDryRun()
    {
        return $this->_dry_run;
    }

    public function setOnlyIfModified($only_if_modified = true)
    {
        $this->_only_if_modified = $only_if_modified;
    }

    public function getOnlyIfModified()
    {
        return $this->_only_if_modified;
    }

}

