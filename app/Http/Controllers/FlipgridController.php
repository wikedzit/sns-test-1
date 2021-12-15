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
        try {
            $payload = json_decode($request->getContent());
            if (empty($payload)) {
                return response()->json('Missing content', 200);
            }

            if(property_exists($payload, 'Type') &&
                $payload->Type === "SubscriptionConfirmation") {
                $confirmation_url = curl_init($payload->SubscribeURL);
                curl_exec($confirmation_url);
                return response()->json( 'success', 200);
            }
            if(property_exists($payload, 'Message')) {
                $data = json_decode($payload->Message);
                $fg = new Flipgrid;
                $fg->grid_id = $data->grid_id;
                $fg->topic_id = $data->topic_id;
                $fg->payload = json_encode($request->getContent());
                $fg->save();
                return response()->json( 'Message received', 200);
            }
        } catch (\Exception $e) {
            $fg = new Flipgrid;
            $fg->grid_id = 1;
            $fg->topic_id = 1;
            $fg->payload = json_encode($e->getMessage());
            $fg->save();
            return response()->json('Error'.$e->getMessage(), 500);
        }
        return response()->json('Warning, nothing happened', 200);
    }

    public function getConfirmation() {
        $data = File::get('confirmation.txt');
        return response()->json($data, 200);
    }
}
