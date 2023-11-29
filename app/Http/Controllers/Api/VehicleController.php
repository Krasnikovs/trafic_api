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
        $vehicle = Vehicle::orderBy('msg_id', 'ASC')->get();

        return $vehicle;
    }

    public function show(Vehicle $vehicle)
    {
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

    public function avgLifetime ()
    {
        $vehicle = '[19, 32]';
        $lifetime = Vehicle::select('vector')
            ->where('vector', $vehicle)
            ->count();

        return $lifetime;
    }

    public function placesBeen ()
    {
        $vehicle = '[73, 15]';
        $corner_list = [];
        $corners = Vehicle::select('position')
            ->where('vector', $vehicle)
            ->groupBy('position')
            ->get();

        return $corners;
    }
}
