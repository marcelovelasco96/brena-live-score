<?php

namespace App\Http\Controllers;

use App\Models\MatchGame;
use Illuminate\Http\Request;

class MatchGameController extends Controller
{
    public function index()
    {
        $matches = MatchGame::latest()->get();

        return view('matches.index', compact('matches'));
    }

    public function create()
    {
        return view('matches.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'sport' => ['required', 'in:football,volleyball'],
            'title' => ['nullable', 'string', 'max:255'],
            'team_a_name' => ['required', 'string', 'max:255'],
            'team_b_name' => ['required', 'string', 'max:255'],
        ]);

        $match = MatchGame::create($data);

        return redirect()->route('matches.control', $match);
    }

    public function control(MatchGame $match)
    {
        return view('matches.control', compact('match'));
    }

    public function updateScore(Request $request, MatchGame $match)
    {
        $data = $request->validate([
            'team' => ['required', 'in:a,b'],
            'action' => ['required', 'in:increment,decrement'],
        ]);

        $field = $data['team'] === 'a' ? 'team_a_score' : 'team_b_score';

        if ($data['action'] === 'increment') {
            $match->increment($field);
        } else {
            $match->$field = max(0, $match->$field - 1);
            $match->save();
        }

        if ($request->expectsJson()) {
            return response()->json($this->matchPayload($match->fresh()));
        }

        return redirect()->route('matches.control', $match);
    }

    public function updatePeriod(Request $request, MatchGame $match)
    {
        $data = $request->validate([
            'period' => ['required', 'in:1T,Descanso,2T,Final'],
        ]);

        $match->update([
            'period' => $data['period'],
        ]);

        if ($request->expectsJson()) {
            return response()->json($this->matchPayload($match->fresh()));
        }

        return redirect()->route('matches.control', $match);
    }

    public function updateTimer(Request $request, MatchGame $match)
    {
        $data = $request->validate([
            'action' => [
                'required',
                'in:start,start_second_half,pause,reset,add_minute,subtract_minute,set_45,set_90,finish',
            ],
        ]);

        switch ($data['action']) {
            case 'start':
                if (! $match->timer_running) {
                    $match->timer_running = true;
                    $match->timer_started_at = now();
                    $match->status = 'live';
                    $match->save();
                }
                break;

            case 'start_second_half':
                $match->period = '2T';
                $match->timer_seconds = 30 * 60;
                $match->timer_running = true;
                $match->timer_started_at = now();
                $match->status = 'live';
                $match->save();
                break;

            case 'pause':
                if ($match->timer_running) {
                    $match->timer_seconds = $match->currentTimerSeconds();
                    $match->timer_running = false;
                    $match->timer_started_at = null;
                    $match->save();
                }
                break;

            case 'reset':
                $match->timer_seconds = 0;
                $match->timer_running = false;
                $match->timer_started_at = null;
                $match->status = 'pre_match';
                $match->period = '1T';
                $match->save();
                break;

            case 'set_45':
                $match->timer_seconds = 30 * 60;
                $match->timer_running = false;
                $match->timer_started_at = null;
                $match->status = 'halftime';
                $match->save();
                break;

            case 'set_90':
                $match->timer_seconds = 90 * 60;
                $match->timer_running = false;
                $match->timer_started_at = null;
                $match->save();
                break;

            case 'finish':
                $match->timer_seconds = $match->currentTimerSeconds();
                $match->timer_running = false;
                $match->timer_started_at = null;
                $match->status = 'finished';
                $match->save();
                break;

            case 'add_minute':
                $match->increment('timer_seconds', 60);
                break;

            case 'subtract_minute':
                $match->timer_seconds = max(0, $match->timer_seconds - 60);
                $match->save();
                break;
        }

        $match = $match->fresh();

        if ($request->expectsJson()) {
            return response()->json($this->matchPayload($match));
        }

        return redirect()->route('matches.control', $match);
    }

    public function updateVolleyball(Request $request, MatchGame $match)
    {
        abort_unless($match->sport === 'volleyball', 404);

        $data = $request->validate([
            'action' => ['required', 'in:start,finish_set,finish_match,reset_match'],
            'winner' => ['nullable', 'in:a,b'],
        ]);

        switch ($data['action']) {

            case 'start':
                $match->status = 'live';
                $match->save();
                break;

            case 'finish_set':
                if (! isset($data['winner'])) {
                    return back()->withErrors([
                        'winner' => 'Debes indicar qué equipo ganó el set.',
                    ]);
                }

                $setsField = $data['winner'] === 'a'
                    ? 'team_a_sets'
                    : 'team_b_sets';

                $match->increment($setsField);

                $match->team_a_score = 0;
                $match->team_b_score = 0;
                $match->set_number = max(1, (int) $match->set_number) + 1;
                $match->status = 'live';
                $match->save();
                break;

            case 'finish_match':
                $match->status = 'finished';
                $match->save();
                break;

            case 'reset_match':
                $match->team_a_score = 0;
                $match->team_b_score = 0;
                $match->team_a_sets = 0;
                $match->team_b_sets = 0;
                $match->set_number = 1;
                $match->status = 'pre_match';
                $match->save();
                break;
        }

        $match = $match->fresh();

        if ($request->expectsJson()) {
            return response()->json($this->matchPayload($match));
        }

        return redirect()->route('matches.control', $match);
    }

    public function overlay(MatchGame $match)
    {
        return view('matches.overlay', compact('match'));
    }

    public function overlayData(MatchGame $match)
    {
        return response()->json([
            'id' => $match->id,
            'sport' => $match->sport,
            'title' => $match->title,
            'team_a_name' => $match->team_a_name,
            'team_b_name' => $match->team_b_name,
            'team_a_score' => $match->team_a_score,
            'team_b_score' => $match->team_b_score,
            'team_a_sets' => $match->team_a_sets,
            'team_b_sets' => $match->team_b_sets,
            'team_a_logo' => $match->team_a_logo ? '/storage/' . $match->team_a_logo : null,
            'team_b_logo' => $match->team_b_logo ? '/storage/' . $match->team_b_logo : null,
            'team_a_background' => $match->team_a_background ? '/storage/' . $match->team_a_background : null,
            'team_b_background' => $match->team_b_background ? '/storage/' . $match->team_b_background : null,
            'team_a_color' => $match->team_a_color,
            'team_b_color' => $match->team_b_color,
            'team_a_jersey_color' => $match->team_a_jersey_color,
            'team_b_jersey_color' => $match->team_b_jersey_color,
            'set_number' => $match->set_number,
            'period' => $match->period,
            'timer_seconds' => $match->currentTimerSeconds(),
            'timer_running' => $match->timer_running,
            'status' => $match->status,
            'penalties_enabled' => $match->penalties_enabled,
            'team_a_penalties' => $match->team_a_penalties ?? array_fill(0, 5, null),
            'team_b_penalties' => $match->team_b_penalties ?? array_fill(0, 5, null),
            'broadcast_mode' => $match->broadcast_mode,
            'banner_enabled' => $match->banner_enabled,
            'banner_label' => $match->banner_label,
            'banner_title' => $match->banner_title,
            'banner_show_label' => (bool) $match->banner_show_label,
        ]);
    }

    private function matchPayload(MatchGame $match): array
    {
        return [
            'id' => $match->id,

            'sport' => $match->sport,

            'team_a_score' => $match->team_a_score,
            'team_b_score' => $match->team_b_score,

            'team_a_sets' => $match->team_a_sets,
            'team_b_sets' => $match->team_b_sets,
            'set_number' => $match->set_number,

            'period' => $match->period,

            'timer_seconds' => $match->currentTimerSeconds(),
            'timer_text' => gmdate('i:s', $match->currentTimerSeconds()),
            'timer_running' => $match->timer_running,

            'status' => $match->status,
        ];
    }

    public function settings(MatchGame $match)
    {
        return view('matches.settings', compact('match'));
    }

    public function updateSettings(Request $request, MatchGame $match)
    {

        $data = $request->validate([
            'team_a_name' => ['required', 'string', 'max:255'],
            'team_b_name' => ['required', 'string', 'max:255'],
            'team_a_logo' => ['nullable', 'image', 'max:20480'],
            'team_b_logo' => ['nullable', 'image', 'max:20480'],
            'team_a_background' => ['nullable', 'image', 'max:20480'],
            'team_b_background' => ['nullable', 'image', 'max:20480'],
            'team_a_color' => ['required', 'string', 'max:20'],
            'team_b_color' => ['required', 'string', 'max:20'],
            'team_a_jersey_color' => ['required', 'string', 'max:20'],
            'team_b_jersey_color' => ['required', 'string', 'max:20'],
            'remove_team_a_logo' => ['nullable', 'boolean'],
            'remove_team_b_logo' => ['nullable', 'boolean'],
            'remove_team_a_background' => ['nullable', 'boolean'],
            'remove_team_b_background' => ['nullable', 'boolean'],
        ]);

        $match->team_a_name = $data['team_a_name'];
        $match->team_b_name = $data['team_b_name'];
        $match->team_a_color = $data['team_a_color'];
        $match->team_b_color = $data['team_b_color'];
        $match->team_a_jersey_color = $data['team_a_jersey_color'];
        $match->team_b_jersey_color = $data['team_b_jersey_color'];

        if ($request->boolean('remove_team_a_logo')) {
            $match->team_a_logo = null;
        }

        if ($request->boolean('remove_team_b_logo')) {
            $match->team_b_logo = null;
        }

        if ($request->boolean('remove_team_a_background')) {
            $match->team_a_background = null;
        }

        if ($request->boolean('remove_team_b_background')) {
            $match->team_b_background = null;
        }

        if ($request->hasFile('team_a_logo')) {
            $match->team_a_logo = $request->file('team_a_logo')->store('scoreboard/logos', 'public');
        }

        if ($request->hasFile('team_b_logo')) {
            $match->team_b_logo = $request->file('team_b_logo')->store('scoreboard/logos', 'public');
        }

        if ($request->hasFile('team_a_background')) {
            $match->team_a_background = $request->file('team_a_background')->store('scoreboard/backgrounds', 'public');
        }

        if ($request->hasFile('team_b_background')) {
            $match->team_b_background = $request->file('team_b_background')->store('scoreboard/backgrounds', 'public');
        }

        $match->save();

        return redirect()->route('matches.settings', $match)
            ->with('success', 'Configuración actualizada correctamente.');
    }

    public function updateStatus(Request $request, MatchGame $match)
    {
        $data = $request->validate([
            'status' => ['required', 'in:pre_match,live,halftime,finished'],
        ]);

        $match->update([
            'status' => $data['status'],
        ]);

        if ($request->expectsJson()) {
            return response()->json($this->matchPayload($match->fresh()));
        }

        return redirect()->route('matches.control', $match);
    }

    public function updatePenalties(Request $request, MatchGame $match)
    {
        $data = $request->validate([
            'team' => ['nullable', 'in:a,b'],
            'action' => ['required', 'in:toggle,gol,falla,reset'],
        ]);

        if ($data['action'] === 'toggle') {
            $match->penalties_enabled = ! $match->penalties_enabled;
        }

        if ($data['action'] === 'reset') {
            $match->team_a_penalties = array_fill(0, 5, null);
            $match->team_b_penalties = array_fill(0, 5, null);
        }

        if (in_array($data['action'], ['gol', 'falla']) && isset($data['team'])) {
            $field = $data['team'] === 'a' ? 'team_a_penalties' : 'team_b_penalties';

            $penalties = $match->$field;

            if (!is_array($penalties)) {
                $penalties = array_fill(0, 5, null);
            }

            $nextIndex = array_search(null, $penalties, true);

            if ($nextIndex !== false) {
                $penalties[$nextIndex] = $data['action'];
            }

            $match->$field = $penalties;
        }

        $match->save();

        return response()->json([
            'penalties_enabled' => $match->penalties_enabled,
            'team_a_penalties' => $match->team_a_penalties ?? array_fill(0, 5, null),
            'team_b_penalties' => $match->team_b_penalties ?? array_fill(0, 5, null),
        ]);
    }

    public function updateBanner(Request $request, MatchGame $match)
    {
        $data = $request->validate([
            'broadcast_mode' => ['required', 'in:sports,banner'],
            'banner_enabled' => ['nullable', 'boolean'],
            'banner_label' => ['nullable', 'string', 'max:80'],
            'banner_title' => ['nullable', 'string', 'max:120'],
            'banner_show_label' => ['nullable', 'boolean'],
        ]);

        $match->broadcast_mode = $data['broadcast_mode'];
        $match->banner_enabled = $request->boolean('banner_enabled');
        $match->banner_show_label = $request->boolean('banner_show_label');
        $match->banner_label = $data['banner_label'] ?? null;
        $match->banner_title = $data['banner_title'] ?? null;
        $match->save();

        if (! $request->expectsJson()) {
            return redirect('/matches/' . $match->id . '/control');
        }

        return response()->json([
            'team_a_score' => $match->team_a_score,
            'team_b_score' => $match->team_b_score,
            'timer_text' => gmdate('i:s', $match->currentTimerSeconds()),
            'timer_seconds' => $match->currentTimerSeconds(),
            'period' => $match->period,
            'status' => $match->status,

            'penalties_enabled' => $match->penalties_enabled,
            'team_a_penalties' => $match->team_a_penalties ?? array_fill(0, 5, null),
            'team_b_penalties' => $match->team_b_penalties ?? array_fill(0, 5, null),

            'broadcast_mode' => $match->broadcast_mode,
            'banner_enabled' => $match->banner_enabled,
            'banner_label' => $match->banner_label,
            'banner_title' => $match->banner_title,
        ]);
    }
}
