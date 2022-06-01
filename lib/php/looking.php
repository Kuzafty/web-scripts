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
         * This function return all nodes of an xml file as objects.
         * 
         * @param  string $file       File path
         * 
         * @return array              Array of nodes
         * @throws Exception          File does not exist
         * 
         */
        public static function getNodes($file) {

            // Try to load file
            $xml = simplexml_load_file($file);

            // if file hasn't been readed.
            if(!$xml) {
                throw new Exception("File doesn't readable.");
            }

            return $xml;

        }

        /**
         * 
         * This function return an array of xml objects with a given parameter. (Value insensitive) 
         * 
         * @param  string $file       File path
         * @param  string $parameter  Name of the parameter (Null acts as getNodes)
         * 
         * @return array              Array of xml objects
         * @throws Exception          File doesn't exist
         * 
         */
        public static function lookInsensitive($file, $parameter = null){

            // Get content
            $nodes = look::getNodes($file);

            // Make function work as a getNodes function.
            if ($parameter == null){
                return $nodes;
            }

            // Return array
            $return = array();

            // Check every node
            foreach($nodes as $node){

                // Get list of property in object
                $properties_useless = get_object_vars($node);
                
                // Get keys
                $properties = array_keys($properties_useless);
                
                // Check every property in list
                foreach($properties as $property){

                    // Match property
                    if($property == $parameter){
                        array_push($return, $node);
                    }

                }
            }

            return $return;

        }

        /**
         * 
         * This function return an array of xml objects with a given parameter and a given value.
         * 
         * @param  string $file       File path
         * @param  string $parameter  Name of the parameter (Null acts as getNodes)
         * @param  mixed  $value      Value to search (Null acts as lookInsensitive)
         * 
         * @return array              Array of xml objects
         * @throws Exception          File doesn't exist
         * 
         */
        public static function lookSensitive($file, $parameter = null, $value = null){

            // If parameter not provided
            if ($parameter == null){
                return look::getNodes($file);
            }

            // if value not provided
            if ($value == null){
                return look::lookInsensitive($file, $parameter);
            }

            // Get content
            $nodes = look::getNodes($file);

            // Make function work as a getNodes function.
            if ($parameter == null){
                return $nodes;
            }

            // Return array
            $return = array();

            // Check every node
            foreach($nodes as $node){

                // Get list of property in object
                $properties_useless = get_object_vars($node);
                
                // Get keys
                $properties = array_keys($properties_useless);
                
                // Check every property in list
                foreach($properties as $property){

                    // Match property and value
                    if(($property == $parameter) && ($node->$property == $value)){
                        array_push($return, $node);
                    }

                }

            }

            return $return;

        }

    } 

}

?>