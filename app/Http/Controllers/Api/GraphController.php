<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\GraphRequest;
use App\Http\Resources\GraphResource;
use App\Models\Graph;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Spatie\FlareClient\Api;

class GraphController extends Controller
{
    public function index(): Graph
    {
        return GraphResource::collection(Graph::all());
    }

    public function mostVisitedTurns()
    {

    }
}
