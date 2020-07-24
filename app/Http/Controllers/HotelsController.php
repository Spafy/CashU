<?php
/* Hotels Controller  */
/**
 * return all data from hotel providers
 *
 * @author:Peter <peter.msgbox@gmail.com>
 *
 */
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use GuzzleHttp\Client;
use App\Repositories\HotelsRepository;
use Validator;

class HotelsController extends Controller
{
    /** @var hotelsRepo */
    private $hotelsRepository;

    public function __construct(HotelsRepository $hotelsRepo)
    {
        // init repo
        $this->hotelsRepository = $hotelsRepo;
    }

    // this dummy function to genreate data for best hotels
    public function bestHotels(request $request)
    {
        // validate to make sure no fields from repo missing in request
        $validation =  Validator::make($request->all(), $this->hotelsRepository->bestHotelsValidate);

        if ($validation->fails()) {
            $response['message'] = $validation->messages();
            return response()->json($response, 422);
        }

        $trimData= [] ;
        $data = $this->hotelsRepository->bestHotelsDummy ;
        // create collection to search inside arrays
        $collection = collect($data);
        foreach ($this->hotelsRepository->bestHotelsValidate as $key => $field) {
            if (isset($request->{$key})) {
                // create condition for every request field located in repo
                $collection=$collection->where(trim($key), trim($request->{$key}));
            }
        }
        
        $filterData = $collection->all() ;
        
        // strip dummy data and return only specific fields
        foreach ($filterData as $key => $row) {
            # code...
            $exceptKeys = array_diff_key($row, array_flip($this->hotelsRepository->bestHotelsResponse));
            $trimData[]= array_diff_key($row, $exceptKeys);
        }

        $response= ['data'=> $trimData] ;
        return response()->json($response, 200);
    }

    // this dummy function to genreate data for top hotels
    public function topHotels(request $request)
    {
        // validate to make sure no fields from repo missing in request
        $validation =  Validator::make($request->all(), $this->hotelsRepository->topHotelsValidate);

        if ($validation->fails()) {
            $response['message'] = $validation->messages();
            return response()->json($response, 422);
        }

        $trimData= [] ;
        $data = $this->hotelsRepository->topHotelsDummy ;
        // create collection to search inside arrays
        $collection = collect($data);
        foreach ($this->hotelsRepository->topHotelsValidate as $key => $field) {
            if (isset($request->{$key})) {
                // create condition for every request field located in repo
                $collection=$collection->where(trim($key), trim($request->{$key}));
            }
        }
        
        $filterData = $collection->all() ;
        // strip dummy data and return only specific fields

        foreach ($filterData as $key => $row) {
            # code...
            $exceptKeys = array_diff_key($row, array_flip($this->hotelsRepository->topHotelsResponse));
            $trimData[]= array_diff_key($row, $exceptKeys);
        }

        $response= ['data'=> $trimData] ;
        return response()->json($response, 200);
    }

    public function get(request $request)
    {
        $client = new Client();
        $requstData = $request->all() ;
        $responseHotels = [] ;
        // validate to make sure no fields from repo missing in request
        $validation =  Validator::make($request->all(), $this->hotelsRepository->ourHotelsValidate);
        // check if fail to get required fields
        if ($validation->fails()) {
            $response['message'] = $validation->messages();
            return response()->json($response, 422);
        }

        // loop on providers located in repo
        foreach ($this->hotelsRepository->providers as $key => $provider) {
            $providerRequestdata=[] ;
            // replace our request keys to provider keys
            foreach ($requstData as $key2=>$requestData) {
                if (isset($provider['columns'][$key2])) {
                    $providerRequestdata[$provider['columns'][$key2]] = $requestData ;
                }
            }

            // replace port 8000 by 8001 to avoid any conflict or bug on local host
            $url = str_replace('8000', '8001', url($provider['url']));
            // send request
            $res = $client->post($url, [
                'headers' => ['Content-Type' => 'application/json'],
                'body' => json_encode($providerRequestdata)
            ]);
            
            if ($res->getStatusCode() == 200) {
                $responseProvider= json_decode($res->getBody()->getContents()) ;
                foreach ($responseProvider->data as $keyHotel => $hotel) {
                    # code...
                    // loop in provider data
                    $hotelArr= (array)$hotel;
                    $stripHotelArr= [] ;
                    $stripHotelArr['provider']=$provider['name'] ;
                    // extract response fields and replace keys with our keys
                    foreach ($provider['responseFields'] as $ourKey => $providerKey) {
                        if (isset($hotelArr[$providerKey])) {
                            // check if field separated by comma convert to array
                            if (is_string($hotelArr[$providerKey]) && strpos($hotelArr[$providerKey], ',') !== false) {
                                $hotelArr[$providerKey] = explode(',', $hotelArr[$providerKey]);
                            }
                            $stripHotelArr[$ourKey] = $hotelArr[$providerKey] ;
                        }
                    }

                    $responseHotels[]= $stripHotelArr ;
                }
            } else {
                // if provider api fail
                $response['message'] = 'Error on provider gateway!';
                return response()->json($response, 422);
            }
        }
        //send respose hotels
        $response['hotels'] = $responseHotels ;
        return response()->json($response, 200);
    }
}
