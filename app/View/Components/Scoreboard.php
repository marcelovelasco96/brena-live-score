<?php

namespace App\View\Components;

use App\Models\MatchGame;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Scoreboard extends Component
{
    public function __construct(
        public MatchGame $match
    ) {}

    public function render(): View|Closure|string
    {
        return view('components.scoreboard');
    }
}