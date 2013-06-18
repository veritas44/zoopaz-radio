<?php

/*
Copyright 2013 Weldon Sams

Licensed under the Apache License, Version 2.0 (the "License");
you may not use this file except in compliance with the License.
You may obtain a copy of the License at

   http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.
*/

class Config {
    private static $singleton;
    public function __construct () {
        // This is the root directory that contains your web directories.
        // See the variables below for its use.
        $this->webroot = "/var/www/nas";

        $this->host = "https://www.example.com";

        // This is the root directory of your music archive.
        // Absolute path - no trailing slash.
        $this->defaultMp3Dir = "{$this->webroot}/www.example.com/htdocs/music";

        // This is the root URL to the root location of your music archive. {@see $this->defaultMp3Dir}
        // No trailing slash.
        $this->defaultMp3Url = "{$this->host}/music";

        // This is the root directory of this streaming application.
        // Absolute path - no trailing slash.
        $this->streamsRootDir = "{$this->webroot}/www.example.com/htdocs/streams";

        // This is the root URL to the root location of this streaming application. {@see $this->streamsRootDir}
        // No trailing slash.
        $this->streamsRootDirUrl = "{$this->host}/streams";

        // This is a directory where temporary files are stored for downloading albums.
        // Inside $this->tmpDir a directory named 'downloadAlbum' will be created. Inside that directory
        //     we'll create zip archives for downloading.
        // Install the following cronjob if you want to clean up this directory.
        //     30 5 * * * rm -Rf /tmp/downloadAlbum/*;
        $this->tmpDir = "/tmp";

        // Turn on logging and log to $this->loglocation
        $this->logging = true;
        $this->logfile = "access.log";

        // Valid music types
        $this->validMusicTypes = array("mp3", "m4a", "ogg");

        // Disable stopwords when generating search index
        $this->disableStopwords = false;

        // Maximum number of search results.
        $this->maxSearchResults = 100;

        // Location of search index file.
        $this->searchDatabase = $this->streamsRootDir . "/search.db";

        // Location of radio files index.
        $this->radioDatabase = $this->streamsRootDir . "/files.db";
    }

    public static function getInstance () {
        if (is_null(self::$singleton)) {
            self::$singleton = new Config();
        }
        return self::$singleton;
    }

    function getValidMusicTypes($type) {
        $ao = array();
        $o = "";
        foreach($this->validMusicTypes as $k=>$t) {
            $t = trim($t);
            $ao[] = strtolower($t);
            $ao[] = strtoupper($t);
        }
        if ($type == "preg") {
            $o = implode("|", $ao);
        } else if ($type == "glob") {
            $o = implode(",", $ao);
        }
        return $o;
    }
}