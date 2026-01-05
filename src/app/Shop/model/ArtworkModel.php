<?php

namespace G1c\Culturia\app\Shop\model;

use DateTime;

class ArtworkModel
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
        $date = DateTime::createFromFormat("Y-m-d", $creationDate);
        $this->creationDate = $date;
    }

    public function setModificationDate(string $modificationDate)
    {
        $date = DateTime::createFromFormat("Y-m-d", $modificationDate);
        $this->modificationDate = $date;
    }

}