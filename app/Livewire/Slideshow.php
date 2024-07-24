<?php

namespace App\Livewire;

// use DeviceDetector\Parser\Client\Browser;
use hisorange\BrowserDetect\Stages\BrowserDetect;
use Livewire\Component;

use Browser;

class Slideshow extends Component
{
    public int $perShow = 1;
    public int $offset = 0;
    public array $items = [];
    public array $currentItems = [];
    public string $type = '';
    public string $title = '';
    public function mount(array $items, string $type, string $title){
        $this -> items = $items;
        $this -> type = $type;
        $this -> title = $title;

        if(Browser::isMobile()){
            $this -> perShow = 2;
        }
        if(Browser::isTablet()){
            $this -> perShow = 3;
        }
        if(Browser::isDesktop()){
            $this -> perShow = 4;
        }
        if($this -> perShow >= count($items))
            $this -> perShow = count($items);
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
