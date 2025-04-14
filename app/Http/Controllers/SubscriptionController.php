<?php

namespace App\Http\Controllers;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Models\Vendor;
use GuzzleHttp\Client;
use Config;
use Exception;
class SubscriptionController extends Controller
{

    public function getSubscription($vendorId)
    {
        $validator = Validator::make(['vendorId' => $vendorId], [
            'vendorId' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        try {
            $subscription = Subscription::where('vendor_id', $vendorId)
                ->where('islatest', 1)
                ->select('start_date', 'duration_in_months', 'isactive','version','is_trial')
                ->first();
            if ($subscription) {
                return response()->json($subscription, 200);
            } else {
                return response()->json(null, 200);
            }
        } catch (Exception $e) {
            return response()->json('{}', 200);
        }
    }

    public function storeSubscription(Request $request)
    {
        $requestData = $request->all();

        $validator = Validator::make($requestData, [
            'vendorId' => 'required|integer',
            'start_date' => 'required|date',
            'duration' => 'required|integer',
            'status' => 'required|int'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }
        try {
            $vendorId = (int) $requestData['vendorId'];
            $durationInMonths = (int) $requestData['duration'];
            $end_date = Carbon::parse($requestData['start_date'])->subDay()->addMonthNoOverflow($durationInMonths)->format('Y-m-d');
            $version  = (int) $requestData['version'];
            $is_trial = (int) $requestData['is_trial'];
            Subscription::where('vendor_id', $vendorId)
                ->where('islatest', 1)
                ->update(['islatest' => 0]);


            // $lastVersion = Subscription::where('vendor_id', $vendorId)
            //     ->orderByDesc('version')
            //     ->value('version');

            $user_uid = (int) Vendor::where('vendor_id', $vendorId)->value('user_uid');

            $subscription = new Subscription();
            $subscription->vendor_id = $vendorId;
            $subscription->duration_in_months = $durationInMonths;
            $subscription->version = $version ? $version + 1 : 1;
            $subscription->islatest = 1;
            $subscription->start_date = $requestData['start_date'];
            $subscription->end_date = $end_date;
            $subscription->isactive = (int)$requestData['status'];
            $subscription->is_trial = (int)$requestData['is_trial'];
            $subscription->save();

            $client = new Client;
            $url = Config::get('constants.API_URL').'UpdateUser1?id='.$user_uid ;
            $request =  $client->request('PATCH',  $url, [
                'headers' => ['Content-Type' => 'application/json'],
                'body' => json_encode([
                    'Start_Date' => $requestData['start_date'],
                    'End_Date' => $end_date,
                    'is_active' =>  $subscription->isactive,
                    "is_trial" => $subscription->is_trial,
                ])
            ]);

            $request->getBody()->getContents();
        
            if ($request->getStatusCode() == 200) {
                return response()->json(['message' => 'Subscription created successfully'], 200);
            } else {
                return response()->json(['message' => 'Subscription creation failed'], 400);
            }
        } catch (Exception $e) {
            echo $e;
            return response()->json(['message' => $e], 404);
        }
    }
}
