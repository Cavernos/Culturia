<?php

namespace G1c\Culturia\framework\Renderer\Extensions;

use DateTime;
use G1c\Culturia\framework\Renderer\ExtensionFunction;
use G1c\Culturia\framework\Renderer\RendererExtensionInterface;

class FormExtension implements RendererExtensionInterface
{

    public function getFunctions(): ExtensionFunction
    {
        return new ExtensionFunction("field", [$this, 'field']);
    }

    /**
     * @param string $key
     * @param $value
     * @param string|null $label
     * @param array $options
     * @return string
     */
    public function field(array $context, string $key, $value, ?string $label = null, array $options = []): string
    {
        $type = $options["type"] ?? 'text';
        $context = ["errors" => $context];
        $error = $this->getHTMLError($context, $key);
        $class = 'form-group';
        $value = $this->convertValue($value);
        $attributes = [
            'class' => $options["class"] ?? '',
            "name" => $key,
            "id" => $key . uniqid(),
        ];
        if($error) {
           $class .= ' has-danger';
        }
        if( array_key_exists('options', $options)) {
            $input = $this->select($value, $options["options"], $attributes);
        } else {
            $input = match ($type) {
                'textarea' => $this->textarea($value, $attributes),
                'file' => $this->file($attributes),
                'switch', 'checkbox' => $this->checkbox($value, $attributes),
                'password' => $this->password($value, $attributes),
                'email' => $this->email($value, $attributes),
                default => $this->input($value, $attributes),
            };

        }
        if($type === "switch") {
            return "<div class='{$class}'>{$input}<label class='form-switch' for='{$attributes["id"]}'>{$label}</label>{$error}</div>";
        }
        return "<div class='{$class}'><label for='{$key}'>{$label}</label>{$input}{$error}</div>";
    }

    /**
     * @param array $context
     * @param string $key
     * @return string
     */
    public function getHTMLError(array $context, string $key): string
    {
        $error = $context['errors'][$key] ?? false;
        if($error) {
            return "<small>{$error}</small>";
        }
        return '';
    }

    public function input(?string $value, array $attributes): string
    {
        return "<input type='text' {$this->getHtmlFromArray($attributes)} value='{$value}'/>";
    }

    public function password(?string $value, array $attributes): string
    {
        return "<input type='password' {$this->getHtmlFromArray($attributes)} value='{$value}'/>";
    }

    public function email(?string $value, array $attributes): string
    {
        return "<input type='email' {$this->getHtmlFromArray($attributes)} value='{$value}'/>";
    }

    public function file(array $attributes): string
    {
        return "<input type='file' {$this->getHtmlFromArray($attributes)}/>";
    }

    public function checkbox(?string $value, array $attributes): string
    {
        $html = "<input type='hidden' name='{$attributes["name"]}' value='0'/>";
        if($value) {
            $attributes["checked"] = true;
        }
        return $html . "<input type='checkbox' {$this->getHtmlFromArray($attributes)} value='1'/>";
    }

    public function textarea(?string $value, array $attributes): string
    {
        return "<textarea {$this->getHtmlFromArray($attributes)}>{$value}</textarea>";
    }

    public function select(?string $value, array $options, array $attributes): string
    {
        $htmlOptions = array_reduce(array_keys($options), function (string $html, string $key) use($options, $value) {
            $params = ['value' => $key, 'selected' => $key === $value];
            return $html . "<option {$this->getHtmlFromArray($params)}>$options[$key]</option>";
        }, "");
        return "<select {$this->getHtmlFromArray($attributes)}>$htmlOptions</select>";
    }
    public function getHtmlFromArray(array $attributes): string
    {
        $htmlParts = [];
        foreach ($attributes as $key => $value) {
            if($value === true) {
                $htmlParts[] = (string) $key;
            } elseif ($value !== false) {
                $htmlParts[] = "$key=\"$value\"";
            }
        }
        return implode(" ", $htmlParts);
    }

    public function convertValue($value): string
    {
        if($value instanceof DateTime) {
            return $value->format('Y-m-d H:i:s');
        }
        return (string)$value;
    }


}