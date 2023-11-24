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
        $vehicle = Vehicle::orderBy('id', 'ASC')->paginate(10);

        return new VehicleResource($vehicle);
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
        if (!isset($validate['vctr'])) {
            $vehicles = Vehicle::orderBy('id', 'ASC')->paginate(100);
        } else {
            $vehicles = Vehicle::where('vctr', 'LIKE', "%{$validated['vctr']}%")
                ->orWhere('position', 'LIKE', "%{$validated['vctr']}")
                ->paginate(100);
        }

        return VehicleResource::collection($vehicles);
    }
}
