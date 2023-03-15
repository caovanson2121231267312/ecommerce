<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection as BaseResourceCollection;

class ResourceCollection extends BaseResourceCollection
{
    protected $fields;

    protected function _parseFieldRequest($request)
    {
        $fields = explode(",", $request->fields);

        array_walk($fields, function (&$item) {
            $item = trim($item);

            if(str_contains($item, ":"))
            {
                list($fieldName, $attribute) = explode(":", $item);

                $item = ['field' => $fieldName, 'attribute' => $attribute];
            }
        });

        $this->fields = $fields;
    }

    protected function _isFieldRequested($fieldName)
    {
        foreach ($this->fields as $field) {
            if(is_array($field))
            {
                if($field['fieldName'] === $fieldName)
                {
                    return true;
                }
            }

            if($field === $fieldName)
            {
                return true;
            }
        }

        return false;
    }

    protected function _formatTimestamp($datetime, $fieldName)
    {
        $request = new Request;

        if($request->has('timestamps_format'))
        {
            return $datetime->format($request->timestamps_format);
        }

        foreach ($this->fields as $field) {
            if(is_array($field))
            {
                if($field['fieldName'] === $fieldName)
                {
                    return $datetime->format($field['attribute']);
                }
            }
        }

        return $datetime;
    }

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}

