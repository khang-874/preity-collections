<?php

namespace App\Livewire;

use Livewire\Component;

class Slideshow extends Component
{
    public int $perShow = 1;
    public int $offset = 0;
    public array $items = [];
    public array $currentItems = [];

    public function mount(int $perShow = 1, array $items){
        $this -> items = $items;
        if($perShow >= count($items))
            $this -> perShow = count($items);
        else
            $this -> perShow = $perShow;
        $this -> currentItems = array_slice($this -> items, $this -> offset, $this -> perShow, true);
    }

    public function moveRight(){
        if($this -> offset + $this -> perShow >= count($this -> items))
            $this -> offset = 0;
        else
            $this -> offset += $this -> perShow;
        $this -> currentItems = array_slice($this -> items, $this -> offset, $this -> perShow, true);
    }

    public function moveLeft(){
        if($this -> offset - $this -> perShow < 0)
            $this -> offset = count($this -> items);

        $this -> offset -= $this -> perShow;
        $this -> currentItems = array_slice($this -> items, $this -> offset, $this -> perShow, true);
    }
    public function render()
    {
        return view('livewire.slideshow');
    }
}
