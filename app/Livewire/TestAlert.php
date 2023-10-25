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

    public function myAlert() {
        $this->alert('success', 'Success!', [
            'position' => 'top-end',
            'timer' => '1000',
            'toast' => true,
            'timerProgressBar' => true,
            'showConfirmButton' => false,
            'onConfirmed' => '',
        ]);
    }
}
