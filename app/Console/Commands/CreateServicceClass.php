<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Pluralizer;
use Illuminate\Filesystem\Filesystem;

class CreateServicceClass extends FileFactoryCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:service {classname}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'this command for create service class pattern';

     function setStubName():string {
        return "servicepattern";

    }
     function setFilepath():string {
        return "App\\Services\\";

    }
     function setSuffix():string {
        return "Service";
    }

}

