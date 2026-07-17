@if ($match->sport === 'football')
    @include('components.scoreboard-football', ['match' => $match])
@elseif ($match->sport === 'volleyball')
    @include('components.scoreboard-volleyball', ['match' => $match])
@endif
