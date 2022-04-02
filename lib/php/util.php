<?php

/**
 * 
 * This namespace is the heart of util.php, add all class that you need in your project.
 * 
 * @author kuzafty
 * @version 0
 * @licence MIT
 * 
 * */
namespace util {

    use \Exception as Exception;
    /**
     * 
     * Use this class to charge files after check if they are exactly that you want. Verify they with hash.
     * You can also try a test mode, just add three parameters: Path, empty string and a true value.
     * 
     * Why use four functions? Well, i didn't think about when i wrote it, but when i realize, you can read code easier at this way
     *  that in one function where you need to look for file extension parameter.
     * 
     * */
    class charge extends tools{

        /**
         * 
         * Use this function to get the content of a html file, you must know a hash for that file.
         * So this is maked to get the content you want without any modifications.
         * 
         * @param  string       $file       File path
         * @param  string       $hash       File hash to charge
         * @param  boolean      $test       Test mode
         * 
         * @return $content                 File content
         * @throws Exception                validFile exceptions
         * @throws Exception                File extension isn't html
         * @throws Exception                File doesn't match
         * 
         * */
        function html($file="", $hash = "", $test = false){

            // If you don't give a valid file. (Must be .html and can read)
            $this->validFile($file);
            $this->extension($file, 'html');

            // Get hash of file
            $hash_local = hash_file('sha256', $file);

            // Check hash match or test
            if(($hash_local === $hash) or $test){

                // Get content of file
                $content = file_get_contents($file);

                // return read content
                return $content;

            }else{
                // If hashes don't match
                throw new Exception("File hash doesn't match.");
            }

        }

        /**
         * 
         * Use to get a html line for add a style sheet
         * 
         * @param  string       $file       File path
         * @param  string       $hash       File hash
         * @param  boolean      $test       Test mode
         * 
         * @return string                   Html line
         * @throws Exception                validFile exceptions
         * @throws Exception                File extension isn't css
         * @throws Exception                File doesn't match 
         *          
         * */
        function css($file = "", $hash = "", $test = false){

            // If you don't give a valid file. (Must be .css and can read)
            $this->validFile($file);
            $this->extension($file, 'css');

            // Get file hash
            $hash_local = hash_file('sha256', $file);

            // Check hash match or test
            if(($hash === $hash_local) or $test){

                // Return html line
                return '<link rel="stylesheet" type="text/css" href="'.$file.'">';

            }else{

                // Hashes don't match
                throw new Exception("File hash doesn't match.");

            }

        }

        /**
         * 
         * Use to get a html line for add a javascript file
         * 
         * @param  string       $file       File path
         * @param  string       $hash       File hash
         * @param  boolean      $test       Test mode
         * 
         * @return string                   Html line
         * @throws Exception                validFile exceptions
         * @throws Exception                File extension isn't js
         * @throws Exception                File doesn't match   
         * 
         * */
        function js($file = "", $hash = "", $test = false){

            // If you don't give a valid file. (Must be .js and can read)
            $this->validFile($file);
            $this->extension($file, 'js');

            // Get file hash
            $hash_local = hash_file('sha256', $file);

            // Check hash match or test
            if(($hash === $hash_local) or $test){

                // Return html line
                return '<script type="text/javascript" src="'.$file.'"></script>';

            }else{

                // Hashes don't match
                throw new Exception("File hash doesn't match.");

            }

        }

        /**
         * 
         * Use to add a php file with require after check hash
         * 
         * @param  string       $file       File path
         * @param  string       $hash       File hash
         * @param  boolean      $test       Test mode
         * 
         * @throws Exception                validFile exceptions
         * @throws Exception                File extension isn't php
         * @throws Exception                File doesn't match   
         * 
         * */
        function php($file = "", $hash = "", $test = false){

            // If you don't give a valid file. (Must be .php and can read)
            $this->validFile($file);
            $this->extension($file, 'php');

            // Get file hash
            $hash_local = hash_file('sha256', $file);

            // Check hash match or test
            if(($hash === $hash_local) or $test){

                // add php file
                require $file;

            }else{

                // Hashes don't match
                throw new Exception("File hash doesn't match.");

            }

        }

    // End of class
    }
 
    /**
     * 
     * This class helps you to build a new web page, where you need to check files with a sha256.
     * 
     * */
    class web extends charge{
        
        // Array for php header
        private $php = array();

        // Web title
        private $title = "";

        // Language of web page
        private $lang = "";

        // Extra metadata between head tag
        private $metas = array();

        // Style sheets
        private $css = array();

        // Contents, in order of appearance
        private $contents = array();

        // JavaScript files
        private $js = array();

        // Charset
        private $charset = 'utf8';

        // Icon of web page
        private $ico = null;

        /**
         * 
         * Class constructor. Even you don't need to add any parameter, is recommended to add title and lang.
         * 
         * All other data can be added with other methods to be more readable for coder.
         * 
         * @param  string       $titleWeb   title of web page
         * @param  string       $langWeb    language
         * @param  mixed        $cssWeb     css files
         * @param  mixed        $jsWeb      javascript files
         * @param  string       $charset    symbols
         * @param  mixed        $metasWeb   html lines of metadata (Be careful)
         * 
         * */
        function __construct($titleWeb = "Home", $langWeb = "en", $cssWeb = null, $jsWeb = null, $charsetWeb = "utf8", $metasWeb = null){

            // Assign title
            $this->title = $titleWeb;

            // Assign language
            $this->lang = $langWeb;         

            // Assign style files in case of an array was given
            $this->css = (gettype($cssWeb) === 'array') ? $cssWeb : array();

            // Assign js files in case of an array was given
            $this->js = (gettype($jsWeb) === 'array') ? $jsWeb  : array();

            // Assign charset
            $this->charset = $charsetWeb;

            // Assign metadata
            $this->metas = (gettype($metasWeb) === 'array') ? $metasWeb : array();

        }

        /**
         * 
         * Use to add a file in the page. html goes to content, css to header, js before content and php to content.
         * html and php goes in order, if you look to put a php in header use addPHP()
         * 
         * @param  string       $file       File path
         * @param  string       $hash       File hash
         * @param  boolean      $test       Test mode
         * 
         * @throws Exception                validFile exceptions
         * @throws Exception                File extension isn't supported
         * 
         * */
        function add($file = "", $hash = "", $test = false){

            // Check for valid file
            $this->validFile($file);

            // info of extension of file
            $info = pathinfo($file, PATHINFO_EXTENSION);

            // Looking for suitable extension
            switch ($info) {
                // html content
                case 'html':
                    // make file content array with all data
                    $file_content = array($file, $hash, $test);
                    // Add content to array
                    array_push($this->contents, $file_content);
                    break;
                // style sheet
                case 'css':
                    // make file content array with all data
                    $file_content = array($file, $hash, $test);
                    // Add css file to array
                    array_push($this->css, $file_content);
                    break;
                // Scripts
                case 'js':
                    // make file content array with all data
                    $file_content = array($file, $hash, $test);
                    // Add js file to array
                    array_push($this->js, $file_content);
                    break;
                // Content php
                case 'php':
                    // make file content array with all data
                    $file_content = array($file, $hash, $test);
                    // Add content file to array
                    array_push($this->contents, $file_content);
                    break;
                // If file isn't supported
                default:
                    // Exception
                    throw new Exception("File extension isn't supported.");
                    break;
            }

        }

        /**
         * 
         * Use to add and execute a php file before all html final file.
         * 
         * @param  string       $file       File path
         * @param  string       $hash       File hash
         * @param  boolean      $test       Test mode
         * 
         * @throws Exception                validFile exceptions
         * @throws Exception                File extension isn't php
         * 
         * */
        function addPHP($file = "", $hash = "", $test = false){

            // If you don't give a valid file. (Must be .php and can read)
            $this->validFile($file);
            $this->extension($file, 'php');

            // make file content array with all data
            $file_content = array($file, $hash, $test);
            // Add content file to array
            array_push($this->php, $file_content);

        }

        /**
         * 
         * Use to add a icon in web tab.
         * 
         * @param  string       $file       File path
         * 
         * @throws Exception                validFile exceptions
         * @throws Exception                File extension isn't .ico
         * 
         * */
        function icon($file = ""){

            // If you don't give a valid file. (Must be .ico and can read)
            $this->validFile($file);
            $this->extension($file, 'ico');

            // Add ico
            $this->ico = $file;

        }

        /**
         *
         * Use to compile the web page and show it in current file.
         * 
         * @throws Exception                File doesn't match
         * 
         * */
        function make(){

            // Add php header files
            foreach($this->php as $path){
                // Send parameter and require file
                $this->php($path[0], $path[1], $path[2]);
            }
            // Start html 5 file
            echo '<!DOCTYPE html>';
            // Set language page and open html
            echo '<html lang="'.$this->lang.'">';
            // open header
            echo '<head>';
            // Set charset
            echo '<meta charset="'.$this->charset.'">';
            // Set title
            echo '<title>'.$this->title.'</title>';
            // Add css
            foreach ($this->css as $path) {
                // Send parameter and echo files
                echo $this->css($path[0], $path[1], $path[2]);
            }
            // Add icon
            if($this->ico != null){
                // Set icon
                echo '<link rel="icon" type="image/ico" href="'.$this->ico.'">';
            }
            // close header
            echo '</head>';
            // open body
            echo '<body>';
            // Add js files
            foreach($this->js as $path){
                // Set files
                echo $this->js($path[0], $path[1], $path[2]);
            }
            // Add contents
            foreach($this->contents as $path){
                // Check extension
                if(pathinfo($path[0], PATHINFO_EXTENSION) == 'html'){
                    // Add html content
                    echo $this->html($path[0], $path[1], $path[2]);
                }else{
                    // Add php content
                    $this->php($path[0], $path[1], $path[2]);
                }
            }
            // close body
            echo '</body>';
            // close html
            echo '</html>';

        }

    // End of class
    }

    /**
     * 
     * 
     * */
    class tools {

        /**
         * 
         * Use to verify a direction of a file. The file must exist and be readable.
         * 
         * @param  string       $file   Filepath to evaluate
         * 
         * @return true                 Use in case you need a boolean
         * @throws Exception            Empty parameter
         * @throws Exception            File or directory doesn't exist
         * @throws Exception            Given parameter isn't a file
         * @throws Exception            File isn't readable
         * 
         * */
        function validFile($file){  
            // If you give a empty parameter
            if($file == null){
                throw new Exception("Empty parameter.");
            }
            // Check path exists
            if(!file_exists($file)){
                throw new Exception("File or directory doesn't exist.");
            }
            // Check given parameter is a file.
            if(!is_file($file)){
                throw new Exception("Given parameter isn't a file.");
            }
            // Check file is readable
            if(!is_readable($file)){
                throw new Exception("File isn't readable.");
            }
            // We know that parameter is a file and is readable
            return true;
        }

        /**
         * 
         * Use to check if a given file has a needed extension
         * 
         * @param  string       $file   Filepath to evaluate
         * @param  string       $ext    File extension
         * 
         * @return true                 In case file extension match
         * @throws Exception            File extension needed doesn't match
         * 
         * */
        function extension($file, $ext){ 
            // get file extension
            $ext = pathinfo($file, PATHINFO_EXTENSION);
            // Check
            if($ext != $ext){
                // Exception
                throw new Exception("File extension needed doesn't match.");
            }
            // return true
            return true;
        }

    // End of class
    }

    /**
     * 
     * Use this class to debug a problem when you code.
     * All methods in this class are static. Call without instance the class.
     * 
     */
    class debug {

        /**
         * 
         * Use to get a trace of exception.
         * 
         * @param  mixed       $e      Exception object
         * @param  mixed       $seen   Internal
         * 
         */
        public static function debugTrace($e, $seen = null) {
            // Starter in case of multiple exceptions
            $starter = $seen ? 'Caused by: ' : '';
            // Instance of result variable
            $result = array();
            // If seen is false
            if (!$seen){
                // Instance of seen variable
                $seen = array();
            }
            // Get trace of exception
            $trace = $e->getTrace();
            // Previous exception
            $prev = $e->getPrevious();
            // Puts starter at firts, then class of exception, and finally message of exception
            $result[] = sprintf('%s%s: %s', $starter, get_class($e), $e->getMessage());
            // Get file of exception
            $file = $e->getFile();
            // Get line of exception
            $line = $e->getLine();
            // Bucle infinite
            while (true) {
                // Current file and line with the exception
                $current = "$file:$line";
                // In case $seen is an array and in that we have $current
                if (is_array($seen) && in_array($current, $seen)) {
                    // Then result is 
                    $result[] = sprintf(' ... %d more', count($trace)+1);
                    break;
                }
                /**
                 * 
                 * Make a description of where is the exception.
                 * first is namespace
                 * second is class
                 * third is function
                 * 
                 */
                $result[] = sprintf(' at %s%s%s(%s%s%s)',
                    count($trace) && array_key_exists('class', $trace[0]) ? str_replace('\\', '.', $trace[0]['class']) : '',
                    count($trace) && array_key_exists('class', $trace[0]) && array_key_exists('function', $trace[0]) ? '.' : '',
                    count($trace) && array_key_exists('function', $trace[0]) ? str_replace('\\', '.', $trace[0]['function']) : '(main)',
                    $line === null ? $file : basename($file),
                    $line === null ? '' : ':',
                    $line === null ? '' : $line);
                // Is $seen is just instanced
                if (is_array($seen)){
                    $seen[] = "$file:$line";
                }
                if (!count($trace)){
                    break;
                }
                $file = array_key_exists('file', $trace[0]) ? $trace[0]['file'] : 'Unknown Source';
                $line = array_key_exists('file', $trace[0]) && array_key_exists('line', $trace[0]) && $trace[0]['line'] ? $trace[0]['line'] : null;
                array_shift($trace);
            }
            // Finish result
            $result = join("<br>", $result);
            // Chech for another exception
            if ($prev){
                // Anidate exceptions in chain
                $result  .= "<br>" . debug::debugTrace($prev, $seen);
            }
            // Return statement
            return $result;
        }

    }  

}

 ?>