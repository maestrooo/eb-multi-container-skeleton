<?php

/**
 * While very nice, the default AWS EB CLI lacks one important feature: the ability to deploy the same code to
 * multiple environments. Of course, you can do that through multiple call to `eb deploy env1` / `eb deploy env2`, but
 * this is error prone.
 *
 * This can happen when you share the same code for a webserver and worker tier. This code is pretty simple and just
 * allows to bound one branch to multiple named environments.
 */

$environments = [
    'master' => [
        'webserver-production', // The production webserver environment
        'worker-production', // The production worker environment
    ],

    'develop' => [
        'webserver-development', // The development webserver environment
        'worker-development', // The development worker environment
    ]
];

$gitHash = exec('git log -1 --format="%H"');
$branch  = exec('git rev-parse --abbrev-ref HEAD');

if (!isset($environments[$branch])) {
    echo 'No environments are bound to the branch ' . $branch . PHP_EOL;
    die();
}

foreach ($environments[$branch] as $environment) {
    echo "\nStarting deployment for environment $environment...\n";
    passthru("eb deploy $environment");
    echo "\nDeployment for environment $environment has completed\n";
}