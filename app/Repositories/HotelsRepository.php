<?php
namespace App\Repositories;

class HotelsRepository
{
    // validation fields for our hotels 
    public $ourHotelsValidate= [
        'from_date' => 'required',
        'to_date' => 'required',
        'city'=>'required',
        'adults_number'=>'required'
    ];
    // validation fields for best hotels
    public $bestHotelsValidate= [
        'fromDate' => 'required',
        'toDate' => 'required',
        'city'=>'required',
        'numberOfAdults'=>'required'
    ] ;
    // response array for best hotels
    public $bestHotelsResponse= [
        'hotel',
        'hotelRate',
        'hotelFare',
        'roomAmenities'
    ] ;
    // validation fields for top hotels
    public $topHotelsValidate= [
        'from' => 'required',
        'to' => 'required',
        'city'=>'required',
        'adultsCount'=>'required'
    ] ;
    // response array for top hotels
    public $topHotelsResponse= [
        'hotelName',
        'rate',
        'price',
        'amenities',
        'discount'
    ] ;
    // dummy data for besthotels 
    public $bestHotelsDummy= [
            ['hotel'=>'Hotel 1', 'fromDate'=>'2020-7-03','toDate'=>'2020-7-23', 'city'=>'AUH', 'numberOfAdults' =>3, 'hotelFare'=>'97$', 'roomAmenities'=>'tv,Air Condtion,Sea View','hotelRate'=>4],
            ['hotel'=>'Hotel 99', 'fromDate'=>'2020-7-03','toDate'=>'2020-7-23', 'city'=>'AUH', 'numberOfAdults' =>3, 'hotelFare'=>'23$', 'roomAmenities'=>'tv,Air Condtion,Fridge','hotelRate'=>4],

            ['hotel'=>'Hotel 2', 'fromDate'=>'2020-8-03','toDate'=>'2020-8-23', 'city'=>'AUH', 'numberOfAdults' =>2, 'hotelFare'=>'44$', 'roomAmenities'=>'tv,Air Condtion,Sea View','hotelRate'=>5],
            ['hotel'=>'Hotel 3', 'fromDate'=>'2020-9-03','toDate'=>'2020-9-23', 'city'=>'AUH', 'numberOfAdults' =>2, 'hotelFare'=>'77$', 'roomAmenities'=>'tv,Air Condtion','hotelRate'=>2]
        ];
    // dummy data for tophotels 
        public $topHotelsDummy= [
            ['hotelName'=>'Hotel top 1', 'from'=>'2020-7-03', 'discount'=>'30%', 'to'=>'2020-7-23', 'city'=>'AUH', 'adultsCount' =>3, 'price'=>'64$', 'amenities'=>['tv','Air Condtion','Sea View'],'rate'=>4],
            ['hotelName'=>'Hotel top 99', 'from'=>'2020-7-03','to'=>'2020-7-23', 'discount'=>'40%', 'city'=>'AUH', 'adultsCount' =>3, 'price'=>'52$', 'amenities'=>['tv','Air Condtion','Sea View'],'rate'=>4],

            ['hotelName'=>'Hotel top 2', 'from'=>'2020-8-03','to'=>'2020-8-23', 'city'=>'AUH', 'discount'=>'80%', 'adultsCount' =>2, 'price'=>'49$', 'amenities'=>['tv','Air Condtion'],'rate'=>5],
            ['hotelName'=>'Hotel top 3', 'from'=>'2020-9-03','to'=>'2020-9-23', 'city'=>'AUH', 'discount'=>'90%', 'adultsCount' =>2, 'price'=>'38$', 'amenities'=>['tv','Air Condtion','Sea View'],'rate'=>2]
        ];
    // providers data that contais api columns and response keys 
    public $providers = [
        'BestHotels'=>[
        'name'=>'BestHotels Provider',
        'url'=>'/bestHotels',
        'columns'=>[
            'from_date'=>'fromDate',
            'to_date'=>'toDate',
            'city'=>'city',
            'adults_number'=>'numberOfAdults'
        ],
        'responseFields'=>[
            'hotelName'=>'hotel',
            'fare'=>'hotelFare',
            'amenities'=>'roomAmenities'
        ]
        ],
        'TopHotels'=>[
            'name'=>'TopHotels Provider',
            'url'=>'/topHotels',
            'columns'=>[
                'from_date'=>'from',
                'to_date'=>'to',
                'city'=>'city',
                'adults_number'=>'adultsCount'
            ],
            'responseFields'=>[
                'hotelName'=>'hotelName',
                'fare'=>'price',
                'amenities'=>'amenities'
            ]
            ], 
        
    ];
}
