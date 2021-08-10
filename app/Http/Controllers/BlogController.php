<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use jcobhams\NewsApi\NewsApi;
use GuzzleHttp\Client;

class BlogController extends Controller
{
    
    public function getNewsApi(){

        $client = new Client([
            'base_uri' => 'https://newsapi.org/v2/top-headlines?country=us&apiKey=c6dcf6344ad34f25957363f387d8a8bc&pageSize=10', 
            'timeout' => 2.0,
            'page' => 10,
        ]);

        //dd($client);
    
        $response = $client->request('GET', 'https://newsapi.org/v2/top-headlines?country=us&apiKey=c6dcf6344ad34f25957363f387d8a8bc&pageSize=10');
        $posts = json_decode($response->getBody()->getContents());
        $results = $posts->articles;
        //dd($results);


        foreach($results as $result){
            $client_two = new Client([
                'base_uri' => 'https://randomuser.me/api/', 
                'timeout' => 2.0,
            ]);
        
            $response = $client_two->request('GET', 'https://randomuser.me/api/');
            $authors = json_decode($response->getBody()->getContents());
            //dd($authors->results);

            $full_name = $authors->results[0]->name->first . " " . $authors->results[0]->name->last;
            //dd($full_name);

            $result->author = $full_name;

        }


        return view('welcome', compact('results'));

    }





}
