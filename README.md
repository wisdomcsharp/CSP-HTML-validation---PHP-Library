#CSP & HTML validation - PHP Library
###This is a PHP library which helps prevents XSS attacks by validating and encoding various link types, removing event triggers, inline scripts, and with modern CSP header settings, is used to proivde an advanced solution for HTML & CSS validation.

#####The purpose of this project, is to develop a universal library, which could be used to validate and sanitise HTML outputs, to eliminate security risks such as XSS attacks. This script should be used, where the target user is using an outdated browser (for example, OS versions such as android, upto v4.4, or other vulnerable browsers) if you do use this script, it should be in conjuction with CSP headers (which completely removes this attack for various browser versions). The headers that we have used in our servers will be listed below, and should be used in your servers too.

This script will not work in websites that use relative paths for images, files, links, forms, videos, objects... Its recommend to use this script if the website uses only absolute paths. 


### Usage
<?php

`use libs\security\script;`

`require_once 'script.php';`



> `$input = $_POST['html_content'];`

> `$output = script\sanitise($input);`



### Adding CSP headers
#### This code should be editted and included in your `.htaccess` file please visit [Content Security Policy](http://content-security-policy.com/) / [From Google](https://developer.chrome.com/extensions/contentSecurityPolicy) / [From Mozilla](https://developer.mozilla.org/en-US/docs/Web/Security/CSP/Using_Content_Security_Policy) for more information


<ifModule mod_headers.c> 

    Header set Content-Security-Policy " \

    script-src 'self' *.googleapis.com https://maxcdn.bootstrapcdn.com https://code.jquery.com https://*.yahooapis.com *.cloudflare.com www.google-analytics.com; \

    form-action 'self'; \

    frame-ancestors 'self'; \

    object-src 'self';  \

    connect-src 'self'  www.bitstamp.net

    "

    </ifModule>



