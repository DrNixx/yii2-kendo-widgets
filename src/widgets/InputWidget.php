<?php
namespace yii2\kendo\widgets;

use yii\base\InvalidConfigException;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\InputWidget as YiiInputWidget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii2\kendo\assets\KendoAsset;

class InputWidget extends YiiInputWidget
{

    /**
     * @var bool use array-style input name
     */
    public $useModelPrefix = false;

    /**
     * @var boolean whether input is to be disabled
     */
    public $disabled = false;

    /**
     * @var boolean whether input is to be readonly
     */
    public $readonly = false;

    public $defaultOptions = ['style' => 'width: 100%'];

    /**
     * @return string|void
     * @throws \yii\base\InvalidConfigException
     */
    public function run()
    {
        parent::run();
        $this->registerAsset();
    }

    public function init()
    {
        parent::init();

        if (!$this->useModelPrefix) {
            $this->options = ArrayHelper::merge($this->options, ['name' => $this->attribute]);
        }

        $this->initInputWidget();
    }

    /**
     * Initializes the input widget.
     */
    protected function initInputWidget()
    {
        if ($this->hasModel()) {
            $this->name = !isset($this->options['name']) ? Html::getInputName($this->model, $this->attribute) : $this->options['name'];
            $this->value = !isset($this->options['value'])? Html::getAttributeValue($this->model, $this->attribute) : $this->options['value'];
        } else {
            $this->name = isset($this->options['name']) ? $this->options['name'] : null;
            $this->value = isset($this->options['value']) ? $this->options['value'] : null;
        }

        $this->initDisability($this->options);

        $this->options = ArrayHelper::merge($this->defaultOptions, $this->options);
        ArrayHelper::remove($this->options, 'name');
        ArrayHelper::remove($this->options, 'value');
        ArrayHelper::remove($this->options, 'disabled');
        ArrayHelper::remove($this->options, 'readonly');
    }

    /**
     * @throws InvalidConfigException
     */
    protected function validateConfig()
    {
        if (!isset($this->form)) {
            return;
        }

        if (!$this->form instanceof ActiveForm) {
            throw new InvalidConfigException("The 'form' property must be of type \\yii\\bootstrap\\ActiveForm");
        }

        if (!$this->hasModel()) {
            throw new InvalidConfigException("You must set the 'model' and 'attribute' properties when the 'form' property is set.");
        }
    }

    /**
     * Validates and sets disabled or readonly inputs.
     *
     * @param array $options the HTML attributes for the input
     */
    protected function initDisability(&$options)
    {
        if ($this->disabled && !isset($options['disabled'])) {
            $options['disabled'] = true;
        }
        if ($this->readonly && !isset($options['readonly'])) {
            $options['readonly'] = true;
        }
    }

    /**
     * @throws \yii\base\InvalidConfigException
     */
    protected function registerAsset()
    {
        $this->getView()->registerAssetBundle(KendoAsset::className());
    }
}