<?php

namespace Chaplean\Bundle\RestClientBundle\DataFixtures\Entity;

use Chaplean\Bundle\RestClientBundle\Entity\RestMethodType;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class LoadRestMethodTypeData.
 *
 * @package   Chaplean\Bundle\RestClientBundle\DataFixtures\Entity
 * @author    Matthias - Chaplean <matthias@chaplean.coop>
 * @copyright 2014 - 2017 Chaplean (http://www.chaplean.coop)
 * @since     4.0.0
 */
class LoadRestMethodTypeData extends AbstractFixture
{
    /**
     * @param ObjectManager $manager
     *
     * @return void
     */
    public function load(ObjectManager $manager)
    {
        $method = new RestMethodType();
        $method->setKeyname('get');
        $manager->persist($method);
        $this->setReference('rest-method-type-get', $method);

        $method = new RestMethodType();
        $method->setKeyname('post');
        $manager->persist($method);
        $this->setReference('rest-method-type-post', $method);

        $method = new RestMethodType();
        $method->setKeyname('put');
        $manager->persist($method);
        $this->setReference('rest-method-type-put', $method);

        $method = new RestMethodType();
        $method->setKeyname('patch');
        $manager->persist($method);
        $this->setReference('rest-method-type-patch', $method);

        $method = new RestMethodType();
        $method->setKeyname('delete');
        $manager->persist($method);
        $this->setReference('rest-method-type-delete', $method);

        $manager->flush();
    }
}
