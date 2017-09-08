<?php

namespace Chaplean\Bundle\RestClientBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="cl_rest_status_code_type")
 */
class RestStatusCodeType
{
    /**
     * @var integer
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", unique=true, length=50, nullable=false, name="keyname")
     */
    private $keyname;

    /**
     * @var integer
     *
     * @ORM\Column(type="smallint", unique=true, nullable=false, name="code", options={"unsigned":true})
     */
    private $code;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Chaplean\Bundle\RestClientBundle\Entity\RestLog", mappedBy="statusCode")
     */
    private $logs;

    /**
     * RestStatusCodeType constructor.
     */
    public function __construct()
    {
        $this->logs = new ArrayCollection();
    }

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
     * Get keyname.
     *
     * @return string
     */
    public function getKeyname()
    {
        return $this->keyname;
    }

    /**
     * Set keyname.
     *
     * @param string $keyname
     *
     * @return RestStatusCodeType
     */
    public function setKeyname($keyname)
    {
        $this->keyname = $keyname;

        return $this;
    }

    /**
     * Get code.
     *
     * @return integer
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set code.
     *
     * @param integer $code
     *
     * @return RestStatusCodeType
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get logs.
     *
     * @return ArrayCollection
     */
    public function getLogs()
    {
        return $this->logs;
    }

    /**
     * Adds a log
     *
     * @param RestLog $log
     *
     * @return RestStatusCodeType
     */
    public function addLog(RestLog $log)
    {
        $this->logs->add($log);

        return $this;
    }

    /**
     * Removes a log
     *
     * @param RestLog $log
     *
     * @return RestStatusCodeType
     */
    public function removeLog(RestLog $log)
    {
        $this->logs->removeElement($log);

        return $this;
    }
}
