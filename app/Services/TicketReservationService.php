<?php


namespace App\Services;

use App\Models\TicketReservation;
use App\Repositories\Interfaces\ITicketReservationRepository;
use Illuminate\Database\Eloquent\Collection;

class TicketReservationService
{
    private $ticketReservationRepository;
    public function __construct(ITicketReservationRepository $ticketReservationRepository)
    {
        $this->ticketReservationRepository = $ticketReservationRepository;
    }

    public function create($request): TicketReservation
    {
        return $this->ticketReservationRepository->create($request);
    }

    public function search($request): Collection
    {
        return $this->ticketReservationRepository->search($request);
    }
}
