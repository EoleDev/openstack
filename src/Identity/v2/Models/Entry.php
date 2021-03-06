<?php declare (strict_types=1);

namespace OpenStack\Identity\v2\Models;

use OpenCloud\Common\Resource\AbstractResource;

/**
 * Represents an Identity v2 Catalog Entry.
 *
 * @package OpenStack\Identity\v2\Models
 */
class Entry extends AbstractResource
{
    /** @var string */
    public $name;

    /** @var string */
    public $type;

    /** @var []Endpoint */
    public $endpoints = [];

    /**
     * Indicates whether this catalog entry matches a certain name and type.
     *
     * @param string $name
     * @param string $type
     *
     * @return bool TRUE if it's a match, FALSE if not
     */
    public function matches(string $name, string $type): bool
    {
        return $this->name == $name && $this->type == $type;
    }

    /**
     * Retrieves the catalog entry's URL according to a specific region and URL type
     *
     * @param string $region
     * @param string $urlType
     *
     * @return string
     */
    public function getEndpointUrl(string $region, string $urlType): string
    {
        foreach ($this->endpoints as $endpoint) {
            if ($endpoint->supportsRegion($region) && $endpoint->supportsUrlType($urlType)) {
                return $endpoint->getUrl($urlType);
            }
        }

        return "";
    }
}
