<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Input;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;
use Goutte\Client;

use App\Feed;

class FeedController extends Controller
{
    public function createFeed(){
        return view('Feed.createFeed');
    }

    public function saveFeed(Request $request){
        $feed = new Feed();
        $feed->title = $request->input('title');
        $feed->body = $request->input('body');
        $image = $request->file('image');
        if($image){
            $image_path = time().$image->getClientOriginalName();
            \Storage::disk('images')->put($image_path, \File::get($image));
         $feed->image = $image_path;
         }
         $feed->source = $request->input('source');
         $feed->publisher = $request->input('publisher');
         if($feed->save())
         {
             return redirect()->route('home')->with(array(
                    'message' => 'Feed subido correctamente'
         ));
         }else{
             return redirect()->route('home')->with(array(
                    'message' => 'Error al subir el Feed'
         ));
         }
           
    }

    public function index(){
        $feeds = Feed::orderBy('id','Desc')->paginate(5);

               return view('home',array(
                    'feeds'=> $feeds,
              ));
                
    }


    public function readFeeds(Client $client){
        $crawler = $client->request('GET', 'https://elpais.com/'); 
       $crawler2 = $client->request('GET', 'http://www.lasprovincias.es');

       $feed = $crawler->filter(".articulos_apertura > .articulos__interior")->first();
             $new_feed = new Feed();
             $new_feed2 = new Feed();


            $title = $feed->filter(".articulo-titulo")->first();
            // $body = $feed->filter(".foto-texto")->first();
            $source = "https://politica.elpais.com";
            $source .= $feed->filter(" a ")->attr('href');
            $image = $feed->filter("img")->attr("data-src");
                        

            $publisher = $feed->filter(".autor-texto > span > a")->first();

            $new_feed->title = $title->text();
            // $new_feed->body = $body->text();
            $new_feed->source = $source;
            $new_feed->publisher = $publisher->text();
            $new_feed->image = $image;
           

             $feed = $crawler2->filter(".voc-home-article")->first();
             $title = $feed->filter(".voc-title");
             $body = $feed->filter(".voc-news-subtit")->first();
             $source = "http://www.lasprovincias.es";
             $source .= $feed ->filter(".voc-title > a ")->attr("href");
             $image = $feed->filter(".voc-home-image >picture >a > img")->attr("data-original");
             
            $publisher = $feed->filter(".voc-author-2 > author > a ");
             
              $new_feed2->title = $title->text();
              $new_feed2->body = $body->text();
              $new_feed2->source = $source;
              $new_feed2->publisher = $publisher->text();
              $new_feed2->image = $image;

            $feed = Feed::where('title',$new_feed->title)->first();
               $feed2 = Feed::where('title',$new_feed2->title)->first();

               if(count($feed) == 0){
                 $new_feed->save();
               }

               if(count($feed2) == 0){
                $new_feed2->save();
               }

               $feeds = Feed::orderBy('id','Desc')->paginate(5);        
             
               return redirect()->route('home')->with(array(
                 
                 'message' => 'Feed actualizado correctamente'

         ));
                
    }

    
    
    public function editFeed($feed_id){
        $feed = Feed::findOrFail($feed_id);
        
          return view('Feed.editFeed',array('feed' => $feed));   
    }
    public function updateFeed($feed_id, Request $request){
        $feed = Feed::findOrFail($feed_id);
        
         $feed->title = $request->input('title');
         $feed->body = $request->input('body');
         $feed->source = $request->input('source');
         $feed->publisher = $request->input('publisher');
         $image = $request->file('image');

         if($image){
            $image_path = time().$image->getClientOriginalName();
            \Storage::disk('images')->put($image_path, \File::get($image));
         $feed->image = $image_path;
         }

         if($feed->update())
         {
             return redirect()->route('home')->with(array(
                    'message' => 'Feed actualizado correctamente'
         ));
         }else{
             return redirect()->route('home')->with(array(
                    'message' => 'Error al actualizar el Feed'
         ));
         }
         
          

    }

    public function deleteFeed($feed_id){
       $feed = Feed::findorfail($feed_id);
       Storage::disk('images')->delete($feed->image);
       if($feed->delete()){

         $message = array( 'message' => 'Feed eliminado correctamente');

        }else{
             $message = array( 'message' => 'Error al borrar el feed');
        }

         return redirect()->route('home')->with($message);

           
       }

}