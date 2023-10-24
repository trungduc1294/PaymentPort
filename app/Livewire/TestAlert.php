<?php

namespace App\Livewire;

use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class TestAlert extends Component
{
    use LivewireAlert;
    public function render()
    {
        return view('livewire.test-alert');
    }

    public $haha = 'haha';
    public function showAlert()
    {
        dd('test');
        $this->alert('success', 'Basic Alert');

    }
}
