<?php

namespace Spatie\Referer;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ZipBomb
{
    /** @var Array */
    protected $agents;

    /** @var Array */
    protected $paths;

    /** @var String */
    protected $zip_bomb_file;

    public function __construct(Array $config)
    {
        $this->agents        = $config['agents'];
        $this->paths         = $config['paths'];
        $this->zip_bomb_file = $config'zip_bomb_file'];
    }

    public function getAgents(): Array
    {
        return $this->agents;
    }

    public function getPaths(): Array
    {
        return $this->paths;
    }

    public function getZipBombFile(): String
    {
        return $this->zip_bomb_file;
    }

    public function getZipBombFileContent(): String
    {
        return File::get($this->zip_bomb_file);
    }

    public function getZipBombFileSize(): Integer
    {
        return File::size($this->zip_bomb_file);
    }

}