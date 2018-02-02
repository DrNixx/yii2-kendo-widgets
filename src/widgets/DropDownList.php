<?php
namespace yii2\kendo\widgets;

use yii\bootstrap\Widget;
use yii2\kendo\data\DataSource;
use yii2\kendo\data\DataSourceSchema;
use yii2\kendo\data\DataSourceTransport;
use yii2\kendo\data\DataSourceTransportRead;

class DropDownList extends Widget
{
    /**
     * Input name
     *
     * @var string
     */
    public $name;

    public $value;

    public $dataUrl;

    public $keyField = 'value';

    public $valField = 'text';

    public $attrs = ['style' => 'width: 100%'];

    public $props = [];


    public function run()
    {
        if (is_array($this->dataUrl)) {
            $ds = $this->dataUrl;
        } else {
            $ds = DataSource::make([
                'transport' => DataSourceTransport::make([
                    'read' => DataSourceTransportRead::make([
                        'url' => $this->dataUrl,
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

        $control = new DropDownList($this->name);
        $control
            ->dataSource($ds)
            ->dataTextField($this->valField)
            ->dataValueField($this->keyField)
            ->value(strval($this->value));
    }
}