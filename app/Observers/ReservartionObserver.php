<?php

namespace App\Observers;

use App\Models\Reservation;

class ReservartionObserver
{
    /**
     * Handle the Board "created" event.
     *
     * @param  \App\Models\Reservation  $reservation
     * @return void
     */
    public function created(Reservation $reservation)
    {
        $reservation->board()->update([
            'available' => false,
        ]);
    }

    /**
     * Handle the Board "updated" event.
     *
     * @param  \App\Models\Board  $reservation
     * @return void
     */
    public function updated(Reservation $reservation)
    {
        $reservation->completed = $reservation->board()->update([
            'available' => true,
        ]);
    }
}
