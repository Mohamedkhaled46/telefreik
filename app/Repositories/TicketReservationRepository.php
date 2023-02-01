<?php


namespace App\Repositories;

use App\Models\TicketReservation;
use App\Repositories\Interfaces\ITicketReservationRepository;
use Illuminate\Database\Eloquent\Collection;

class TicketReservationRepository implements ITicketReservationRepository
{
    public function create($request): TicketReservation
    {
        $data = $request->validated();
        $data['customer_id'] = $request->user()->id;
        $data['status'] = 'Waiting';
        return TicketReservation::create($data);
    }

    public function search($request): Collection
    {
        $records = TicketReservation::query()
            ->when($request->filled('term'), function ($query) use ($request) {
                $query->whereHas('provider', function ($query) use ($request) {
                    $query->where('name', 'LIKE', '%' . $request->term . '%');
                });
            })
            ->when($request->filled('ticket'), function ($query) use ($request) {
                $query->where('id', $request->ticket);
            })
            ->when($request->status !== "All", function ($query) use ($request) {
                $query->where('status', $request->status);
            })
            ->latest()
            ->take(30)
            ->get();
        return $records;
    }
}
