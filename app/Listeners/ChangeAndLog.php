<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use App\Events\ItemRemoved;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;


class ChangeAndLog
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
    public function handle(ItemRemoved $event)
    {
        $item = $event->item;       //item is instance of InventoryBsackup?
        $item->active = 0;
        $item->save();

        Log::channel('custom-log')->alert(Cache::get('userMail').' deleted '.$item->unit_name .' at '.$item->updated_at);

    }
}
