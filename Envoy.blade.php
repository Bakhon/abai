@servers(['localhost' => '127.0.0.1'])

@setup
    $releases_dir = '/var/www/dashboard/releases';
    $app_dir = '/var/www/dashboard';
    $release = date('YmdHis');
    $new_release_dir = $releases_dir .'/'. $release;
@endsetup

@story('deploy')
    copy_repository
    run_composer
    run_scripts
    build_static
    update_symlinks
    update_permissions
    restart_services
    clean_old_releases
@endstory

@task('copy_repository')
    echo "Starting deployment ({{ $release }})"
    cp -r ./ {{ $new_release_dir }}
@endtask

@task('run_composer')
    echo "Run composer"
    cd {{ $new_release_dir }}
    composer install --prefer-dist -q -o
@endtask

@task('run_scripts')
    echo 'Linking .env file'
    ln -nfs {{ $app_dir }}/.env {{ $new_release_dir }}/.env

    echo "Run migrations"
    cd {{ $new_release_dir }}
    php artisan migrate --force --no-interaction

    php artisan storage:link
    php artisan VueTranslation:generate
@endtask

@task('restart_services')
    echo "Restart supervisor"
    sudo supervisorctl restart all
    echo "Restart php"
    sudo service php7.3-fpm restart
    echo "Restart nginx"
    sudo service nginx restart
@endtask

@task('build_static')
    echo "Build static"
    cd {{ $new_release_dir }}
    npm install --prefer-offline --no-audit
    export NODE_OPTIONS=--max_old_space_size=8192
    npm run --silent prod
@endtask

@task('update_symlinks')
    echo "Linking storage directory"
    rm -rf {{ $new_release_dir }}/storage
    ln -nfs {{ $app_dir }}/storage {{ $new_release_dir }}/storage

    echo 'Linking current release'
    ln -nfs {{ $new_release_dir }} {{ $app_dir }}/current
@endtask

@task('update_permissions')
    echo "Updating permissions"
    sudo chown -R dash:dash {{ $new_release_dir }}
    sudo chgrp -R www-data {{ $new_release_dir }}/storage {{ $new_release_dir }}/bootstrap/cache
    sudo chmod -R 777 {{ $new_release_dir }}/storage {{ $new_release_dir }}/bootstrap/cache
@endtask

@task('clean_old_releases')
    purging=$(ls -dt {{ $releases_dir }}/* | tail -n +3);

    if [ "$purging" != "" ]; then
        echo Purging old releases: $purging;
        sudo rm -rf $purging;
    else
        echo "No releases found for purging at this time";
    fi
@endtask
