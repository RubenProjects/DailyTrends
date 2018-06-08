<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Input;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;


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


    public function readFeeds(){
        $feeds = Feed::paginate(5);
     
        return view('home',array(
          'feeds'=> $feeds,
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