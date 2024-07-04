<?php

namespace App\Contracts;

/**
 * Interface AdMessageReplyContract
 * @package App\Contracts
 */
interface AdMessageReplyContract
{
	/**
     * @param array $params
     * @return mixed
     */
    public function storeAdMessageReply(array $params);
}