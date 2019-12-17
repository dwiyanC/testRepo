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



        // $comment = DB::table('comments')
        //             -> where ('inventory_id', '=', $id);
        //print_r ($comment);
        // $comment -> comment = $request -> comment;
        // $comment -> save();

        // $inventory_id = $id;
        // echo "invent".$inventory_id;
        // echo $request -> comment;
        // $comment = Comment::find($inventory_id);
        // echo "\n $comment";
        // die;


        // $comment = Comment::find($inventory_id);
        // $comment -> comment = $request -> comment;
        // $comment-> save();

    }


    
}



        // $comments = DB::table('item_comments')
        //             -> where ('inventory2_id', '=', $id)
        //             -> get();
        
        // $items = Inventory2::find($id);
        // $details = [
        //         'item'=>$items,
        //         'comments'=>$comments, //in array, containing all column names and contents
        // ];

        // $details = DB::table('inventories')
        //             -> join('item_comments', 'inventory2_id', '=', 'id')
        //             -> select('inventories.unit_name', 'inventories.unit_type', 'inventories.unit_no',
        //                         'item_comments.inventory2_id', 'item_comments.comment', 'item_comments.created_at')
        //             -> where('invetory2_id', '=', $id)
        //             -> get();
        
        // $commentTest = Comment2::where('comment_id', 22)->first();
        // echo $commentTest->comment. "<br>";
        // echo "<pre>";
        // print_r($commentTest->inventory);
        // die;

        
        // if(Cache::has($details)){
        //     $details = Cache::get($details);
        //     echo 'loaded from cache';
        // }else{
        //     $items = Inventory2::find($id);
        //     $comments = $items->comments; //Relationship method comments in INventory2
        //     $details = [
        //         'item'=>$items,
        //         'comments'=>$comments, //in array, containing all column names and contents
        //          ];
        // }
        
        // echo '<pre>';
        // print_r (Cache::get($details));
        // die;
        
        // print_r($invs->unit_name);
        // die;
