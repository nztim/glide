<?php namespace NZTim\Glide;

use Illuminate\Routing\Controller;
use Throwable;

abstract class ImageController extends Controller
{
    public function serve(GlideServer $server, $filename)
    {
        try {
            $image = new GlideImage($filename);
            $params = $this->params(request()->all());
            return $server->getImageResponse($image, $params);
        } catch (Throwable $e) {
            return $this->handleError($e);
        }
    }

    // Override as required, or just return $params for all
    protected function params(array $params): array
    {
        $permitted = ['w', 'h', 'fit'];
        return array_intersect_key($params, array_flip($permitted));
    }

    protected function handleError(Throwable $e)
    {
        return abort(404, 'Image not found');
    }
}
