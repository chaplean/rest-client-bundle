<?php

namespace Chaplean\Bundle\RestClientBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(
 *    name="cl_rest_log",
 *    indexes={
 *      @ORM\Index(name="rest_log_url_INDEX", columns={"url"}),
 *      @ORM\Index(name="rest_log_response_uuid_INDEX", columns={"responseUuid"})
 *    }
 * )
 */
class RestLog
{
    /**
     * @var integer
     *
     * @ORM\Id
     * @ORM\Column(type="integer", options={"unsigned":true})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=false, name="url")
     */
    private $url;

    /**
     * @var array|string
     *
     * @ORM\Column(type="json_array", nullable=false, name="data_sended")
     */
    private $dataSended;

    /**
     * @var array|string
     *
     * @ORM\Column(type="json_array", nullable=true, name="date_received")
     */
    private $dataReceived;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=false, name="date_add")
     */
    private $dateAdd;

    /**
     * @var RestMethodType
     *
     * @ORM\ManyToOne(targetEntity="Chaplean\Bundle\RestClientBundle\Entity\RestMethodType", inversedBy="logs")
     * @ORM\JoinColumn(name="rest_method_type_id", referencedColumnName="id", nullable=false, onDelete="RESTRICT")
     */
    private $method;

    /**
     * @var RestStatusCodeType
     *
     * @ORM\ManyToOne(targetEntity="Chaplean\Bundle\RestClientBundle\Entity\RestStatusCodeType", inversedBy="logs")
     * @ORM\JoinColumn(name="rest_status_code_type_id", referencedColumnName="id", onDelete="RESTRICT")
     */
    private $statusCode;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true, name="response_uuid")
     */
    private $responseUuid;

    /**
     * Get id.
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get url.
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set url.
     *
     * @param string $url
     *
     * @return RestLog
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get dataSended.
     *
     * @return array|string
     */
    public function getDataSended()
    {
        return $this->dataSended;
    }

    /**
     * Set dataSended.
     *
     * @param array|string $dataSended
     *
     * @return RestLog
     */
    public function setDataSended($dataSended)
    {
        $this->dataSended = $dataSended;

        return $this;
    }

    /**
     * Get dataReceived.
     *
     * @return array|string
     */
    public function getDataReceived()
    {
        return $this->dataReceived;
    }

    /**
     * Set dataReceived.
     *
     * @param array|string $dataReceived
     *
     * @return RestLog
     */
    public function setDataReceived($dataReceived)
    {
        $this->dataReceived = $dataReceived;

        return $this;
    }

    /**
     * Get dateAdd.
     *
     * @return \DateTime
     */
    public function getDateAdd()
    {
        return $this->dateAdd;
    }

    /**
     * Set dateAdd.
     *
     * @param \DateTime $dateAdd
     *
     * @return RestLog
     */
    public function setDateAdd(\DateTime $dateAdd)
    {
        $this->dateAdd = $dateAdd;

        return $this;
    }

    /**
     * Get method.
     *
     * @return RestMethodType
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * Set method.
     *
     * @param RestMethodType $method
     *
     * @return RestLog
     */
    public function setMethod(RestMethodType $method)
    {
        $this->method = $method;

        return $this;
    }

    /**
     * Get statusCode.
     *
     * @return RestStatusCodeType
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * Set statusCode.
     *
     * @param RestStatusCodeType $statusCode
     *
     * @return RestLog
     */
    public function setStatusCode(RestStatusCodeType $statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    /**
     * @return string
     */
    public function getResponseUuid()
    {
        return $this->responseUuid;
    }

    /**
     * @param string $responseUuid
     *
     * @return self
     */
    public function setResponseUuid($responseUuid)
    {
        $this->responseUuid = $responseUuid;

        return $this;
    }
}
