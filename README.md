# remove-script-from-HTMLDocument
This is a PHP library which helps prevents CSFR attacks by removing event triggers, and script tags from HTMLDocuments


### Usage
<?php

`use libs\security\script;`

`require_one 'script.php'`



> `$input = $_POST['html_content'];`

> `$output = script\sanitise($input);`

?>
