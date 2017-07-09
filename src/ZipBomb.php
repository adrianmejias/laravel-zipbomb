<?php

namespace AdrianMejias\ZipBomb;

use Illuminate\Support\Facades\File;

class ZipBomb
{
    /** @var array */
    protected $agents;

    /** @var array */
    protected $paths;

    /** @var string */
    protected $zip_bomb_file;

    public function __construct(array $config)
    {
        $this->agents = $config['agents'];
        $this->paths = $config['paths'];
        $this->zip_bomb_file = $config['zip_bomb_file'];
    }

    public function getAgents(): array
    {
        return $this->agents;
    }

    public function getPaths(): array
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
