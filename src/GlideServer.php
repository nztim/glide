<?php namespace App\Systems\Glide;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use League\Glide\Server;

class GlideServer
{
    protected $server;

    public function __construct(Server $server)
    {
        $this->server = $server;
    }

    public function storeImage(UploadedFile $file, GlideImage $image)
    {
        if (!Storage::disk('glide_source')->exists($image->path(true))) {
            Storage::disk('glide_source')->putFileAs($image->path(false), $file, $image->filename());
        }
    }

    public function makeImage(GlideImage $image, array $params)
    {
        $this->server->makeImage($image->path(), $params);
    }

    public function getImageResponse(GlideImage $image, array $params)
    {
        return $this->server->getImageResponse($image->path(), $params);
    }
}
