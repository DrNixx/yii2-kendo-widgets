<?php
namespace yii2\kendo\widgets;

use yii\base\InvalidConfigException;
use yii\bootstrap\ActiveForm;
use yii2\kendo\data\DataSource;
use yii2\kendo\data\DataSourceSchema;
use yii2\kendo\data\DataSourceTransport;
use yii2\kendo\data\DataSourceTransportRead;
use yii2\kendo\ui\DropDownList as KendoDropDownList;

class DropDownList extends InputWidget
{
    public $dataSource;

    public $dataValueField = 'value';

    public $dataTextField = 'text';

    public $attrs = ['style' => 'width: 100%'];

    public $props = [];


    /**
     * @return string
     * @throws InvalidConfigException
     */
    public function run()
    {
        parent::run();

        return $this->renderDropDownList();
    }

    /**
     * @throws InvalidConfigException
     */
    private function renderDropDownList()
    {
        $this->validateConfig();
        if (is_array($this->dataSource)) {
            $ds = $this->dataSource;
        } else {
            $ds = DataSource::make([
                'transport' => DataSourceTransport::make([
                    'read' => DataSourceTransportRead::make([
                        'url' => $this->dataSource,
                        'dataType' => 'jsonp',
                        'type' => 'GET',
                    ]),
                    'parameterMap' => 'function(data) { return { models: kendo.stringify(data) }; }'
                ]),
                'schema' => DataSourceSchema::make([
                    'data' => 'data',
                    'errors' => 'errors',
                    'total' => 'total',
                ])
            ]);
        }

        $control = new KendoDropDownList($this->name);
        $control
            ->dataSource($ds)
            ->enable(!$this->disabled)
            ->dataTextField($this->dataTextField)
            ->dataValueField($this->dataValueField)
            ->value(strval($this->value));

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
