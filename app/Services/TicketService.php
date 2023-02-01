<?php
namespace App\Services;

use App\Models\Ticket;
use App\Repositories\Interfaces\ITicketRepository;


class TicketService
{
    protected $ticketRepository;
    public function __construct(ITicketRepository $ticketRepository) {
        $this->ticketRepository = $ticketRepository;
    }

    public function filter()
    {
        return $this->ticketRepository->filter();
    }

    public function show($id)
    {
        return $this->ticketRepository->show($id);
    }

    public function changeStatus($id)
    {
        return $this->ticketRepository->changeStatus($id);
    }

    public function create($request)
    {
        return $this->ticketRepository->create($request);
    }

    public function getAllForCustomer($request)
    {
        return $this->ticketRepository->getAllForCustomer($request);
    }

    public function showForMobile($id)
    {
        return $this->ticketRepository->showForMobile($id);
    }
}
