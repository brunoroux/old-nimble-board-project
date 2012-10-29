<?php

namespace Agile\NimbleBoardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class StoryController extends Controller
{
  /**
   * Product backlog action
   */
  public function listStoriesAction()
  {
    $stories = $projects = $this->getDoctrine()->getRepository('NimbleBoardBundle:Story')->findAll();
    return $this->render('NimbleBoardBundle:Story:list.html.twig', array('stories' => $stories));
  }
}
