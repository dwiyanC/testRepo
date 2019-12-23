<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Inventory2;
use App\InventoryBackup;
use App\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Exception;

use App\Events\ItemAdded;
use App\Events\ItemRemoved;

class indexController extends Controller
{

    function __construct(){

        $this->middleware('auth');
    }

    // get items from DB
    public function listItems(){
        
        $items = Inventory2::all();
        // $items = Inventory2::paginate(20);
        
        return view('index', ['items' =>$items]);
        // return view('index');
        
        //using cache for item list

        // $items = Cache::remember('itemList', 10, function(){
        //     return Inventory2::all(); 
        //    //return Inventory2::paginate(10);
        // });
        // if(Cache::has('itemList')){
        //     // $items = Cache::get('itemList');
        //     return view('index', ['items' =>$items]);
        // }

    }

    public function addAction(){
        // $this->middleware('auth.role:admin');
        $itemCategories = Category::all();
        return view('actions.add', ['itemCategories' => $itemCategories]);
        // return view('actions.add');
    }

    protected function itemStore(Request $request){        

        // $this->validate($request, [
        //     'unit_name' => 'required',
        //     'unit_type' => 'required',
        //     'UNIT_NUMBER' => 'required|numeric'  // 'value' => .... , value responds to name on form's field
        // ]);

        $rules = [
            'unit_name'=>'required|min:5',
            'unit_type'=>'required',
            'UNIT_NUMBER'=>'required|numeric' 
        ];

        $errorMessage = [
            'required'=>'Tidak Boleh Kosong',
            'numeric'=>'Harus Berisi Angka',
            'min'=>'minimum 5 karakter'
        ];

        $this->validate($request, $rules, $errorMessage);

        try{
            $item = Inventory2::create([    //$inventory = new Inventory2()
                'unit_name'=>$request->unit_name,  // $inventory->unit_name = $request=>unit_name;
                'unit_type'=>$request->unit_type,
                'unit_no'=>$request->UNIT_NUMBER // 'column name' => request (value of fields' name)
            ]);
            // $item = new Inventory2();
            // $item->unit_name = $request->unit_name;
            // $item->unit_type = $request->unit_type;
            // $item->unit_no = $request->UNIT_NUMBER;
            // $item->save();
            
        }catch (Exception $e){
            // return back()->withError($e->getMessage())->withInput();
            return back()->withError($e->getMessage())->withInput();
        }
        event(new ItemAdded($item));
        return redirect('/');

    }

    protected function deleteAction(Request $request, $id){
        try{
            $this->authorize('isAdmin');
            $item = Inventory2::findOrFail($id);
            $item-> delete();

            //change active status in backup
            // make this an event (event DeletedItem and add LogEvent with email)
            //$itemBackup = InventoryBackup::findOrFail($id);

            $activeStatus = InventoryBackup::findOrFail($id);
            event(new ItemRemoved($activeStatus));

            // $activeStatus->active = 0;
            // $activeStatus->save();

            return redirect('/');
        }catch(Exception $e){
            return redirect('/')->withError($e->getMessage())->withInput();
        }

        // if (Gate::allows('isAdmin')){
        //     $item = Inventory::findOrFail($id);
        //     $item-> delete();
        //     return redirect('/');
        // }else{
        //     echo 'not allowed to do this';
        // }
    }

    protected function editAction(Request $request, $id){
        if(Gate::allows('isUser')){         //if logged in as user do { this logic }
            echo 'you are not allowed here';
        }else{
            $item = Inventory2::findOrFail($id);
            $itemCategories = Category::all();
            $data = [
                    'item' => $item,
                    'itemCategories' => $itemCategories,
            ];
            return view('actions.edit', $data);
        }
        
    }

    protected function update(Request $request, $id){

        $rules = [
            'unit_name'=>'required|min:5',
            'unit_type'=>'required',
            'unit_no'=>'required|numeric' 
        ];

        $errorMessage = [
            'required'=>'Tidak Boleh Kosong',
            'numeric'=>'Harus Berisi Angka',
            'min'=>'minimum 5 karakter'
        ];

        $this->validate($request, $rules, $errorMessage);
        try{
            $item = Inventory2::find($id);
            $item -> unit_name = $request -> unit_name;
            $item -> unit_type = $request -> unit_type;
            $item -> unit_no   = $request -> unit_no;
            $item -> save();
        }catch(Exception $e){
            return redirect('edit/'.$id)->withError($e->getMessage())->withInput();
        }
        return redirect('/');
    }

    function mockUpForPullReq(){
        $f = 'test for branch';
        echo $f;
    }
}
