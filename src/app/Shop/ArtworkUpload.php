<?php

namespace G1c\Culturia\app\Shop;

use G1c\Culturia\framework\Upload;

class ArtworkUpload extends Upload
{
    protected $path = "public/upload/artworks";
    protected array $formats = [
        "thumb" => [206, 158]
    ];
}