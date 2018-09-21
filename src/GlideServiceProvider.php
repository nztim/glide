<?php namespace App\Systems\Glide;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;
use League\Glide\Responses\LaravelResponseFactory;
use League\Glide\Server;
use League\Glide\ServerFactory;

class GlideServiceProvider extends ServiceProvider
{
    public function register()
    {
        app()->bind(Server::class, function () {
            return ServerFactory::create([
                'response'       => new LaravelResponseFactory(app('request')),
                'source'         => Storage::disk('glide_source')->getDriver(),
                'cache'          => Storage::disk('glide_cache')->getDriver(),
                'max_image_size' => 3000 * 2000,
            ]);
        });
    }
}
