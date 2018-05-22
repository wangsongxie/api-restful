<?php



return [
    // Gitlab webhooks secret token  . If not, please don't modify it
    'X-Gitlab-Token' => env('X-Gitlab-Token', ''),
    // Github webhooks Secret . If not, please don't modify it
    'X-Hub-Signature' => env('X-Hub-Signature', ''),
    // git commands
    'git_commands' => [
        'git pull'
    ],

    // migration command
    'migration_commands' => [
        'php artisan migrate',
    ],

    // the command should be fired
    'commands' => explode(',',env('GIT-EXTRA-COMMANDS', '')),
];
