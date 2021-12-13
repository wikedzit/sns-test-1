<?php

namespace App\Http\Controllers;

use App\Models\Flipgrid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

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

        if (empty($grid_id) || empty($topic_id)) {
            $payload = json_decode($request->getContent());
            if(property_exists($payload, 'Type')) {
                if($payload->Type === "SubscriptionConfirmation") {
                    $confirmation_url = curl_init($payload->SubscribeURL);
                    curl_exec($confirmation_url);
                }
            }
            File::put('confirmation.txt', json_encode($request->getContent()));
            return response()->json( config('sns-response.data'), 200);
        }

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

    public function getConfirmation() {
        $data = File::get('confirmation.txt');
        return response()->json($data, 200);
    }
}
