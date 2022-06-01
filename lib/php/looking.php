<?php 

/**
 * 
 * This file helps you to create a search tool in your site.
 * By now you need to create a xml file with all data of the objects to add to the index.
 * So, you can decide if a result must be in the index of search or not.
 * 
 */

namespace looking {

    use \Exception as Exception;

    /**
     * 
     * Use this class to get a result of a index (xml file).
     * 
     */
    class look {

        /**
         * 
         * This function return all nodes of an xml file
         * 
         * @param  string $file       File path
         * 
         * @return array              Array of nodes
         * @throws Exception          File does not exist
         * 
         */
        public static function getNodes($file) {

            $result = array();

            // Try to load file
            $xml = simplexml_load_file($file);

            // if file hasn't been readed.
            if(!$xml) {
                throw new Exception("File doesn't readable.");
            }

            // Get nodes
            foreach($xml as $node){
                array_push($result, $node);
            }

            return $result;

        }

    }

    /**
     * 
     * Personalized exceptions for this namespace.
     * 
     */

    // Index error
    class XmlIndexException extends Exception {

        /**
         * 
         * Exception function constructor.
         * 
         */
        function __construct ($msg, $code = 0, Exception $Previous = null) {

            // All assings are properly
            parent::__construct($msg, $code, $Previous);

        }

    }  

}

?>