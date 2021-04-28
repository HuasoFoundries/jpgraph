<?php

/**
 * JPGraph - Community Edition
 */

namespace Tests;

class SizeFixture
{
    const NEVER_SAVE_CAPTURE = 0;
    const SAVE_CAPTURE_IF_NOT_EXISTS = 1;
    const ALWAYS_SAVE_CAPTURE = 2;

    public $width;

    public $height;

    public string $title;

    public string $filename;

    public string $example_root;

    public function __construct($fixTure)
    {
        $this->width = $fixTure['width'] ?? null;

        $this->height = $fixTure['height'] ?? null;

        $this->filename = $fixTure['filename'];

        $this->example_root = $fixTure['example_root'];
        $this->title = $fixTure['title'] ?? 'file_iterator';
    }

    public function hasDimensions()
    {
        return null !== $this->width && null !== $this->height;
    }

    /**
     * Grab the actual output of an example / fixture as a string.
     *
     * @return false|string
     */
    public function captureImage(int $saveToFileSystem = self::NEVER_SAVE_CAPTURE)
    {
        $example_filename = \implode('/', [$this->example_root, $this->filename]);
        $example_fullpath = examples_path($example_filename);

        if (!\is_readable($example_fullpath)) {
            BaseTestCase::line(\sprintf('example %s is not readable or does not exist', $example_filename), 'warn');

            return '';
        }
        \ob_start();

        include $example_fullpath;
        $img = (\ob_get_clean());

        return tap($img, function (string $img) use ($saveToFileSystem) {
            $size = \getimagesizefromstring($img);
            tap(
                $this->computeSnapshotPath($size, true),
                function ($snapshotPath) use ($img, $saveToFileSystem) {
                    if (self::ALWAYS_SAVE_CAPTURE === $saveToFileSystem || (!\is_file($snapshotPath) && !\is_link($snapshotPath) && self::SAVE_CAPTURE_IF_NOT_EXISTS === $saveToFileSystem)) {
                        \file_put_contents($snapshotPath, $img);
                    }
                }
            );
        });
    }

    public function computeSnapshotPath(array $size = [], bool $createFolder = false)
    {
        $snapshotFolder = \sprintf('%s/__image_snapshots/%s', BaseTestCase::TEST_FOLDER, $this->example_root);

        if (!\is_dir($snapshotFolder) && $createFolder) {
            \mkdir($snapshotFolder, 0755, true);
        }

        return \sprintf('%s/%s_%dx%d.jpg', $snapshotFolder, $this->filename, $size[0] ?? $this->width, $size[1] ?? $this->height);
    }
}
