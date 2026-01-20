<?php

namespace G1c\Culturia\app\Artists;

use G1c\Culturia\framework\Upload;

class ArtistsUpload extends Upload
{
    protected $path = "public/upload/artists";
    protected array $formats = [
      "thumb" => [22, 22],
    ];
}