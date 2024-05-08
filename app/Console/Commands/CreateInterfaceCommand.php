<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateInterfaceCommand extends FileFactoryCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:interface {classname}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    function setStubName():string {
        return "Interface";


    }
     function setFilepath():string {
        return "App\\Interfaces\\";

    }
     function setSuffix():string {
        return "Service";
    }

}
