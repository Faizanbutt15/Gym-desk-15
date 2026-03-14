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

    public function scrollToSection($section)
    {
        if ($this->page !== 'home') {
            $this->page = 'home';
            $this->dispatch('page-changed');
        }
        
        $this->dispatch('scroll-to-section', section: $section);
    }

    public function render()
    {
        return view('livewire.landing');
    }
}
