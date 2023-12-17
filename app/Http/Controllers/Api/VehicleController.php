<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

use App\Models\Vehicle;
use App\Http\Requests\VehicleRequest;
use App\Http\Resources\VehicleResource;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use \Mpdf\Mpdf as PDF;

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
           'vector' => 'sometimes'
        ]);
        if (!isset($validated['vector'])) {
            $vehicles = Vehicle::orderBy('id', 'ASC')->paginate(10);
        } else {
            $vehicles = Vehicle::where('vector', 'LIKE', "%{$validated['vector']}%")
                ->paginate(10);
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
        $completedVetors = [];
        $lifeTimes = [];
        $vehicles = Vehicle::all();

        foreach ($vehicles as $vehicle) {
            if (!in_array($vehicle->vector, $completedVetors)) {
                $vectorVegicles = Vehicle::select('vector', 'timestamp')
                    ->where('vector', $vehicle->vector)
                    ->orderBy('timestamp')
                    ->get();
                
                $firstDate = new Carbon($vectorVegicles->first()->timestamp);
                $lastDate = new Carbon($vectorVegicles->last()->timestamp);
                
                $diffInSeconds = $lastDate->diffInSeconds($firstDate);
                $lifeTimes[] = [
                    'vector' => $vehicle->vector,
                    'time' => $diffInSeconds,
                ];

                $completedVetors[] = $vehicle->vector;
            } else {
                continue;
            }
        }

        return $lifeTimes;
    }

    // public function placesBeen (Request $request)
    // {
    //     $validated = $request->validate([
    //         'vector' => 'sometimes'
    //     ]);
    //     if (!isset($validated['vector'])) {
    //         $completedVetors = [];

    //         foreach ($validated as $vehicle) {
    //             if (!in_array($vehicle->vector, $completedVetors)) {
    //                 $vectorVehicles = Vehicle::select('vector', 'timestamp')
    //                     ->where('vector', $vehicle->vector)
    //                     ->orderBy('timestamp')
    //                     ->get();

    //                 $lifeTimes[] = [
    //                     'vector' => $vehicle->vector,
    //                     'position' => $diffInSeconds,
    //                 ];
    
    //                 $completedVetors[] = $vehicle->vector;
    //             } else {
    //                 continue;
    //             }
    //         }
    //     } else {
    //         $vehicles = Vehicle::where('vector', 'LIKE', "%{$validated['vector']}%")
    //             ->select('vector', 'position')
    //             ->groupBy('vector', 'position')
    //             ->paginate(10);
    //     }

    //     return $vehicles;
    // }

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

    public function exportVehicleFilter() {
        return response()->json([
            'certificate_url' => URL::temporarySignedRoute('pdfExportVehicleFilter', now()->addMinutes(10)),
        ]);
    }

    public function pdfExportVehicleFilter() {
        $document = new PDF([
            'mode' => 'utf-8',
            'format' => 'A4',
            'margin_header' => '3',
            'margin_top' => '20',
            'margin_bottom' => '20',
            'margin_footer' => '2',
        ]);

        
        $document->SetTitle('Nosaukums');
        $document->WriteHTML(view('exports.vehicleFilter', [
            'vehicles' => Vehicle::all(),
        ]));
        return $document->Output('pdf.pdf', 'I');
    }

    public function exportAvgLifeTime() {
        return response()->json([
            'certificate_url' => URL::temporarySignedRoute('pdfExportAvgLifeTime', now()->addMinutes(10)),
        ]);
    }

    public function pdfExportAvgLifeTime() {
        $document = new PDF([
            'mode' => 'utf-8',
            'format' => 'A4',
            'margin_header' => '3',
            'margin_top' => '20',
            'margin_bottom' => '20',
            'margin_footer' => '2',
        ]);

        $completedVetors = [];
        $lifeTimes = [];
        $vehicles = Vehicle::all();

        foreach ($vehicles as $vehicle) {
            if (!in_array($vehicle->vector, $completedVetors)) {
                $vectorVegicles = Vehicle::select('vector', 'timestamp')
                    ->where('vector', $vehicle->vector)
                    ->orderBy('timestamp')
                    ->get();
                
                $firstDate = new Carbon($vectorVegicles->first()->timestamp);
                $lastDate = new Carbon($vectorVegicles->last()->timestamp);
                
                $diffInSeconds = $lastDate->diffInSeconds($firstDate);
                $lifeTimes[] = [
                    'vector' => $vehicle->vector,
                    'time' => $diffInSeconds,
                ];

                $vector[] = $vehicle->vector;
                $time[] = $diffInSeconds;

                $completedVetors[] = $vehicle->vector;
            } else {
                continue;
            }
        }


        $document->SetTitle('Nosaukums');
        $document->WriteHTML(view('exports.avgLifeTime', [
            'times' => $lifeTimes
        ]));
        return $document->Output('pdf.pdf', 'I');
    }
}