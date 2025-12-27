<?php

namespace G1c\Culturia\framework;

use DateTime;
use G1c\Culturia\framework\Validator\ValidationError;
use PDO;

class Validator
{
    private const MIME_TYPES = [
      "jpg" => "image/jpeg",
      "png" => "image/png"
    ];

    private $params;
    private $errors = [];

    public function __construct(array $params){

        $this->params = $params;
    }

    /**
     * @param string ...$keys
     * @return $this
     */
    public function required(string ...$keys): self
    {
        foreach ($keys as $key) {
            $value = $this->getValue($key);
            if (is_null($value)) {
                $this->addError($key, 'required');
            }
        }
        return $this;
    }

    /**
     * @param string ...$keys
     * @return $this
     */
    public function notEmpty(string ...$keys): self
    {
        foreach ($keys as $key) {
            $value = $this->getValue($key);
            if(empty($value)) {
                $this->addError($key, 'empty');
            }
        }
        return $this;
    }

    /**
     * @param string $key
     * @param int|null $min
     * @param int|null $max
     * @return $this
     */
    public function length(string $key, ?int $min, ?int $max = null): self
    {
        $value = $this->getValue($key);
        $length = strlen($value);
        if(!is_null($min) && !is_null($max) && ($length < $min || $length > $max)) {
            $this->addError($key, 'betweenLength', [$min, $max]);
            return $this;
        }
        if(!is_null($min) && ($length < $min)){
            $this->addError($key, 'minLength', [$min]);
            return $this;
        }
        if(!is_null($max) && ($length > $max)) {
            $this->addError($key, "maxLength", [$max]);
            return $this;
        }
        return $this;
    }

    /**
     * @param string $key
     * @param string $format
     * @return $this
     */
    public function dateTime(string $key, string $format = "Y-m-d H:i:s"): self
    {
        $value = $this->getValue($key);
        $date = DateTime::createFromFormat($format, $value);
        $error = DateTime::getLastErrors();
        if($error["error_count"] > 0 || $error["warning_count"] || $date === false) {
            $this->addError($key, 'datetime', [$format]);
            return $this;
        }
        return $this;
    }

    /**
     * @param string $key
     * @param string $table
     * @param PDO $pdo
     * @return $this
     */
    public function exists(string $key, string $table, PDO $pdo): self
    {
        $value = $this->getValue($key);
        $statement = $pdo->prepare("SELECT id FROM $table WHERE id = ?");
        $statement->execute([$value]);
        if($statement->fetchColumn() === false) {
            $this->addError($key, 'exists', [$table]);
            return $this;
        }
        return $this;
    }

    public function isValid(): bool
    {
        return empty($this->errors);
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * @param string $key
     * @return $this
     */
    public function uploaded(string $key): self
    {
        $file = $this->getValue($key);
        if($file === null || $file->getError() === UPLOAD_ERR_NO_FILE) {
            $this->addError($key, 'uploaded');
        }
        return $this;
    }

    public function extension(string $key, array $extensions): self
    {
        /** @var UploadedFileInterface $file */
        $file = $this->getValue($key);
        if($file !== null && $file->getError() === UPLOAD_ERR_OK) {
            $type = $file->getClientMediaType();
            $extension = strtolower(pathinfo($file->getClientFilename(), PATHINFO_EXTENSION));
            $expectedType = self::MIME_TYPES[$extension] ?? null;
            if(!in_array($extension, $extensions) || $expectedType !== $type) {
                $this->addError($key, 'filetype', [join(', ', $extensions)]);
            }
        }
        return $this;
    }
    private function addError(string $key, string $rule, array $attributes = []): void
    {
        $this->errors[$key] = new ValidationError($key, $rule, $attributes);
    }

    private function getValue(string $key): mixed
    {
        if(array_key_exists($key, $this->params)) {
            return $this->params[$key];
        }
        return null;
    }

}