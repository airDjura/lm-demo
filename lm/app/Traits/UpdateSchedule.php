<?php
namespace App\Traits;

use Ramsey\Uuid\Uuid;

/**
 * Created by PhpStorm.
 * User: neville.woller
 * Date: 7/23/17
 * Time: 4:06 PM
 */
trait UpdateSchedule
{

    /**
     * Binds creating/saving events to create UUIDs (and also prevent them from being overwritten).
     *
     * @return void
     */
    public static function bootUpdateSchedule()
    {
        static::created(function ($model) {
            if ($model->schedule->games()->count() > 0) {
                if($model->schedule->games()->where('status', 'LIVE')->where('status', 'ARCHIVED')->count() > 0) {
                    // TODO
                } else {
                    $cycles = $model->schedule->games->groupBy('round')->count() / (ceil($model->schedule->teams()->count() / 2) * 2 - 2);
                    $model->schedule->games()->delete();
                    $model->schedule->generateGames($cycles);
                }
            }
        });

    }

}
