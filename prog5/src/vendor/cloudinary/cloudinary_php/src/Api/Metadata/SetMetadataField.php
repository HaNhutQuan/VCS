<?php
/**
 * This file is part of the Cloudinary PHP package.
 *
 * (c) Cloudinary
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cloudinary\Api\Metadata;

/**
 * Represents a metadata field with 'Set' (multi-selection list) type.
 *
 * @api
 */
class SetMetadataField extends MetadataFieldList
{
    /**
     * The SetMetadataField constructor.
     */
    public function __construct(string $label, array|MetadataDataSource $dataSource = [])
    {
        parent::__construct($label, $dataSource);
        $this->type = MetadataFieldType::SET;
    }
}
