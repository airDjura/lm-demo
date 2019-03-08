<?php

namespace App\Models\Client;

use airDjura\Landlord\BelongsToTenants;
use Illuminate\Database\Eloquent\Model;

class PlayerTeam extends Model
{
    use BelongsToTenants;
    public $tenantColumns = ['client_id', 'season_id'];
    protected $table = 'player_team';

    protected $fillable = [
        'league_id',
        'suffix',
    ];

    public function player () {
        return $this->belongsTo(Player::class);
    }

    public function season () {
        return $this->belongsTo(Season::class);
    }

    public function team () {
        return $this->belongsTo(Team::class);
    }
}
