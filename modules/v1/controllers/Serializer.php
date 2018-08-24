<?php

namespace v1\controllers;


class Serializer extends \yii\rest\Serializer
{
    public $metaEnvelope = 'pagination';

    /**
     * Serializes a pagination into an array.
     * @param Pagination $pagination
     * @return array the array representation of the pagination
     * @see addPaginationHeaders()
     */
    protected function serializePagination($pagination)
    {
        return [
            //$this->linksEnvelope => Link::serialize($pagination->getLinks(true)),
            $this->metaEnvelope => [
                'count' => $pagination->totalCount,
                'pageCount' => $pagination->getPageCount(),
                'page' => $pagination->getPage() + 1,
                'pageSize' => $pagination->getPageSize(),
            ],
        ];
    }
}