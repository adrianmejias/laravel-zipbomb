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

    public function __construct($config)
    {
        $this->agents = $config->get('agents');
        $this->paths = $config->get('paths');
        $this->zip_bomb_file = $config->get('zip_bomb_file');
    }

    public function getAgents(): array
    {
        return $this->agents;
    }

    public function getPaths(): array
    {
        return $this->paths;
    }

    public function getZipBombFile(): string
    {
        return $this->zip_bomb_file;
    }

    public function getZipBombFileContent(): string
    {
        return File::get($this->zip_bomb_file);
    }

    public function getZipBombFileSize(): integer
    {
        return File::size($this->zip_bomb_file);
    }
}
