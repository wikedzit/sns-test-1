<?php

namespace App\Http\Controllers;

use App\Models\Flipgrid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;

class FlipgridController extends Controller
{
    protected $payload;

    public function  index() {
        $flipgrids = Flipgrid::all();
        return view('flipgrids.index', [
            'flipgrids' => $flipgrids
        ]);
    }

    public  function create(Request $request) {
        try {
            return $this->processRequest($request);
        } catch (\Exception $e) {
            return response()->json('Error'.$e->getMessage(), 500);
        }
    }

    public function processRequest(Request $request) {
        $this->payload = null;
        $payload = json_decode($request->getContent());
        if (empty($payload)) {
            return response()->json('Missing content', 200);
        }

        if(property_exists($payload, 'Type') && $payload->Type === "SubscriptionConfirmation") {
            Http::get($payload->SubscribeURL);
            //$confirmation_url = curl_init($payload->SubscribeURL);
            //curl_exec($confirmation_url);
            return response()->json( 'success', 200);
        }

        if(property_exists($payload, 'Message')) {
            $this->payload = json_decode($payload->Message);
            $fg = new Flipgrid;
            $fg->grid_id = $this->payload->grid_id;
            $fg->topic_id = $this->payload->topic_id;
            $fg->payload = json_encode($payload->Message);
            $fg->save();
            return response()->json( 'Message received', 200);
        }
        return response()->json('Warning, nothing happened', 200);
    }
}
