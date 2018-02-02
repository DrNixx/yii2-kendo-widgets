<?php
namespace yii2\kendo\widgets;

use yii\base\InvalidConfigException;
use yii2\kendo\ui\NumericTextBox as KendoNumericTextBox;

class NumericTextBox extends InputWidget
{
    public $format = null;

    public $min = null;

    public $max = null;

    public $step = null;

    public $decimals = null;

    public $placeholder = null;

    /**
     * @return string
     *
     * @throws \yii\base\InvalidConfigException
     */
    public function run()
    {
        parent::run();

        return $this->renderNumericTextBox();
    }

    /**
     * @return KendoNumericTextBox
     *
     * @throws InvalidConfigException
     */
    private function renderNumericTextBox()
    {
        $this->validateConfig();

        $control = new KendoNumericTextBox($this->name);
        $control->value($this->value);

        if (!empty($this->format)) {
            $control->format($this->format);
        }

        if (!empty($this->min)) {
            $control->min($this->min);
        }

        if (!empty($this->max)) {
            $control->max($this->max);
        }

        if (!empty($this->step)) {
            $control->step($this->step);
        }

        if (!empty($this->decimals)) {
            $control->decimals($this->decimals);
        }

        if (!empty($this->placeholder)) {
            $control->placeholder($this->placeholder);
        }

        foreach ($this->options as $key => $val) {
            $control->attr($key, $val);
        }

        if (!empty($this->props) && is_array($this->props)) {
            foreach ($this->props as $key => $val) {
                $control->$key($val);
            }
        }

        $this->getView()->registerJs($control->script(false));

        return $control->html();
    }

    /**
     * @throws InvalidConfigException
     */
    protected function validateConfig()
    {
        parent::validateConfig();
    }
}