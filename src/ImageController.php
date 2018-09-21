<?php namespace NZTim\Glide;

use Illuminate\Routing\Controller;
use Throwable;

abstract class ImageController extends Controller
{
    public function serve(GlideServer $server, $filename)
    {
        $image = new GlideImage($filename);
        $params = $this->params(request('type', ''));
        try {
            return $server->getImageResponse($image, $params);
        } catch (Throwable $e) {
            return $this->handleError($e);
        }
    }

    protected function params(string $type): array
    {
        return array_key_exists($type, static::$types) ? static::$types[$type] : [];
    }

    protected static $types = [
        // 'full' => ['w' => '1200', 'fit' => 'max'],
    ];

    protected function handleError(Throwable $e)
    {
        return abort(404, 'Image not found');
    }
}
