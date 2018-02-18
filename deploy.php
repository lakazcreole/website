<?php
namespace Deployer;

require 'recipe/laravel.php';

// Project name
set('application', 'lakazcreole');

// Project repository
set('repository', 'https://github.com/lakazcreole/website.git');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', true);

// Shared files/dirs between deploys
add('shared_files', ['database/database.sqlite']);
add('shared_dirs', []);

// Writable dirs by web server
add('writable_dirs', []);

// Hosts

host('lakazcreole.fr')
    ->user('strift')
    ->port(22)
    ->identityFile('~/.ssh/id_rsa')
    ->forwardAgent(true)
    ->multiplexing(true)
    ->addSshOption('UserKnownHostsFile', '/dev/null')
    ->addSshOption('StrictHostKeyChecking', 'no')
    ->stage('production')
    ->set('deploy_path', '/home/strift/lakazcreole');

// Tasks

desc('Install npm packages');
task('npm:install', function () {
    if (has('previous_release')) {
        if (test('[ -d {{previous_release}}/node_modules ]')) {
            run('cp -R {{previous_release}}/node_modules {{release_path}}');
        }
    }
    run('cd {{release_path}} && {{bin/npm}} install');
});

desc('Optimize composer autoloader');
task('composer:optimize-autoloader', function () {
    run('cd {{release_path}} && {{bin/composer}} install --optimize-autoloader');
});

desc('Restart PHP-FPM service');
task('php-fpm:restart', function () {
    // The user must have rights for restart service
    // /etc/sudoers: username ALL=NOPASSWD:/bin/systemctl restart php7.2-fpm.service
    run('sudo systemctl restart php7.2-fpm.service');
});

// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');

// Optimize composer autoloader
after('artisan:optimize', 'composer:optimize-autoloader');

// Migrate database before symlink new release.
before('deploy:symlink', 'artisan:migrate');

// Restart php-fpm after deploy
after('deploy:symlink', 'php-fpm:restart');
