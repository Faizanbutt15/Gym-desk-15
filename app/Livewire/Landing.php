<?php

namespace App\Livewire;

use Livewire\Component;

class Landing extends Component
{
    public $page = 'home';
    public $mobileMenuOpen = false;

    protected $queryString = ['page'];

    public function toggleMobileMenu()
    {
        $this->mobileMenuOpen = !$this->mobileMenuOpen;
    }

    public function setPage($page)
    {
        $this->page = $page;
        $this->mobileMenuOpen = false; // Close menu on page change
        $this->dispatch('page-changed');
    }

    public function scrollToSection($section)
    {
        if ($this->page !== 'home') {
            $this->page = 'home';
            $this->dispatch('page-changed');
        }
        
        $this->mobileMenuOpen = false; // Close menu on scroll
        $this->dispatch('scroll-to-section', section: $section);
    }

    public function render()
    {
        return view('livewire.landing');
    }
}
