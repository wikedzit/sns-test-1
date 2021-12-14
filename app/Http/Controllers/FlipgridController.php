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

        $payload = json_decode($request->getContent());
        if(property_exists($payload, 'Type')) {
            if($payload->Type === "SubscriptionConfirmation") {
                $confirmation_url = curl_init($payload->SubscribeURL);
                curl_exec($confirmation_url);
            }
            return response()->json( 'success', 200);
        }

        try {
            $fg = new Flipgrid;
            $fg->grid_id = 1;
            $fg->topic_id = 1;
            $fg->payload = json_encode($request->getContent());
            $fg->save();
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
