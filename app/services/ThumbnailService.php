<?php

class ThumbnailService {
    private $size;
    private $exif;
    private $path;
    private $image;
    private $widths = [
        '_lg' => 1200,
        '_md' => 800,
        '_sm' => 400,
        '_xs' => 120
    ];
    private $names = [
    ];

    private function appendImageName($append) {
        $parts    = explode('.', $this->path);
        $ext      = array_pop($parts);
        $parts    = array_reverse($parts);
        $parts[0] = $parts[0].$append;
        $parts    = array_reverse($parts);
        array_push($parts, $ext);
        return implode('.', $parts);
    }

    private function createThumbnails() {
        $thumb = new Imagick($this->path);
        foreach ($this->widths as $append => $width) {
            $name = $this->names[$append];
            if ($this->size[0] > $width) {
                $height = ($thumb->getImageHeight()/$thumb->getImageWidth())*$width;
                $thumb->thumbnailImage($width, $height, true);
            }
            $thumb->writeImage($name);
        }
    }

    private function fixOrientation() {
        if (isset($this->exif['Orientation'])) {
            $orientation = $this->exif['Orientation'];
        } elseif (isset($this->exif['IFD0']['Orientation'])) {
            $orientation = $this->exif['IFD0']['Orientation'];
        } else {

            return false;
        }

        switch ($orientation) {
            case 3:// rotate 180 degrees
                $this->image->rotateimage("#FFF", 180);
                break;

            case 6:// rotate 90 degrees CW
                $this->image->rotateimage("#FFF", 90);
                break;

            case 8:// rotate 90 degrees CCW
                $this->image->rotateimage("#FFF", -90);
                break;
        }
    }

    private function optimize() {
        $this->image->setImageDepth(8);
        $this->image->setCompressionQuality(60);
        $this->image->setImageUnits(72);
        $this->image->stripImage();
    }

    public function fire($job, $data = []) {
        $path = $data['path'];
        if (($this->size = getimagesize($path)) === false || strpos($path, '.gif') !== FALSE) {
            $job->delete();
            return;
        }
        try {
            $this->exif = exif_read_data($path);
        } catch (Exception $e) {
            $this->exif = null;
        }

        $this->path  = $path;
        $this->image = new Imagick($path);

        foreach ($this->widths as $append => $width) {
            $thumbPath = $this->names[$append] = $this->appendImageName($append);
            File::copy(public_path().'/packages/processing.png', $thumbPath);
        }

        /**
         * Cleanup and fix original image orientation
         */
        $this->optimize();
        if ($this->exif !== null) {
            $this->fixOrientation();
        }
        $this->image->writeImage($path);
        $this->image->clear();

        /**
         * Create Thumbnails
         */
        $this->createThumbnails();

        /**
         * Cleanup memory
         */
        $job->delete();
    }
}
