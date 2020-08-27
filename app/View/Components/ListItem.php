<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\Course;

class ListItem extends Component
{
    public $courses;
    public $height;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($courses, $height)
    {
        $this->courses = $courses;
        $this->height = $height;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.list-item');
    }
}
