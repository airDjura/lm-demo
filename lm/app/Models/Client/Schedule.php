<?php

    namespace App\Models\Client;

    use App\Actions\Api\Admin\Schedule\ScheduleAct;
    use App\Traits\ScheduleGroup;
    use Illuminate\Support\Facades\DB;

    class Schedule extends SeasonBaseModel {
        use ScheduleGroup;

        protected $fillable = [
            'league_id',
        ];

        public function games() {
            return $this->hasMany(Game::class);
        }

        public function league () {
            return $this->belongsTo(League::class);
        }

        public function groups() {
            return $this->hasMany(Group::class);
        }

        public function season () {
            return $this->belongsTo(Season::class);
        }

        public function teams () {
            return $this->hasMany(Team::class);
        }

        public function getName() {
            return $this->league->name;
        }

        public function generateGames($cycles) {
            $groups = $this->groups;

            foreach ($groups as $group) {
                if ($group->teams->count() < 2) {
                    $message = $groups->count() > 1 ? 'badrequest.schedule.generate.group.teams' : 'badrequest.schedule.generate.teams';
                    return response($message, 400);
                }
            }



            foreach ($groups as $group) {
                $teams = $group->teams->toArray();
                $action = new ScheduleAct();

                $rounds = $action->generateGroupArrayOfMatches($teams, $cycles);

                DB::transaction(function() use ($rounds, $group) {
                    foreach ($rounds as $round => $draft) {
                        foreach ($draft as $games) {
                            foreach ($games as $game) {
                                $match = new Game();
                                $match->schedule_id = $this->id;
                                $match->group_id = $group->id;
                                $match->round = $round;
                                $match->teamA = $game['team_a_id'];
                                $match->teamB = $game['team_b_id'];
                                $match->save();
                            }
                        }
                    }
                });
            }
        }
    }
