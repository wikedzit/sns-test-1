<?php

namespace App\Http\Controllers;

use App\Models\Flipgrid;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;

class FlipgridController extends Controller
{
    protected $payload;

    public function  index() {
        $flipgrids = Flipgrid::orderBy('created_at','desc')->get();
        return view('flipgrids.index', [
            'flipgrids' => $flipgrids
        ]);
    }

    public  function create(Request $request) {
        try {
            return $this->processRequest($request);
        } catch (\Exception $e) {
            $fg = new Flipgrid;
            $fg->completedAt = '';
            $fg->fgResponseID = '';
            $fg->fgQuestionID = '';
            $fg->fgGridID = '';
            $fg->payload = $e->getMessage();
            $fg->save();
            return response()->json('Error'.$e->getMessage(), 500);
        }
    }

    public function processRequest(Request $request) {
        $this->payload = null;
        $payload = json_decode($request->getContent());
        if (empty($payload)) {
            return response()->json('Missing content', 200);
        }

        // Run this block to auto confirm AWS-SNS subscription
        if(property_exists($payload, 'Type') && $payload->Type === "SubscriptionConfirmation") {
            Http::get($payload->SubscribeURL);
            return response()->json( 'success', 200);
        }

        if(property_exists($payload, 'Message')) {
            $this->payload = json_decode($payload->Message);
            $fg = new Flipgrid;
            $fg->completedAt = '';
            $fg->fgResponseID = '';
            $fg->fgQuestionID = '';
            $fg->fgGridID = '';
            $fg->payload =json_encode($this->payload->content->data)."===";
            $fg->save();
            return ;

            if (!empty($this->payload) && property_exists($this->payload, 'content')) {
                $gridID = $this->payload->data->grid->id;
                $gid = intval($gridID);
                $fg = new Flipgrid;
                $fg->completedAt = Carbon::parse($this->payload->data->response->created_at)->toDateTimeString();
                $fg->fgResponseID = $this->payload->data->response->id;
                $fg->fgQuestionID = $this->payload->data->response->topic_id;
                $fg->fgGridID = $gridID;
                $fg->payload = $payload->Message;
                if ($gid % 2 == 0 && env('TYPE') == 'even') {
                    $fg->save();
                }
                if ($gid % 2 != 0 && env('TYPE') == 'odd') {
                    $fg->save();
                }

                return response()->json( 'Message received', 200);
            }
            return response()->json( 'Missing data payload', 200);
        }
        return response()->json('Warning, nothing happened', 200);
    }
}
