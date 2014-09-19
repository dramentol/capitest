<?php
/**
 * Created by david.ramentol@zappingconsulting.com
 * Date: 04/09/14
 * Time: 12:08
 */

namespace T\DomainBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Annotations;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class CommentController
 * @package T\DomainBundle\Controller
 */
class CommentController extends FOSRestController
{
    /**
     * List all comments
     *
     * @Annotations\QueryParam(name="offset", requirements="\d+", nullable=true, description="Offset from which to start listing notes.")
     * @Annotations\QueryParam(name="limit", requirements="\d+", default="5", description="How many notes to return.")
     *
     * @Annotations\View()
     *
     * @param Request $request
     * @param ParamFetcherInterface $paramFetcher
     *
     * @return array
     */
    public function getCommentsAction(Request $request, ParamFetcherInterface $paramFetcher)
    {
        $offset = $paramFetcher->get('offset');
        $start = null == $offset ? 0 : $offset + 1;
        $limit = $paramFetcher->get('limit');

        $comments = $this->getDoctrine()->getRepository('TDomainBundle:Comment')->findAll();

        return array('comments' => $comments, 'offset' => $offset, 'limit' => $limit);
    }

    /**
     * Get a single comment.
     *
     * @Annotations\View(templateVar="comment")
     *
     * @param Request $request the request object
     * @param int     $id      the comment id
     *
     * @return array
     *
     * @throws NotFoundHttpException when note not exist
     */
    public function getCommentAction(Request $request, $id)
    {
        $comment = $this->getDoctrine()->getRepository('TDomainBundle:Comment')->find($id);
        if (false === $comment) {
            throw $this->createNotFoundException("Comment does not exist.");
        }

        $view = new View($comment);
        return $view;
    }
}
