<?php
    /**
     * Created by PhpStorm.
     * User: airdjura
     * Date: 1/3/19
     * Time: 9:07 PM
     */

    namespace App\Actions\Api\Admin\Schedule;

    class ScheduleAct {
        public function generateGroupArrayOfMatches(array $teams, int $cycles) {
            if (count($teams) % 2 != 0) {
                array_push($teams, null);
            }

            $away = array_splice($teams, (count($teams) / 2));

            $home = $teams;

            $drafts = [];

            $round = 1;

            for ($i = 0; $i < $cycles; ++$i) {
                for ($j = 0; $j < count($home) + count($away) - 1; ++$j) {
                    for ($k = 0; $k < count($home); ++$k) {
                        if($i % 2 != 0) {
                            if ($j % 2 == 0) {
                                $drafts[$round][$j][$k]['club_a_id'] = $away[$k] ? $away[$k]['club_id'] : $away[$k];
                                $drafts[$round][$j][$k]['team_a_id'] = $away[$k] ? $away[$k]['id'] : $away[$k];
                                $drafts[$round][$j][$k]['club_b_id'] = $home[$k] ? $home[$k]['club_id'] : $home[$k];
                                $drafts[$round][$j][$k]['team_b_id'] = $home[$k] ? $home[$k]['id'] : $home[$k];
                            } else {
                                $drafts[$round][$j][$k]['club_a_id'] = $home[$k] ? $home[$k]['club_id'] : $home[$k];
                                $drafts[$round][$j][$k]['team_a_id'] = $home[$k] ? $home[$k]['id'] : $home[$k];
                                $drafts[$round][$j][$k]['club_b_id'] = $away[$k] ? $away[$k]['club_id'] : $away[$k];
                                $drafts[$round][$j][$k]['team_b_id'] = $away[$k] ? $away[$k]['id'] : $away[$k];
                            }
                        } else {
                            if ($j % 2 == 0) {
                                $drafts[$round][$j][$k]['club_a_id'] = $home[$k] ? $home[$k]['club_id'] : $home[$k];
                                $drafts[$round][$j][$k]['team_a_id'] = $home[$k] ? $home[$k]['id'] : $home[$k];
                                $drafts[$round][$j][$k]['club_b_id'] = $away[$k] ? $away[$k]['club_id'] : $away[$k];
                                $drafts[$round][$j][$k]['team_b_id'] = $away[$k] ? $away[$k]['id'] : $away[$k];
                            } else {
                                $drafts[$round][$j][$k]['club_a_id'] = $away[$k] ? $away[$k]['club_id'] : $away[$k];
                                $drafts[$round][$j][$k]['team_a_id'] = $away[$k] ? $away[$k]['id'] : $away[$k];
                                $drafts[$round][$j][$k]['club_b_id'] = $home[$k] ? $home[$k]['club_id'] : $home[$k];
                                $drafts[$round][$j][$k]['team_b_id'] = $home[$k] ? $home[$k]['id'] : $home[$k];
                            }
                        }

                    }

                    ++$round;

                    if (count($home) + count($away) - 1 > 2) {
                        $splice = array_splice($home, 1, 1);
                        array_unshift($away, array_shift($splice));
                        array_push($home, array_pop($away));
                    }
                }
            }
            return $drafts;
        }
    }
