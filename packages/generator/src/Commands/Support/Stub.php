<?php

namespace Rahel\Generator\Commands\Support;

class Stub
{
    /**
     * The stub path.
     *
     * @var string
     */
    protected $path;

    /**
     * The path where the file will saved.
     * @var null|string
     */
    protected $destination = null;

    /**
     * The constructor.
     *
     * @param string $path
     * @param array  $replaces
     */
    public function __construct(string $path, string $destination)
    {
        $this->path        = $path;
        $this->destination = $destination;
    }

    /**
     * call constructor for this class
     * @param string $path
     * @param string $destination
     * @return static
     */
    public static function create(string $path, string $destination)
    {
        return new static($path, $destination);
    }

    /**
     * Get stub path.
     *
     * @return string
     */
    public function getPath()
    {
        return __DIR__ . '/../stubs/' . $this->path;
    }

    /**
     * Get stub contents.
     *
     * @return mixed|string
     */
    public function getContents()
    {
        $contents = file_get_contents($this->getPath());

        return $contents;
    }

    /**
     * Save stub to specific path.
     *
     * @param string $path
     * @param string $filename
     *
     * @return bool
     */
    public function saveTo($filename, $contents)
    {
        if (!file_exists(base_path($this->destination))) {
            mkdir(base_path($this->destination));
        }

        return file_put_contents(base_path($this->destination) . '/' . $filename, $contents);
    }
}
