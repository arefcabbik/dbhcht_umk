<?php

namespace App\View\Components\Button;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class warning extends Component
{
    /**
     * Create a new component instance.
     */
    public string $label;
    public $url;
    public function __construct($label = "Default Label", $url = "#")
    {
        $this->label = $label;
        $this->url = $url;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.button.warning');
    }
}
