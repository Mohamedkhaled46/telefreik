<?php


namespace App\Repositories\Interfaces;

use App\Models\TicketReservation;
use Illuminate\Database\Eloquent\Collection;

interface ITicketReservationRepository
{
    public function create($request): TicketReservation;
    public function search($request): Collection;
}
