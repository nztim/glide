# Glide Helper

* Files are stored as md5hash.extension, using 2 folder levels. E.g. 12/34/123456.jpg
* Extensions are lowercase and `jpeg` is changed to `jpg`

### Installation:

* `composer require nztim/glide`
* Add `GlideServiceProvider::class` to `app.php`
* Add filesystem configuration disk entries for `glide_source` and `glide_cache`, for example:

```
'glide_source' => [
    'driver' => 's3',
    'key'    => env('S3_ACCESS'),
    'secret' => env('S3_SECRET'),
    'region' => env('S3_REGION', 'ap-southeast-2'),
    'bucket' => env('S3_BUCKET'),
],

'glide_cache' => [
    'driver' => 'local',
    'root'   => storage_path('app/cache'),
],
```

* Route named `image.serve`, extend supplied abstract controller `ImageController`
* Update `protected static $types` in your controller for the image transformations you wish to allow
    * E.g. `'thumb' => ['w' => '100', 'h' => '100', 'fit' => 'crop'],`
* Then add the images to your views:

```
<img src="{{ route('image.serve', ['type' => 'thumb']) }}">
```
* Override `ImageController@handleError` to deal with errors as you see fit.