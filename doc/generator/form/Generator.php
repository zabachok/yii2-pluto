<?php

namespace zabachok\pluto\doc\generator\form;

use Yii;
use yii\base\Model;
use yii\gii\CodeFile;
use yii\gii\Generator as GiiGenerator;

class Generator extends GiiGenerator
{
    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $class;

    /**
     * @var string
     */
    public $title = 'ThisIsTitle';

    /**
     * @var string
     */
    public $method = 'GET';

    /**
     * @var string
     */
    public $url = '';

    /**
     * @var GridRenderer
     */
    public $gridRenderer;

    /**
     * @var string
     */
    public $enums = '';

    /**
     * @var EnumsRenderer
     */
    public $enumsRenderer;

    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return 'Documentation by Model';
    }

    /**
     * @inheritdoc
     */
    public function getDescription(): string
    {
        return 'Генерирует документацию по классу формы';
    }

    /**
     * @inheritdoc
     */
    public function generate(): array
    {
        $this->gridRenderer = Yii::$container->get(GridRenderer::class, [$this->class]);
        $this->enumsRenderer = Yii::$container->get(EnumsRenderer::class, [$this->enums]);

        $files = [];
        $files[] = new CodeFile(
            Yii::getAlias('@app/doc/source/' . $this->getFileName() . '.md'),
            $this->render('document.php')
        );

        return $files;
    }

    /**
     * @inheritdoc
     */
    public function requiredTemplates(): array
    {
        return ['document.php'];
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['class',], 'required'],
            [['class'], 'validateClass', 'params' => ['extends' => Model::className()]],
            [
                [
                    'name',
                    'class',
                    'title',
                    'method',
                    'url',
                    'enums'
                ],
                'string'
            ]
        ];
    }

    /**
     * @return string
     */
    public function getFileName(): string
    {
        if (!empty($this->name)) {
            return $this->name;
        }

        $elements = explode('\\', $this->class);
        $elements = array_reverse($elements);
        $fileName = str_replace('Form', '', $elements[0]);

        return $elements[2] . '-' . strtolower($fileName);
    }

    /**
     * @return string
     */
    public function renderRulesGrid(): string
    {
        return Yii::$container->get(GridRenderer::class, [$this->class])->render();
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Название файла',
            'class' => 'Нэймспэйс класса',
            'title' => 'Заголовок',
            'method' => 'Метод',
            'url' => 'Url',
            'enums' => 'Классы енумов',
        ];
    }
}