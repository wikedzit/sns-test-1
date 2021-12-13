<?php

namespace App\Http\Controllers;

use App\Models\Flipgrid;
use Illuminate\Http\Request;

class FlipgridController extends Controller
{
    public function  index() {
        $flipgrids = Flipgrid::all();
        return view('flipgrids.index', [
            'flipgrids' => $flipgrids
        ]);
    }
    public  function create(Request $request) {
        $grid_id = $request->grid_id;
        $topic_id = $request->topic_id;
        try {
            $fg = Flipgrid::firstOrCreate([
                'grid_id' => $grid_id,
                'topic_id' => $topic_id
            ]);
            return response()->json("Success", 200);
        } catch (\Exception $e) {
            return response()->json('Error'.$e->getMessage(), 500);
        }
    }
}
