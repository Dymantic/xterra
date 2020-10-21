<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Table extends Component
{
    public $headings;
    public $rows;
    public $columns;

    public function __construct($headings = [], $columns = [], $rows = [])
    {
        $this->headings = $headings;
        $this->columns = $columns;
        $this->rows = $rows;
    }


    public function render()
    {
        return view('components.table');
    }

    public function hasHeadings(): bool
    {
        return !!count($this->headings);
    }

    public function hasColumns(): bool
    {
        return !!count($this->columns);
    }
}
