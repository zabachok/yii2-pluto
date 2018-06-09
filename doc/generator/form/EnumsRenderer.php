<?php

namespace zabachok\pluto\doc\generator\form;

class EnumsRenderer
{
    /**
     * @var array
     */
    private $enums;

    /**
     * EnumsRenderer constructor.
     * @param string $enumsSource
     */
    public function __construct(string $enumsSource)
    {
        if (empty($enumsSource)) {
            return;
        }

        $this->parseAll($enumsSource);
    }

    /**
     * @return string
     */
    public function render(): string
    {
        if (empty($this->enums)) {
            return '';
        }

        $result = '### Енумы';
        foreach ($this->enums as $field => $enumClass) {
            $result .= $this->renderOne($field, $enumClass);
        }

        return $result;
    }


    /**
     * @param string $enumsSource
     * @return void
     */
    private function parseAll(string $enumsSource): void
    {
        $pairs = explode(',', $enumsSource);

        foreach ($pairs as $pair) {
            $this->parseOne($pair);
        }
    }

    /**
     * @param string $pair
     * @return void
     */
    private function parseOne(string $pair): void
    {
        $data = explode(':', $pair);
        $this->enums[$data[0]] = $data[1];
    }

    /**
     * @param $field
     * @param $enumClass
     * @return string
     */
    private function renderOne($field, $enumClass): string
    {
        $result = '  ' . PHP_EOL . 'Значения поля `' . $field . '`:  ' . PHP_EOL;

        foreach ($enumClass::listData() as $key => $value) {
            $result .= '* ' . $key . ': ' . $value . '  ' . PHP_EOL;
        }

        return $result . '  ' . PHP_EOL;
    }
}