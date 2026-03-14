<?php

namespace App\Livewire;

use Livewire\Component;

class Landing extends Component
{
    public $page = 'home';

    protected $queryString = ['page'];

    public function setPage($page)
    {
        $this->page = $page;
        $this->dispatch('page-changed');
    }

    public function render()
    {
        return view('livewire.landing');
    }
}
