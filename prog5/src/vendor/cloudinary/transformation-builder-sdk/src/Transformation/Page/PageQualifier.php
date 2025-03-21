<?php
/**
 * This file is part of the Cloudinary PHP package.
 *
 * (c) Cloudinary
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cloudinary\Transformation;

use Cloudinary\Transformation\Qualifier\BaseQualifier;

/**
 * Class PageQualifier
 */
class PageQualifier extends BaseQualifier
{
    protected const VALUE_CLASS = PageValue::class;

    /**
     * @var string $key Serialization key.
     */
    protected static string $key = 'pg';
}
