<?php
/**
 * This file is part of the eZ Publish Legacy package
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributd with this source code.
 * @version //autogentag//
 */

/**
 * A filter iterator used by eZDFSFileHandlerDFSBackend.
 * It filters directories out, and converts the current() return value to a relative path to the file.
 */
class eZDFSFileHandlerDFSBackendFilterIterator extends FilterIterator
{
    /**
     * @var string
     */
    private $prefix;

    public function __construct( Iterator $iterator, $prefix )
    {
        parent::__construct( $iterator );
        $this->prefix = $prefix;
    }

    /**
     * Filters directories out
     * return type ref: https://www.php.net/manual/en/filteriterator.accept.php
     */
    public function accept(): bool
    {
        return $this->getInnerIterator()->current()->isFile();
    }

    /**
     * Transforms the SplFileInfo in a simple relative path
     * return type ref: https://www.php.net/manual/en/filteriterator.current.php
     *
     * @return string The relative path to the current file
     */
    public function current(): mixed
    {
        /** @var SplFileInfo $file */
        $file = $this->getInnerIterator()->current();
        $filePathName = $file->getPathname();

        // Trim prefix + 1 for leading /
        return substr( $filePathName, strlen( $this->prefix ) + 1 );
    }
}
