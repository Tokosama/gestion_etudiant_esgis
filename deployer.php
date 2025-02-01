<?php

namespace Deployer;

require 'recipe/laravel.php';
require 'contrib/php-fpm.php';
require 'contrib/npm.php';
require 'contrib/telegram.php';
require 'recipe/deploy/shared.php';

set('repository', 'https://github.com/Tokosama/gestion_etudiant_esgis.git');

// Hosts

host('demo-al.zecreator.com')
    ->set('remote_user', 'deployer')
    ->set('deploy_path', '~/gestion_etudiant_esgis');

task('provision:npm', function () {
    // Check if npm is not installed
    if (test('[ -z "$(command -v npm)" ]')) {
        writeln('npm is not installed. Installing Node.js and npm...');
        run('curl -fsSL https://deb.nodesource.com/setup_18.x | sudo -E bash -');
        run('sudo apt-get install -y nodejs');
        run('sudo npm install -g npm@latest');
    } else {
        writeln('npm is already installed. Skipping installation.');
    }
})->desc('Provision Node.js and npm if not installed');

task('database:setup', function () {
    cd('{{release_path}}');
    run('if [ ! -f database/database.sqlite ]; then touch database/database.sqlite; fi');
    run('chmod 666 database/database.sqlite');
})->desc('Create database.sqlite and set permissions');

// Build assets using npm
task('npm:run:build', function () {
    cd('{{release_path}}');
    run('npm run build');
})->desc('Build assets using npm');

// Main deployment task
task('deploy', [
    'deploy:prepare',
    'deploy:vendors',
    'deploy:shared',
    'database:setup',
    'artisan:key:generate',
    'artisan:storage:link',
    // 'artisan:view:cache',
    // 'artisan:config:cache',
    'artisan:migrate',
    'provision:npm', // Ensure Node.js and npm are installed
    'npm:install',   // Install npm dependencies
    'npm:run:build', // Build assets
    'deploy:publish',
]);

// If deploy fails automatically unlock
after('deploy:failed', 'deploy:unlock');
