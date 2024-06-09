<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use League\Flysystem\Filesystem;
use Illuminate\Support\Facades\Storage;
use Masbug\Flysystem\GoogleDriveAdapter;
use Google_Client;
use Google_Service_Drive;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);
    }


}
class GoogleDriveServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Storage::extend('google', function($app, $config) {
            $client = new Google_Client();
            
            if (isset($config['credentials'])) {
                $client->setAuthConfig($config['credentials']);
            } else {
                $client->setClientId($config['clientId']);
                $client->setClientSecret($config['clientSecret']);
                $client->refreshToken($config['refreshToken']);
            }

            $client->addScope(Google_Service_Drive::DRIVE);

            $adapter = new GoogleDriveAdapter($client, $config['folderId']);

            return new Filesystem($adapter);
        });
    }

    public function register()
    {
        //
    }
}

