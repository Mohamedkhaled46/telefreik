<?php

namespace Database\Seeders;

use App\Models\Provider;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProviderSeeder extends Seeder
{
    protected $names = ['skyscanner', 'wego', 'arab_bridge_maritime', 'egyptian_railways', 'gobus', 'otobeesy', 'goldenhorse', 'gomini', 'golimousine'];
    protected $type = ["Flights", "Voyage", "Trains", "Busses", "Microbuses", "Limousine"];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // skyscanner
        $this->seed($this->names[0], ["Flights"], "Providers/{$this->names[0]}.jpg");
        // wego
        $this->seed($this->names[1], ["Flights"], "Providers/{$this->names[1]}.jpg");
        // arab_bridge_maritime
        $this->seed($this->names[2], ["Voyage"], "Providers/{$this->names[2]}.jpg");
        // egyptian_railways
        $this->seed($this->names[3], ["Trains"], "Providers/{$this->names[3]}.jpg");
        // gobus
        $this->seed($this->names[4], ["Busses"], "Providers/{$this->names[4]}.jpg");
        // otobeesy
        $this->seed($this->names[5], ["Busses"], "Providers/{$this->names[5]}.jpg");
        // goldenhorse
        $this->seed($this->names[6], ["Busses"], "Providers/{$this->names[6]}.jpg");
        // gomini
        $this->seed($this->names[7], ["Microbuses"], "Providers/{$this->names[7]}.jpg");
        // golimousine 
        $this->seed($this->names[8], ["Limousine"], "Providers/{$this->names[8]}.jpg");
    }
    public function seed($name, $types, $logo)
    {
        foreach ($types as  $value) {
            Provider::firstOrCreate([
                'name' => $name,
                'type' => $value,
                'logo' => $logo,
                'rate' => rand(1, 5),
                'rating' => rand(1, 5),
                'cost' => rand(1, 5),
                'income' => rand(1, 5),
                'revenue' => rand(1, 5),
            ]);
        }
    }
}
