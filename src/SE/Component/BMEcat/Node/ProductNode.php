<?php
/**
 * This file is part of the BMEcat php library
 *
 * (c) Sven Eisenschmidt <sven.eisenschmidt@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SE\Component\BMEcat\Node;

use JMS\Serializer\Annotation as Serializer;
use SE\Component\BMEcat\Exception\InvalidSetterException;
use SE\Component\BMEcat\Exception\UnknownKeyException;

/**
 *
 * @package SE\Component\BMEcat
 * @author Sven Eisenschmidt <sven.eisenschmidt@gmail.com>
 *
 * @Serializer\XmlRoot("PRODUCT")
 */
class ProductNode extends AbstractNode
{
    /**
     * @Serializer\Expose
     * @Serializer\Type("string")
     * @Serializer\SerializedName("mode")
     * @Serializer\XmlAttribute
     *
     * @var string
     */
    protected $mode = 'new';

    /**
     *
     * @Serializer\Expose
     * @Serializer\Type("string")
     * @Serializer\SerializedName("SUPPLIER_PID")
     *
     * @var string
     */
    protected $id;

    /**
     *
     * @Serializer\Expose
     * @Serializer\SerializedName("PRODUCT_DETAILS")
     * @Serializer\Type("SE\Component\BMEcat\Node\ProductDetailsNode")
     *
     * @var ProductDetailsNode
     */
    protected $detail;


    /**
     *
     * @Serializer\Expose
     * @Serializer\Type("array<SE\Component\BMEcat\Node\ProductFeaturesNode>")
     * @Serializer\XmlList( inline=true, entry="PRODUCT_FEATURES")
     *
     * @var ProductFeaturesNode[]
     */
    protected $features = [];

    /**
     * @Serializer\Expose
     * @Serializer\SerializedName("PRODUCT_ORDER_DETAILS")
     * @Serializer\Type("SE\Component\BMEcat\Node\ProductOrderDetailsNode")
     *
     * @var ProductOrderDetailsNode
     */
    protected $orderDetails;

    /**
     *
     * @Serializer\Expose
     * @Serializer\SerializedName("PRODUCT_PRICE_DETAILS")
     * @Serializer\Type("array<SE\Component\BMEcat\Node\ProductPriceDetailsNode>")
     * @Serializer\XmlList(inline = true, entry = "PRODUCT_PRICE_DETAILS")
     *
     * @var ProductPriceNode[]
     */
    protected $priceDetails = [];

    /**
     *
     * @Serializer\Expose
     * @Serializer\SerializedName("MIME_INFO")
     * @Serializer\Type("array<SE\Component\BMEcat\Node\MimeNode>")
     * @Serializer\XmlList( entry="MIME")
     *
     * @var MimeNode[]
     */
    protected $mimes = [];

    /**
     *
     * @param ProductDetailsNode $details
     * @return ProductNode
     */
    public function setDetails(ProductDetailsNode $details) : ProductNode
    {
        $this->detail = $details;
        return $this;
    }

    /**
     *
     * @return ProductDetailsNode
     */
    public function getDetails()
    {
        return $this->detail;
    }

    /**
     *
     * @param ProductPriceNode[] $priceDetails
     * @return ProductNode
     * @throws InvalidSetterException
     * @throws UnknownKeyException
     */
    public function setPriceDetails(array $priceDetails) : ProductNode
    {
        $this->priceDetails = [];
        foreach ($priceDetails as $priceDetail) {
            if (is_array($priceDetail)) {
                $priceDetail = ProductPriceDetailsNode::fromArray($priceDetail);
            }
            $this->addPriceDetail($priceDetail);
        }
        return $this;
    }

    /**
     *
     * @param ProductPriceDetailsNode $price
     * @return ProductNode
     */
    public function addPriceDetail(ProductPriceDetailsNode $price) : ProductNode
    {
        if ($this->priceDetails === null) {
            $this->priceDetails = [];
        }
        $this->priceDetails[] = $price;
        return $this;
    }

    /**
     * @param MimeNode[] $mimes
     * @return ProductNode
     * @throws InvalidSetterException
     * @throws UnknownKeyException
     */
    public function setMimes(array $mimes): ProductNode
    {
        $this->mimes = [];
        foreach ($mimes as $mime) {
            if (is_array($mime)) {
                $mime = MimeNode::fromArray($mime);
            }
            $this->addMime($mime);
        }
        return $this;
    }

    /**
     * @param MimeNode $mime
     * @return ProductNode
     */
    public function addMime(MimeNode $mime) : ProductNode
    {
        if ($this->mimes === null) {
            $this->mimes = [];
        }
        $this->mimes[] = $mime;
        return $this;
    }

    /**
     *
     * @Serializer\PreSerialize
     * @Serializer\PostSerialize
     * @return ProductNode
     */
    public function nullPriceDetails() : ProductNode
    {
        if (empty($this->priceDetails) === true) {
            $this->priceDetails = null;
        }
        return $this;
    }

    /**
     *
     * @Serializer\PreSerialize
     * @Serializer\PostSerialize
     * @return ProductNode
     */
    public function nullMime() : ProductNode
    {
        if (empty($this->mimes) === true) {
            $this->mimes = null;
        }
        return $this;
    }

    /**
     *
     * @param string $id
     * @return ProductNode
     */
    public function setId($id) : ProductNode
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return ProductOrderDetailsNode|null
     */
    public function getOrderDetails()
    {
        return $this->orderDetails;
    }

    /**
     * @param ProductOrderDetailsNode $orderDetails
     * @return ProductNode
     */
    public function setOrderDetails(ProductOrderDetailsNode $orderDetails) : ProductNode
    {
        $this->orderDetails = $orderDetails;
        return $this;
    }

    /**
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     *
     * @Serializer\PreSerialize
     * @Serializer\PostSerialize
     * @return ProductNode
     */
    public function nullFeatures() : ProductNode
    {
        if (empty($this->features) === true) {
            $this->features = null;
        }

        return $this;
    }

    /**
     * @param ProductFeaturesNode[] $features
     * @return ProductNode
     * @throws InvalidSetterException
     * @throws UnknownKeyException
     */
    public function setFeatures(array $features): ProductNode
    {
        $this->features = [];
        foreach ($features as $feature) {
            if (is_array($feature)) {
                $feature = ProductFeaturesNode::fromArray($feature);
            }
            $this->addFeatures($feature);
        }
        return $this;
    }

    /**
     *
     * @param ProductFeaturesNode $features
     * @return ProductNode
     */
    public function addFeatures(ProductFeaturesNode $features) : ProductNode
    {
        if ($this->features === null) {
            $this->features = [];
        }
        $this->features [] = $features;
        return $this;
    }

    /**
     *
     * @return ProductFeaturesNode[]
     */
    public function getFeatures()
    {
        if ($this->features === null) {
            return [];
        }

        return $this->features;
    }

    /**
     *
     * @return ProductPriceNode[]
     */
    public function getPriceDetails()
    {
        if ($this->priceDetails === null) {
            return [];
        }

        return $this->priceDetails;
    }

    /**
     * @return MimeNode[]|null
     */
    public function getMimes()
    {
        return $this->mimes;
    }


}