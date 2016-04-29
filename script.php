<?php


namespace libs\security{

    class script  {
        public static function sanitise($document){
            return \HTMLDocument::sanitise($document);
        }


    }
}

namespace {
    class HTMLDocument  {
        //NOTE: URLS can only be absolute (src/href/data/..)
        public static function sanitise($document){

            //please add a list of uri_schemes example [http]://example.com
            $uri_scheme_whitelist = array('http','https','bitcoin','geo','im','irc','ircs','magnet','mailto',
                                          'mms','nntp','sip','sms','smsto','ssh','tel','urn','webcal','wtai',
                                          'ftp', 'news');
            $dom = new DOMDocument;
            @$dom->loadHTML(html_entity_decode($document, ENT_COMPAT, 'UTF-8'));
            $nodes = $dom->getElementsByTagName('*');//just get all nodes,
            //$dom->getElementsByTagName('img'); would work, too
            while (($r = $dom->getElementsByTagName("script")) && $r->length) {
                $r->item(0)->parentNode->removeChild($r->item(0));
            }

            foreach($nodes as $node)
            {
                foreach($node->attributes as $attributeName => $attribute){
                    if(strtolower($node ->tagName) == 'form'){//remove form posting?
                        $node -> removeAttribute('action');
                    }
                    if(substr(strtolower($attributeName), 0, 10) =='formaction'){ //remove forms submitions 
                        $node->removeAttribute ( $attributeName);
                    }
                    if( substr(strtolower($attributeName), 0, 4) == 'href' || //add action to this list to validate instead of remove
                        substr(strtolower($attributeName), 0, 3) == 'src' ||
                        /*substr(strtolower($attributeName), 0, 10) == 'background' || if background is a url*/
                        substr(strtolower($attributeName), 0, 3) == 'dynsrc' ||
                        substr(strtolower($attributeName), 0, 3) == 'lowsrc' ||
                        substr(strtolower($attributeName), 0, 3) == 'data'){
                        $position = strpos($attribute -> value, ':');
                        $protocol = strtolower(substr($attribute -> value, 0, $position));

                        $allowed = false;
                        foreach($uri_scheme_whitelist as $white_list){
                            if($protocol == $white_list){
                                $allowed = true;
                                $attribute -> value = htmlspecialchars($attribute -> value);
                            }
                        }
                        if($allowed == false){
                            $node->removeAttribute ($attributeName);
                        }
                    }

                    if( substr(strtolower($attributeName), 0, 2) =='on' ){
                       $node->removeAttribute ( $attributeName);
                    } 
                    
                }

            }

            return $dom->saveHTML();
            
        }


    }

}

?>
