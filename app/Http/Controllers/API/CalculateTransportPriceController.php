<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Validator;

class CalculateTransportPriceController extends BaseController
{


    public function calculatePrice(Request $request): JsonResponse
    {
        // Validation For Requested User Data. Here I do 2 types of route_type and based on route_type transport_type will be as mention on the assignment.
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|integer',
            'route_type' => 'required|string|in:road,sea',
            'transport_type' => [
                'required',
                'string',
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->route_type === 'road' && !in_array(strtolower($value),['car', 'truck', 'lorry'])) {
                        $fail('When the route type is "road," the transport type must be one of: car, truck, lorry.');
                    }
                    if ($request->route_type === 'sea' && !in_array(strtolower($value), ['boat', 'ship', 'speed boat'])) {
                        $fail('When the route type is "sea," the transport type must be one of: boat, ship, speed boat.');
                    }
                },
            ],
            'distance' => 'required|integer',
        ]);
     
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        };
    
        // assign the common variable
        $distance = $request->distance;
        $transport_type = strtolower($request->transport_type);
        $price = 0;
        $TransportFare = 0;
    
        // Calculate the price for road transport
        if ($request->route_type === 'road') {

            // here i hard code the price of transport type
            $road_transport_type = [
                'car' => 0.1,
                'truck' => 0.2,
                'lorry' => 0.3
            ];

            
            if (array_key_exists($transport_type, $road_transport_type)) {
                $TransportFare = $road_transport_type[$transport_type];
            } else {
                return $this->notFoundError('Transport type not match');
            }

            $price = $distance * $TransportFare;
        }
    
        // Calculate the price for sea transport
        if ($request->route_type === 'sea') {

            // here i hard code the price of transport type
            $sea_transport_type = [
                'boat' => 0.4,
                'ship' => 0.9,
                'speed boat' => 0.5
            ];

            $TransportFare = 0;

            if (array_key_exists($transport_type, $sea_transport_type)) {
                $TransportFare = $sea_transport_type[$transport_type];
            } else {
                return $this->notFoundError('Transport type not match');
            }

            $price = $distance * $TransportFare;
        }

        // Calculate the price for air transport 

        // NB:: Now Comment this part if we need transport type air then Comment out this code and use route_type Validation

        // if ($request->route_type === 'air') {
        //     $price = $distance * 0.3;
        // }
    
        // Return the price
        $response = [
            'success' => true,
            'price'    => $price,
            'message' => 'Transport Price Calculate Successfully!',
        ];
        return response()->json($response, 200);
    }
}
