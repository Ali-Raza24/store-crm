<?php

namespace App\View\Components;

use Illuminate\View\Component;

class CounterBox extends Component
{
    public $border_color;

    public $title;

    public $total;

    public $icon;

    public $text_color;

    public $column;

    public $class;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($column = '3', $borderColor = '', $title = '', $icon = '', $total = 0, $textColor = '', $class = '')
    {
        $this->border_color = $borderColor;
        $this->title = $title;
        $this->total = $total;
        $this->icon = $icon;
        $this->text_color = $textColor;
        $this->column = $column;
        $this->class = $class;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.counter-box');
    }
}
