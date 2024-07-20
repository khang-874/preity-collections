<?php

namespace App\Livewire;

use Livewire\Component;
use RalphJSmit\Livewire\Urls\Facades\Url;

class Filters extends Component
{
    public $options = [];
    public $currentOptions = [];
    public $property = "";
    public $currentUrl = "";

    public function mount(array $options, string $property){
        $this -> currentUrl = url() -> current();
        $this -> options = $options;
        $this -> property = $property;
        if(request($property)){
            foreach(request($property) as $option){
                $this -> currentOptions []= $option;
            }
        }
        // dd(request() -> query());
    }

    public function updated(){
        // $this -> redirect(url('/'), true);   
        $url = session() -> get('_previous')['url'];
        $query = parse_url($url)['query'];
        parse_str($query, $queryParameters); 
        // dd($queryParameters);
        $queryParameters[$this -> property] = $this -> currentOptions;

        $this -> redirectRoute('listings.index', $queryParameters, navigate:true);
    } 
    public function render()
    {
        return view('livewire.filters');
    }
}
