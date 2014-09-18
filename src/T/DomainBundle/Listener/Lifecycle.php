<?php
/**
 * Created by david.ramentol@zappingconsulting.com
 * Date: 04/09/14
 * Time: 03:03
 */

namespace T\DomainBundle\Listener;

use Doctrine\Common\Persistence\Event\LifecycleEventArgs;

class Lifecycle
{
    public function postPersist($entity, LifecycleEventArgs $event)
    {
        $tset = 0;
    }
}
