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
        //removes JS script, and events from HTML/CSS documents
        public static function sanitise($document){
            
            $dom = new DOMDocument;

            @$dom->loadHTML($document);
            $nodes = $dom->getElementsByTagName('*');//just get all nodes,
            //$dom->getElementsByTagName('img'); would work, too
            while (($r = $dom->getElementsByTagName("script")) && $r->length) {
                $r->item(0)->parentNode->removeChild($r->item(0));
            }
            foreach($nodes as $node)
            {
                if ($node->hasAttribute('onload'))
                {
                    $node->removeAttribute('onload');
                }
                if ($node->hasAttribute('onclick'))
                {
                    $node->removeAttribute('onclick');
                }
            }
            return $dom->saveHTML();
            
        }


    }

}

?>
