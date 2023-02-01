<?php
return [

    'BLUE_BUS_KEY' => env('BLUE_BUS_KEY', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwczovL3N0YWdpbmctYXBpLmJsdWVidXMuY29tLmVnL2FwaS9hZ2VudC9sb2dpbiIsImlhdCI6MTY2Njk2MjQzMywiZXhwIjo3NjY2OTYyNDMzLCJuYmYiOjE2NjY5NjI0MzMsImp0aSI6IlJicTZFc242d1oxeWNlVDciLCJzdWIiOjUsInBydiI6IjQyZWRlMzMzNGEwNGNkNjVjYjJiZTNmNWFkZmViMmMxZWRkMzA3NzQifQ.IjYOSQ6V5GwTPedyCn5u3jxN_2llYwJexPVfMiFcaHo'),
    'BLUE_BUS_LOCATION' => env('BLUE_BUS_LOCATION', 'https://staging-api.bluebus.com.eg/api/agent/locations'),
    'BLUE_BUS_SEARCH_TRIP' => env('BLUE_BUS_SEARCH_TRIP', 'https://staging-api.bluebus.com.eg/api/agent/search-trip'),
    'BLUE_BUS_CREATE_ORDER' => env('BLUE_BUS_CREATE_ORDER', 'https://staging-api.bluebus.com.eg/api/agent/create-order'),
    'BLUE_BUS_AVAILABLE_SEATS' => env('BLUE_BUS_AVAILABLE_SEATS', 'https://staging-api.bluebus.com.eg/api/agent/trip-available-seats'),
    'WE_BUS_LOCATION' => env('WE_BUS_LOCATION', 'https://demo.webusegypt.com/api/cities'),
    'WE_BUS_SEARCH_TRIP' => env('WE_BUS_SEARCH_TRIP', 'https://demo.webusegypt.com/api/search'),
    'TAZCARA_LOCATION' => env('TAZCARA_LOCATION', 'https://d-bus.otobeas.com/mob/search/data'),
    'TAZCARA_SEARCH_TRIP' => env('TAZCARA_SEARCH_TRIP', 'https://d-bus.otobeas.com/mob/:accessCode/:accessId/002/search/:from/:to/:date/:company/:number_of_seats/:round/:backdate/:timeStamp'),

];
