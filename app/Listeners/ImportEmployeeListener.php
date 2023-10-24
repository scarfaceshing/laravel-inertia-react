<?php

namespace App\Listeners;

use App\Events\ImportEmployeesEvent;

class ImportEmployeeListener
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
    public function handle(ImportEmployeesEvent $event)
    {
        //

        return $event;
    }
}
