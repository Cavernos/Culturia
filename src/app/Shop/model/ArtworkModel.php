<?php

namespace G1c\Culturia\app\Shop\model;

use DateTime;
use G1c\Culturia\framework\Model;

class ArtworkModel extends Model
{
    public $id;
    public $name;
    public $description;
    public $creationDate;
    public $modificationDate;
    public $price;
    public $image;
    public $artistId;

    public function setCreationDate(string $creationDate)
    {
        $this->creationDate = new DateTime($creationDate);
        return $this;
    }
    public function getSlug()
    {
        return str_replace(" ", "-", strtolower($this->name));
    }

    public function setModificationDate(string $modificationDate)
    {
        $this->modificationDate = new DateTime($modificationDate);
    }

    public function getThumb()
    {
        if($this->image){
            ['filename' => $filename, 'extension' => $extension] = pathinfo($this->image);
            return "/upload/artworks/{$filename}_thumb.$extension";
        }
        return null;
    }

    public function getImageUrl()
    {
        ['filename' => $filename, 'extension' => $extension] = pathinfo($this->image);
        return "/upload/artworks/$filename.$extension";
    }

}