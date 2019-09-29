<?php
namespace App\Serializer;

use League\Fractal\Serializer\JsonApiSerializer;

class CustomApiSerializer extends JsonApiSerializer
{
    public function __construct()
    {
        $this->baseUrl = app()->request->url();
    }

    public function meta($meta)
    {
        $meta = parent::meta($meta);

        if (isset($meta['meta']['pagination']['count'])) {
            $meta['meta']['count'] = $meta['meta']['pagination']['count'];
        }
        if (isset($meta['meta']['pagination']['total'])) {
            $meta['meta']['total'] = $meta['meta']['pagination']['total'];
        }
        if (isset($meta["meta"]["pagination"])) {
            unset($meta["meta"]['pagination']);
        }

        return $meta;
    }
}
