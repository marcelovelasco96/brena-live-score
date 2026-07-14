<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MatchGame extends Model
{
    protected $fillable = [
        'sport',
        'title',
        'team_a_name',
        'team_b_name',
        'team_a_score',
        'team_b_score',
        'team_a_sets',
        'team_b_sets',
        'set_number',
        'period',
        'timer_seconds',
        'timer_running',
        'team_a_bg',
        'team_b_bg',
        'timer_started_at',
        'team_a_logo',
        'team_b_logo',
        'team_a_background',
        'team_b_background',
        'team_a_color',
        'team_b_color',
        'team_a_jersey_color',
        'team_b_jersey_color',
        'penalties_enabled',
        'team_a_penalties',
        'team_b_penalties',
        'status',
        'broadcast_mode',
        'banner_enabled',
        'banner_label',
        'banner_title',
        'banner_show_label',
    ];

    protected $casts = [
        'timer_running' => 'boolean',
        'timer_started_at' => 'datetime',
        'penalties_enabled' => 'boolean',
        'team_a_penalties' => 'array',
        'team_b_penalties' => 'array',
        'banner_enabled' => 'boolean',
        'banner_show_label' => 'boolean',
    ];

    public function currentTimerSeconds(): int
    {
        if (! $this->timer_running || ! $this->timer_started_at) {
            return (int) $this->timer_seconds;
        }

        $elapsed = $this->timer_started_at->diffInSeconds(now(), false);

        return max(0, (int) $this->timer_seconds + (int) $elapsed);
    }
}
