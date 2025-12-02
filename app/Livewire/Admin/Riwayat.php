<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.dashboard')] 
class Riwayat extends Component
{
    public function render()
    {
        return view('livewire.admin.riwayat');
    }
}
