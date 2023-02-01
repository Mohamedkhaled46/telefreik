<?php

namespace App\Http\Controllers\Api;

use App\Services\TicketReservationService;
use App\Http\Controllers\Api\BaseController as BaseController;
use App\Http\Requests\Api\TicketReservation\TicketReservationRequest;
use App\Http\Requests\Api\TicketReservation\TicketReservationSearchRequest;
use App\Http\Resources\Api\TicketReservation\TicketReservationResource;

class TicketReservationController extends BaseController
{
    public $ticketReservationService;

    public function __construct(TicketReservationService $ticketReservationService)
    {
        $this->ticketReservationService = $ticketReservationService;
    }

    public function create(TicketReservationRequest $request)
    {
        $record = $this->ticketReservationService->create($request);
        if (!$record->wasRecentlyCreated) {
            return $this->sendError('Failed.', ['error' => 'Creation Failed']);
        } else {
            $data = [
                'reservation' => new TicketReservationResource($record),
            ];
            return $this->sendResponse($data, 'Reserved successfully');
        }
    }

    public function search(TicketReservationSearchRequest $request)
    {
        $records = $this->ticketReservationService->search($request);
        if ($records->isEmpty()) {
            return $this->sendResponse(array('reservations' => []), 'No Data Found');
        } else {
            $data = [
                'reservations' => TicketReservationResource::collection($records),
            ];
            return $this->sendResponse($data, 'Data Found');
        }
    }
}
