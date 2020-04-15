<?php

namespace App\Admin\Metrics\Examples;

use Dcat\Admin\Widgets\Metrics\SingleRound;

class GoalOverview extends SingleRound
{
    public function init()
    {
        parent::init();

        $this->title('Goal Overview');
        $this->subTitle('Last 7 days');
        $this->contentWidth(0, 12);
    }

    public function fill()
    {
        $this->withChart(79);
        $this->withFooter('786,617', '13,561');
    }

    public function render()
    {
        $this->fill();

        return parent::render();
    }

    public function withChart($percent)
    {
        return $this->chart([
            'series' => [$percent],
        ]);
    }

    public function withFooter($completed, $inProgress)
    {
        return $this->footer(
            <<<HTML
<div class="row text-center mx-0" style="width: 100%">
  <div class="col-6 border-top border-right d-flex align-items-between flex-column py-1">
      <p class="mb-50">Completed</p>
      <p class="font-lg-1 text-bold-700 mb-50">{$completed}</p>
  </div>
  <div class="col-6 border-top d-flex align-items-between flex-column py-1">
      <p class="mb-50">In Progress</p>
      <p class="font-lg-1 text-bold-700 mb-50">{$inProgress}</p>
  </div>
</div>
HTML
        );
    }
}
