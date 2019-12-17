<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


use App\ItemImage;

class imageController extends Controller
{


    function addMainImage(Request $request, $id){
        $rules = [
            'unit_image'=>'required|file|image|mimes:png,jpg,jpeg|max:2048'
        ];

        // echo '<pre>';
        // print_r($request->all());
        // die;

        $file = $request->file('unit_image');

        // $filename = 'item_'.$id.'MainImage.'.$file->getClientOriginalExtension();
        $filename = 'item_'.$id.'MainImage.'.$file->getClientOriginalExtension();

        $this->validate($request, $rules);
        $isMainImage = true;

        // $nameCheck = explode(".",$filename);
        $record = ItemImage::where([
            ['inventory2_id', $id],
            ['main_image', $isMainImage],
            ]);
            
       // $recordName = explode(".",$record->image_name);


        if($record == !NULL){     
            //kalo udah ada di record -> update file, update name
            // file in storage is automatically override if file is inputted with name of existing one, hence no delete function for storage
            // if ($nameCheck[0] === $recordName[0]){
            $file->storeAs('public/itemImages', $filename); // store in storage/public/itemImages
            ItemImage::create([
                'inventory2_id'=>$id,
                'image_name'=>$filename,
                'main_image'=>1,
            ]);
            return redirect('details/'.$id);
                //for updating main image
        }
    }

    function updateMainImage(Request $request, $id){
        $rules = [
            'unit_image'=>'required|file|image|mimes:png,jpg,jpeg|max:2048'
        ];
        $file = $request->file('unit_image');
        $filename = 'item_'.$id.'MainImage.'.$file->getClientOriginalExtension();

        $this->validate($request, $rules);
        $isMainImage = true;

        $record = ItemImage::where([
            ['inventory2_id', $id],
            ['main_image', $isMainImage],
            ]);

        if($record == !NULL){     
            ItemImage::where([
                ['inventory2_id', $id],
                ['main_image', $isMainImage],
                ])->update([
                'image_name' => $filename,
                'updated_at'=>now(),
            ]);
        $file->storeAs('public/itemImages', $filename); // store in storage/public/itemImages
        return back();

        }
    }

    // function showCarouselForm(Request $request){
    //     return view('actions.carouselForm', ['id'=>$request->id]);
    // }

    function addCarouselImage(Request $request, $id){
        $request->validate([
            'carousel_images'=>'required',
            'carousel_images.*'=>'file|image|mimes:png,jpg,jpeg'

        ]);
        // $this->validate($request, $rules);

        $count = count($request->carousel_images);

        if($images = $request->file('carousel_images')){    
            $i = 1;
            foreach($images as $image){
                $filename = 'item_'.$id.'carouselImage'.$i.".".$image->getClientOriginalExtension();
                $image->storeAs('/public/itemimages', $filename);
                // $insert[]['image_name']=$filename;
                $i++;
                $dataset[]= [
                    'inventory2_id'=>$id,
                    'image_name'=>$filename,
                    'created_at'=> now(),
                ];
            }
        }
        // dd($insert);
        $push = ItemImage::insert($dataset);
        return redirect('details/'.$id);
    }
}