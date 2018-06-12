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
        $validateData = $this->validate($request, [
           'title' =>'required',
           'body' =>'required',
           'image' =>'required|image|size:5000',
           'source' => 'required',
           'publisher' =>'required'
       ]);
        

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
                    'error' => 'Error al subir el Feed'
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
        $new_feed = new Feed();
        $new_feed2 = new Feed();
        if($crawler->filter(".articulos_apertura > .articulos__interior")->first()->count()){
             $feed = $crawler->filter(".articulos_apertura > .articulos__interior")->first();

             //Filter to ElPais
            if($feed->filter(".articulo-titulo ")->count() && $feed->filter(" a ")->count() &&  $feed->filter(" img ")->count() && $feed->filter(".autor-texto ")->count()){

                $feed = $crawler->filter(".articulos_apertura > .articulos__interior")->first();
                $title = $feed->filter(".articulo-titulo")->first();
                if($feed->filter(".articulo-entradilla")->count()){
                    $body = $feed->filter(".articulo-entradilla");
                }
                $source = $feed->filter(" a ")->attr('href');
                $search =  strpos ( $source, "elpais");
                if(!$search){       
                    $source = "https://elpais.com" . $source;       
                }
                $image = $feed->filter("img")->attr("data-src");
                $publisher = $feed->filter(".autor-texto > span > a")->first();

                //Saving in entity feed
                $new_feed->title = $title->text();
                if($feed->filter(".articulo-entradilla")->count()){
                $new_feed->body = $body->text();
                }
                $new_feed->source = $source;
                $new_feed->publisher = $publisher->text();
                $new_feed->image = $image;

                $feed = Feed::where('title',$new_feed->title)->first();
                if(count($feed) == 0){
                $new_feed->save();
                }
            }else{
                return redirect()->route('home')->with(array(    
                   'error' => 'No se pudo actualizar El Pais'
                 )); 
            }  
               
        }else{
            return redirect()->route('home')->with(array(    
               'error' => 'No se pudo actualizar El Pais'
             )); 
        } 

        if($crawler2->filter(".voc-home-article")->first()->count()){
            $feed = $crawler2->filter(".voc-home-article")->first();
            if($feed->filter(".voc-title")->count() && $feed->filter(".voc-news-subtit  ")->count() && $feed->filter(" .voc-title > a ")->count() && ($feed->filter(" .voc-home-image > picture > a > img")->count() || $feed->filter(".voc-home-image >picture>a >.video-player")->attr("data-voc-video-player-poster"))  && $feed->filter(" .voc-author-2 > author > a" )->count()){

                //Filter to Las Provincias
               
                $title = $feed->filter(".voc-title");
                $body = $feed->filter(".voc-news-subtit")->first();
                $source = "http://www.lasprovincias.es";
                $source .= $feed ->filter(".voc-title > a ")->attr("href");
                // dd($feed->filter(".voc-home-image >picture>a")->html());
                if($feed->filter(".voc-home-image >picture >a > img")->count()){
                    $image = $feed->filter(".voc-home-image >picture >a > img")->attr("data-original");           
                }else{
                    $image = $feed->filter(".voc-home-image >picture>a >.video-player")->attr("data-voc-video-player-poster");
                }
                $publisher = $feed->filter(".voc-author-2 > author > a ");
                 
                //Saving in entity Feed 
                $new_feed2->title = $title->text();
                $new_feed2->body = $body->text();
                $new_feed2->source = $source;
                $new_feed2->publisher = $publisher->text();
                $new_feed2->image = $image;
                
                $feed2 = Feed::where('title',$new_feed2->title)->first();
                if(count($feed2) == 0){
                   $new_feed2->save();
                }
            }else{
                return redirect()->route('home')->with(array(
             
                    'error' => 'No se pudo actualizar Las Provincias'
                )); 
                }
        }else{
            return redirect()->route('home')->with(array(    
               'error' => 'No se pudo actualizar Las Provincias'
             )); 
        }     
  
        return redirect()->route('home')->with(array(
             
            'message' => 'Feed actualizado correctamente'
        ));                
    }
    

    public function editFeed($feed_id){
        //Search a feed with a particular id
        $feed = Feed::findOrFail($feed_id);
        
        return view('Feed.editFeed',array('feed' => $feed));   
    }


    public function updateFeed($feed_id, Request $request){
        //Search the id feed
        $feed = Feed::findOrFail($feed_id);
        //Updating the data
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
       //Search the id to delete()
        $feed = Feed::findorfail($feed_id);

       //Delete the image information
        Storage::disk('images')->delete($feed->image);

        //Delete de feed
        if($feed->delete()){

            $message = array( 'message' => 'Feed eliminado correctamente');

        }else{
            
            $message = array( 'message' => 'Error al borrar el feed');
        }

        return redirect()->route('home')->with($message);  
    }

}