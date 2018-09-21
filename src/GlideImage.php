<?php namespace App\Systems\Glide;

use Illuminate\Http\UploadedFile;

class GlideImage
{
    public static function newFromUploadedFile(UploadedFile $file): GlideImage
    {
        $hash = md5_file($file->getRealPath());
        $extension = $file->getClientOriginalExtension();
        return new GlideImage($hash . '.' . $extension);
    }

    protected $hash;
    protected $extension;

    public function __construct(string $filename) // md5-hash.extension
    {
        $this->hash = pathinfo($filename, PATHINFO_FILENAME);
        $this->extension = str_replace('jpeg', 'jpg', strtolower(pathinfo($filename, PATHINFO_EXTENSION)));
        if (!in_array($this->extension, ['jpg', 'gif', 'png'], true)) {
            throw new \InvalidArgumentException('Invalid extension: ' . $this->extension);
        }
    }

    public function filename($extension = true): string
    {
        $filename = $this->hash;
        if ($extension) {
            $filename .= '.' . $this->extension;
        }
        return $filename;
    }

    public function path($filename = true): string
    {
        $path = substr($this->hash, 0, 2) . '/' . substr($this->hash, 2, 2);
        if ($filename) {
            $path .= '/' . $this->filename();
        }
        return $path;
    }

    public function url(array $params = []): string
    {
        return route('image.serve', [$this->filename()] + $params);
    }
}
