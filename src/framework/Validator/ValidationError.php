<?php

namespace G1c\Culturia\framework\Validator;

class ValidationError
{
    private $key;
    private $rule;

    private $attributes;

    private $messages = [
        'required' => "Le champ %s est requis",
        'empty' => "Le champ %s ne peut être vide",
        'minLength' => "Le champ %s doit contenir plus de %d caractères",
        'maxLength' => "Le champ %s doit contenir moins %d caractères",
        'betweenLength' => "Le champ %s doit contenir entre %d et %d caractères",
        'datetime' => "Le champ %s doit être une date valide (%s)",
        'notExists' => "Le champ %s n'existe pas dans la table %s",
        'exists' => "Votre %s existe déjà",
        'filetype' => "Le champ %s n'est pas au bon format (formats valides: %s)",
        'uploaded' => "Vous devez uploader un fichier",
        'same' => "Les deux champs %s et %s, ne sont pas identiques"
    ];

    public function __construct($key, $rule, $attributes) {

        $this->key = $key;
        $this->rule = $rule;
        $this->attributes = $attributes;
    }

    public function __toString(): string
    {
        $params = array_merge([$this->messages[$this->rule], $this->key], $this->attributes);
        return (string)call_user_func_array('sprintf', $params);
    }

}