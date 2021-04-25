<?php

namespace Tests;


class SizeFixture
{
    public int $width;
    public int $height;
    public string $title;
    public string $filename;
    public string $example_root;


    public function __construct($fixTure)
    {

        $this->width = $fixTure['width'];


        $this->height = $fixTure['height'];

        $this->filename = $fixTure['filename'];

        $this->example_root = $fixTure['example_root'];
        $this->title = $fixTure['title'] ?? 'file_iterator';
    }
};
