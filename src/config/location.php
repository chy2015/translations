<?php

return [
        'name' => 'Localization Manager',
        /**
         * Views
         */
        'layout' => 'langs::layouts.app',
        'content_section' => 'content',
        'scripts_section' => 'scripts',
         'languages' => ['ca_ES','pt_BR','pt_PT','en_GB'],
        'message_success_variable' => 'flash_success',
        /**
         * Routes
         */
        'prefix' => 'translations',
        'middlewares' => ['web'],
];
