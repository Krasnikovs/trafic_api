<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

use App\Models\Vehicle;
use App\Http\Requests\VehicleRequest;
use App\Http\Resources\VehicleResource;
use Illuminate\Support\Facades\DB;

class VehicleController extends Controller
{
    public function index()
    {
        $vehicle = Vehicle::orderBy('id', 'ASC')->get();

        return $vehicle;
    }

    public function show(Vehicle $vehicle)
    {
        return new VehicleResource($vehicle);
    }

    public function input(VehicleRequest $request)
    {
        $vehicle = Vehicle::create($request->validated());
        return new VehicleResource($vehicle);
    }

    public function vehicleFilter (Request $request)
    {
        $validated = $request->validate([
           'name' => 'sometimes'
        ]);
        if (!isset($validate['vector'])) {
            $vehicles = Vehicle::orderBy('id', 'ASC')->paginate(100);
        } else {
            $vehicles = Vehicle::where('vector', 'LIKE', "%{$validated['vector']}%")
                ->orWhere('position', 'LIKE', "%{$validated['vector']}")
                ->paginate(100);
        }

        return VehicleResource::collection($vehicles);
    }

    public function mostScene ()
    {
        $vehicle = Vehicle::select('vector')
            ->groupBy('vector')
            ->orderByRaw('COUNT(*) DESC')
            ->limit(1)
            ->get();

        return $vehicle;
    }

    public function leastScene ()
    {
        $vehicle = Vehicle::select('vector')
            ->groupBy('vector')
            ->orderByRaw('COUNT(*) ASC')
            ->limit(1)
            ->get();

        return $vehicle;
    }

    public function avgLifetime (Request $request)
    {
        $validated = $request->validate([
            'name' => 'sometimes'
         ]);

        if (!isset($validate['vector'])) {
            $lifetime = 'Choose vehicle';
        } else {
            $vehicle = Vehicle::where('vector', 'LIKE', "%{$validated['vector']}%")
                ->orWhere('position', 'LIKE', "%{$validated['vector']}")
                ->paginate(100);
            
            $lifetime = Vehicle::select('vector')
                ->where('vector', $vehicle)
                ->count();
        }

        

        return $lifetime;
    }

    public function placesBeen (Request $request)
    {
        $validated = $request->validate([
            'name' => 'sometimes'
         ]);

        if (!isset($validate['vector'])) {
            $corners = 'Choose vehicle';
        } else {
            $vehicle = Vehicle::where('vector', 'LIKE', "%{$validated['vector']}%")
                ->orWhere('position', 'LIKE', "%{$validated['vector']}")
                ->paginate(100);

            $corners = Vehicle::select('position')
                ->where('vector', $vehicle)
                ->groupBy('position')
                ->get();
        }

        $corner_list = [];


        return $corners;
    }

    public function timeframes ()
    {
        $vehicles = Vehicle::get()->countBy(function ($vehicle) {
            return $vehicle->timestamp;
        });
        $vehicles = $vehicles->toArray();
        $dates = array_keys($vehicles);

        $counts = array_values($vehicles);

        return [$dates, $counts];
    }
}