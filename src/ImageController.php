<?php namespace App\Systems\Glide;

use App\Http\Controllers\Controller;

abstract class ImageController extends Controller
{
    public function serve(GlideServer $server, $filename)
    {
        $image = new GlideImage($filename);
        $params = $this->params(request('type', ''));
        return $server->getImageResponse($image, $params);
    }

    protected function params(string $type): array
    {
        return array_key_exists($type, static::$types) ? static::$types[$type] : [];
    }

    protected static $types = [
        // 'full' => ['w' => '1200', 'fit' => 'max'],
    ];
}
