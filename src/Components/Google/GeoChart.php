<?php
namespace Presentation\Framework\Components\Google;

use Presentation\Framework\BaseComponents\ContainerInterface;
use Presentation\Framework\BaseComponents\ContainerTrait;
use Presentation\Framework\Components\Html\Script;
use Presentation\Framework\Components\Html\Tag;
use Presentation\Framework\Components\Text;
use Presentation\Framework\Resources\Resources;


class GeoChart implements ContainerInterface
{
    use ContainerTrait;
    protected $resources;
    protected $data;
    protected $options;
    protected $additionalJs;

    public function __construct(
        Resources $resources,
        $data,
        $options = null
    )
    {
        $this->resources = $resources;
        $this->data = $data;
        $this->options = $options;
    }

    /**
     * @param $additionalJs
     * @return $this
     */
    public function setAdditionalJs($additionalJs)
    {
        $this->additionalJs = $additionalJs;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAdditionalJs()
    {
        return $this->additionalJs;
    }

    protected function makeContainerId()
    {
        return 'gc-' . uniqid();
    }

    public function render()
    {
        return $this->renderComponents();
    }

    protected function defaultComponents() {
        $id = $this->makeContainerId();
        $rows = json_encode($this->data);
        $options = $this->options ? json_encode($this->options) : '{}';
        return [
            $this->resources->js('https://www.google.com/jsapi'),
            new Tag(
                'div',
                [
                    'data-role' => 'geo-chart-container',
                    'id' => $id
                ]
            ),
            new Script([], [new Text("
                google.load('visualization', '1', {packages:['geochart']});
                google.setOnLoadCallback(function(){
                    var data = $rows;
                    var dataTable = google.visualization.arrayToDataTable(data);
                    var options = {};
                    var chart = new google.visualization.GeoChart(
                        document.getElementById('$id')
                    );
                    {$this->additionalJs}
                    chart.draw(dataTable, $options);
                });

            ")])
        ];
    }
}