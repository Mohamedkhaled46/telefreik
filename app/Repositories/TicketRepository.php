<?php
namespace App\Repositories;

use App\User;
use App\Models\Ticket;
use App\Repositories\Interfaces\ITicketRepository;
use Carbon\Carbon;

class TicketRepository implements ITicketRepository
{
    public $ticket;
    public function __construct(Ticket $ticket)
    {
        $this->ticket = $ticket;
    }


    public function show($id)
    {
        return $this->ticket->where('id',$id)->with(['customer','replies.user'])->first();
    }

    public function filter()
    {
        $ticket = $this->ticket->query();
        $ticket->when(request()->has('customer')&& !request()->has('date') , function ($query) {
            $customer = request('customer');
            return $query->whereHas('customer', function ($q) use ($customer) {
                $q->where('name','Like','%'. $customer.'%');
            });
        });

        $ticket->when(request()->has('date') && !request()->has('customer'), function ($query) {
            $date = Carbon::parse(request('date'));
            return $query->whereDate('created_at', '=',$date );
        });

        $ticket->when(request()->has('status') && !request()->has('customer') && !request()->has('date'), function ($query) {
            $status = request('status');
            return $query->where('status', $status);
        });

        $ticket->when(request()->has('status') && request()->has('customer') && !request()->has('date'), function ($query) {
            $status = request('status');
            $customer = request('customer');
            return $query->where('status', $status)->where('customer','Like' , '%'. $customer.'%');
        });

        $ticket->when(request()->has('status') && !request()->has('customer') && request()->has('date'), function ($query) {
            $status = request('status');
            $date = Carbon::parse(request('date'));

            return $query->where('status', $status)->whereDate('created_at', '=',$date );
        });

        $ticket->when(request()->has('customer') && request()->has('date') , function ($query) {
            $customer = request('customer');
            $date = Carbon::parse(request('date'));
            return $query->whereHas('customer', function ($q) use ($customer) {
                $q->where('name','Like','%'. $customer.'%');
            })->whereDate('created_at', '=', $date );
        });

        $ticket->when(request()->has('customer') && request()->has('date') &&request()->has('status')  , function ($query) {
            $customer = request('customer');
            $status = request('status');
            $date = Carbon::parse(request('date'));
            return $query->whereHas('customer', function ($q) use ($customer) {
                $q->where('name','Like','%'. $customer.'%');
            })
            ->where('status' ,$status)
            ->whereDate('created_at', '=', $date );
        });

        return $ticket->with('customer')->paginate(10);

    }



    public function changeStatus($id)
    {
        $status= request()->has('status')?request('status'):null;
        $ticket = Ticket::findOrFail($id);
        $isChanged = $ticket->update(['status' => $status]);
        return ((bool)$isChanged)?$ticket->refresh():false;
    }


    public function create($request)
    {
        return $this->ticket::create([
            'title' => $request->title,
            'description' => $request->description,
            'section' => $request->section,
            'status' =>"Opened",
            'customer_id' => $request->user('customer-api')->id
        ]);
    }

    public function getAllForCustomer($request)
    {
        return $this->ticket::where('customer_id',$request->user('customer-api')->id)->orderByDesc('created_at')->paginate(10);
    }

    public function showForMobile($id)
    {
        return $this->ticket->where('id',$id)->with(['customer','replies.user'])->first();
    }
}
