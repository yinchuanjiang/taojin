@servers(['web' => 'root@157.230.142.70'])

@task('deploy', ['on' => ['web'], 'parallel' => true])
cd /var/www/taojin
{{--git pull origin {{ $branch }}--}}
git pull origin master
composer install --no-dev
php artisan migrate --force
chown -R www-data:www-data /var/www/taojin/
@endtask