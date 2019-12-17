<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use App\Inventory2;
use App\Comment2;
use Illuminate\Support\Facades\Cache;
use Auth;


class detailController extends Controller
{
    function __construct(){
        $this->middleware('auth');
    }

    function showAction(Request $request, $id){

        
        $items = Inventory2::find($id); // new Invetory(); $items->find($id);
        $comments = $items->comments; //Relationship method comments in INventory2
        $carouselImages = $items->images;
        $mainImage = $items->mainImage;
        $details = [
            'item'=>$items,
            'comments'=>$comments, //in array, containing all column names and contents
            'image'=>$carouselImages,
            'mainImage'=>$mainImage,
        ];
        

        // dd($details);

        Cache::putMany($details, 15*60);
                    
        return view('detail', $details);
    }

    function addComment(Request $request){
        // get item id (inventory_id) => store to comments table
        if(Auth::check()){
            $this->validate($request, [
                'comment'=>'required'
            ]);
            
    
            Comment2::create([
                'inventory2_id'=>$request->itemID, //itemID is hidden form input in detail.blade
                'comment'=>$request->comment
            ]);

            return redirect('details/'.$request->itemID);

        }
        else{
            abort(403, 'unauthorized');
        }



    }


    
}


