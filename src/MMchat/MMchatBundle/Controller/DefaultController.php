<?php

namespace MMchat\MMchatBundle\Controller;

use MMchat\MMchatBundle\Entity\Post;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction()
    {
    	return $this->getPosts();
    }
    
    /**
     * @Route("/post")
     * @Template()
     */
    public function postAction()
    {
    	if ($this->getRequest()->getMethod() == 'post') {
			$post = new Post();

	    	$post->setAuthor($this->getRequest()->request->get('author'));
	    	$post->setPost($this->getRequest()->request->get('post'));
	    	$post->setCreatedAt(new \DateTime());

	    	// Validate Post
	    	$validator = $this->get('validator');
	    	$errors = $validator->validate($post);

	    	if (count($errors) == 0) {
			    $em = $this->getDoctrine()->getEntityManager();
			    $em->persist($post);
			    $em->flush();
	       	}
		}

       	return $this->getPosts();
    }

    private function getPosts()
    {
        $repository = $this->getDoctrine()->getRepository('MMchatBundle:Post');
        $allPosts = $repository->findBy(array(), array('created_at' => 'DESC'));
        return array("posts" => $allPosts);	
    }
}
