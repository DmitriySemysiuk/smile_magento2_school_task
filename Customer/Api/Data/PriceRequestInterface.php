<?php

namespace Smile\Customer\Api\Data;

/**
 * Class PriceRequestsInterface
 *
 * @package Smile\Customer\Api\Data
 */
interface PriceRequestInterface
{
    /**
     * Table name
     */
    const TABLE_NAME = 'customer_price_request';

    /**#@+
     * Constants defined for keys of data array.
     */
    const ID = 'id';
    const NAME = 'name';
    const EMAIL = 'email';
    const COMMENT = 'comment';
    const CREATE_AT = 'created_at';
    const STATUS = 'status';
    const ANSWER = 'answer';
    const PRODUCT_SKU = 'product_sku';
    /**#@-*/

    /**
     * Get Id
     *
     * @return int
     */
    public function getId();

    /**
     * Get name
     *
     * @return string
     */
    public function getName();

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail();

    /**
     * Get comment
     *
     * @return string
     */
    public function getComment();

    /**
     * Get creation time
     *
     * @return string
     */
    public function getCreatedAt();

    /**
     * Get status
     *
     * @return int
     */
    public function getStatus();

    /**
     * Get answer
     *
     * @return string
     */
    public function getAnswer();

    /**
     * Get product stock keeping unit
     *
     * @return string
     */
    public function getProductSku();

    /**
     * Set Id
     *
     * @param int $id
     *
     * @return PriceRequestInterface
     */
    public function setId($id);

    /**
     * Set name
     *
     * @param string $name
     *
     * @return PriceRequestInterface
     */
    public function setName($name);

    /**
     * Set email
     *
     * @param string $email
     *
     * @return PriceRequestInterface
     */
    public function setEmail($email);

    /**
     * Set comment
     *
     * @param string $comment
     *
     * @return PriceRequestInterface
     */
    public function setComment($comment);

    /**
     * Set creation time
     *
     * @param string $creationTime
     *
     * @return PriceRequestInterface
     */
    public function setCreatedAt($creationTime);

    /**
     * Set status
     *
     * @param int $status
     *
     * @return PriceRequestInterface
     */
    public function setStatus($status);

    /**
     * Set answer
     *
     * @param string $answer
     *
     * @return PriceRequestInterface
     */
    public function setAnswer($answer);

    /**
     * Set product stock keeping unit
     *
     * @return PriceRequestInterface
     *@var string $productSku
     *
     */
    public function setProductSku($productSku);
}
