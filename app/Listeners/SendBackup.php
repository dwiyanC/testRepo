<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use App\Events\ItemAdded;
use App\InventoryBackup;
use Illuminate\Support\Facades\DB;


class SendBackup
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(ItemAdded $event)
    {
        $item = $event->item;
        try{
            $backup = new InventoryBackup();
            $backup->id = $item->id;
            $backup->unit_name = $item->unit_name;
            $backup->unit_type = $item->unit_type;
            $backup->unit_no = $item->unit_no;
            $backup->save();
        }catch(Exception $e){
            return back()->withError($e->getMessage())->withInput();
        }
        

    }
}
