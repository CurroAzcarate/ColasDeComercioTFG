<?php

$container->loadFromExtension('swiftmailer', [
    'delivery_addresses' => ["dev@example.com"],
    'delivery_whitelist' => [
        // all email addresses matching these regexes will be delivered
        // like normal, as well as being sent to dev@example.com
        '/@specialdomain\.com$/',
        '/^admin@mydomain\.com$/',
    ],
]);