<?php

namespace zabachok\pluto\doc\generator\form;

use yii\base\Model;

class GridRenderer
{
    /**
     * @var string
     */
    private $className;

    /**
     * @var Model
     */
    private $class;

    /**
     * @var string[]
     */
    private $attributes;

    /**
     * @var string[]
     */
    private $required = [];

    /**
     * @var array
     */
    private $rules;

    /**
     * GridRenderer constructor.
     * @param string $className
     */
    public function __construct(string $className)
    {
        $this->className = $className;
        $this->class = new $className;
        $this->attributes = $this->class->attributes();
        $this->rules = array_fill_keys($this->attributes, []);
    }

    /**
     * @return string
     */
    public function render(): string
    {
        $this->fillRules();
        $columnSizes = $this->calcColumnSize();

        $result = '| ' . str_pad('Поле', $columnSizes['attribute'], ' ') . '  |  ' . str_pad('Тип', $columnSizes['rule'], ' ') . '   | Обязательно | Описание |' . PHP_EOL;
        $result .= '|-' . str_pad('-', $columnSizes['attribute'], '-') . '-|-' . str_pad('-', $columnSizes['rule'], '-') . '-|-------------|----------|' . PHP_EOL;
        foreach ($this->rules as $attribute => $rule) {
            $result .= '| ';
            $result .= str_pad($attribute, $columnSizes['attribute'], ' ');
            $result .= ' | ';
            $result .= str_pad($rule, $columnSizes['rule'], ' ');
            $result .= ' | ';
            $result .= in_array($attribute, $this->required) ? 'Да ' : 'Нет';
            $result .= ' | - |' . PHP_EOL;
        }

        return $result;
    }

    /**
     * @return string[]
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    /**
     * @return void
     */
    private function fillRules(): void
    {
        $rules = $this->class->rules();

        foreach ($rules as $rule) {
            $this->fillRule($rule);
        }

        foreach ($this->rules as $attribute => $rule) {
            $this->rules[$attribute] = implode(', ', $rule);
        }
    }

    /**
     * @param array $rule
     * @return void
     */
    private function fillRule(array $rule): void
    {
        $attributes = is_array($rule[0]) ? $rule[0] : [$rule[0]];
        $validator = $rule[1];
        $methodName = $validator . 'Filler';
        if (method_exists($this, $methodName)) {
            $this->$methodName($attributes, $rule);
        }
    }

    /**
     * @param array $attributes
     * @param array $rule
     * @return void
     */
    private function integerFiller(array $attributes, array $rule): void
    {
        foreach ($attributes as $attribute) {
            $text = 'integer';
            if (isset($rule['min']) || isset($rule['max'])) {
                $text .= '(';
                $text .= isset($rule['min']) ? $rule['min'] : '';
                $text .= ',';
                $text .= isset($rule['max']) ? $rule['max'] : '';
                $text .= ')';
            }

            $this->rules[$attribute][] = $text;
        }
    }

    /**
     * @param array $attributes
     * @param array $rule
     * @return void
     */
    private function stringFiller(array $attributes, array $rule): void
    {
        foreach ($attributes as $attribute) {
            $text = 'string';
            if (isset($rule['min']) || isset($rule['max'])) {
                $text .= '(';
                $text .= isset($rule['min']) ? $rule['min'] : '';
                $text .= ',';
                $text .= isset($rule['max']) ? $rule['max'] : '';
                $text .= ')';
            }

            $this->rules[$attribute][] = $text;
        }
    }

    /**
     * @param array $attributes
     * @param array $rule
     * @return void
     */
    private function requiredFiller(array $attributes, array $rule): void
    {
        $this->required = array_merge($this->required, $attributes);
        $this->required = array_unique($this->required);
    }

    /**
     * @param array $attributes
     * @param array $rule
     * @return void
     */
    private function inFiller(array $attributes, array $rule): void
    {
        $values = $rule['range'];
        foreach ($attributes as $attribute) {
            $text = 'enum(' . implode(', ', $values) . ')';
            $this->rules[$attribute][] = $text;
        }
    }

    /**
     * @param array $attributes
     * @param array $rule
     * @return void
     */
    private function matchFiller(array $attributes, array $rule): void
    {
        foreach ($attributes as $attribute) {
            $text = 'expression( `' . $rule['pattern'] . '` )';
            $this->rules[$attribute][] = $text;
        }
    }

    /**
     * @param array $attributes
     * @param array $rule
     */
    private function emailFiller(array $attributes, array $rule): void
    {
        foreach ($attributes as $attribute) {
            $text = 'email';
            $this->rules[$attribute][] = $text;
        }
    }

    /**
     * @return array
     */
    private function calcColumnSize(): array
    {
        $attributeLength = 0;
        $ruleLength = 0;
        foreach ($this->rules as $attribute => $rule) {
            $length = strlen($attribute);
            $attributeLength = $length > $attributeLength ? $length : $attributeLength;

            $length = strlen($rule);
            $ruleLength = $length > $ruleLength ? $length : $ruleLength;
        }

        return [
            'attribute' => $attributeLength,
            'rule' => $ruleLength,
        ];
    }
}