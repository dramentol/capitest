<?php

namespace T\DomainBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use T\DomainBundle\Entity\Comment;
use T\DomainBundle\Entity\Post;

class DefaultController extends Controller
{
    /**
     * @Route("/index")
     * @Template()
     */
    public function indexAction()
    {
        $user = $this->get('fos_user.user_manager')->findUserByEmail('david.ramentol@gmail.com');

        $post = new Post();
        $post->setTitle('TES ttlekj')->setBody(' kadfj adslkfj adsklfj adslkfj ')->setAuthor($user)->setCreated(
            new \DateTime()
        );

        $manager = $this->getDoctrine()->getManager();
        $manager->persist($post);
        $manager->flush();

        $comment = new Comment();
        $comment->setPost($post)->setBody('kljdfa adslkfjadslkfj')->setCreated(new \DateTime())->setAuthor($user);

        $manager->persist($comment);
        $manager->flush();


//        $aclProvider = $this->get('security.acl.provider');

//        $comments = $this->getDoctrine()->getRepository('TDomainBundle:Comment')->findAll();
//        foreach ($comments as $comment) {
//            $oid = ObjectIdentity::fromDomainObject($comment);
//            $aclProvider->createAcl($oid);
//        }

        // creating the ACL
//        $aclProvider = $this->get('security.acl.provider');
        $objectIdentity = new ObjectIdentity('class', 'T\DomainBundle\Entity\Comment');
//        $acl = $aclProvider->findAcl($objectIdentity);

        // retrieving the security identity of the currently logged-in user
        $securityContext = $this->get('security.context');
//        $user = $securityContext->getToken()->getUser();


        $securityIdentity = UserSecurityIdentity::fromAccount($user);

        // grant owner access
//        $acl->insertClassAce($securityIdentity, MaskBuilder::MASK_OWNER);
//        $aclProvider->updateAcl($acl);


        $entity = $this->getDoctrine()->getManager()->find('TDomainBundle:Comment', 2);

        $token = new UsernamePasswordToken($user, $user->getPassword(), 'public', $user->getRoles());
//        $securityContext = $this->get('security.context');
        $securityContext->setToken($token);

        // check for edit access
        if (false === $securityContext->isGranted('EDIT', $entity)) {
            throw new AccessDeniedException();
        }

//        $aces = $acl->getClassAces();

        return array('name' => 'patapam', 'aces' => array());
    }
}
