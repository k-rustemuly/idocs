<?php

namespace App\Providers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use League\Flysystem\AwsS3V3\AwsS3V3Adapter;
use League\Flysystem\Filesystem;
use Aws\S3\S3Client;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Http::macro('idocs', function ($version = null) {
            $config = Config::get("integration.idocs");
            $version = $version??$config["version"];
            return Http::withToken($config["token"])->baseUrl($config["base_url"]."/".$version);
        });

        File::macro('streamUpload', function($path, $fileName, $file) {
            $resource = fopen($file, 'r+');
            // $resource = file_get_contents($file);
            $config = Config::get('filesystems.disks.s3');
            $client = new S3Client([
                'credentials' => [
                    'key'    => $config['key'],
                    'secret' => $config['secret'],
                ],
                'endpoint' => $config['url'],
                'region' => $config['region'],
                'version' => 'latest',
            ]);

            $adapter = new AwsS3V3Adapter($client, $config['bucket'], $path);
            $filesystem = new Filesystem($adapter);
            $filesystem->writeStream($fileName, $resource);
            return $adapter;
        });
    }
}
