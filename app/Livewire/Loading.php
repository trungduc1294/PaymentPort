<?php

namespace App\Livewire;

use Livewire\Component;

class Loading extends Component
{
    public string $eventTarget = '';
    public bool $isLoading = false;

    public function open() {
        $this->isLoading = true;
        dump(2);
    }
    public function close() {
        $this->isLoading = false;
        dump(1);
    }
    public $listeners = [
        'openLoading' => 'open',
        'closeLoading' => 'close',
    ];
    public function render()
    {
        return view('livewire.loading');
    }
}
