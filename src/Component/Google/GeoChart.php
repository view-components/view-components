<?php
namespace Presentation\Framework\Component\Google;

use Nayjest\Tree\NodeTrait;
use Presentation\Framework\Base\ComponentInterface;
use Presentation\Framework\Base\ComponentTrait;
use Presentation\Framework\Component\Html\Script;
use Presentation\Framework\Component\Html\Tag;
use Presentation\Framework\Component\Text;
use Presentation\Framework\Rendering\ViewTrait;
use Presentation\Framework\Resources\ResourceManager;

/**
 * Class GeoChart
 * @draft
 */
class GeoChart implements ComponentInterface
{
    use ViewTrait;
    use NodeTrait;
    use ComponentTrait;

    protected $resources;
    protected $data;
    protected $options;
    protected $additionalJs;

    public function __construct(
        ResourceManager $resources,
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

    protected function defaultChildren() {
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
