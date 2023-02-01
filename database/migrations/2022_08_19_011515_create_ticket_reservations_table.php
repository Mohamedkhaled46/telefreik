<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ticket_reservations', function (Blueprint $table) {
            $table->id();
            $table->decimal('price', 16, 2);
            $table->string('departure');
            $table->string('arrival');
            $table->mediumInteger('child_count');
            $table->mediumInteger('adult_count');
            $table->dateTime('departure_at');
            $table->dateTime('arrive_at')->nullable();
            $table->string('kind')->nullable()->comment('business, economic, premium');
            $table->string('type')->comment('Flights, Voyage, Trains, Busses, Microbuses, Limousine');
            $table->string('status')->comment('Waiting, Upcomming, Finished');
            $table->foreignId('provider_id')->constrained();
            $table->foreignId('customer_id')->constrained();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ticket_reservations');
    }
}
