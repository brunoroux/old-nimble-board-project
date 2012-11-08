<?php

namespace Agile\NimbleBoardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Agile\NimbleBoardBundle\Entity\Story;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class StoryController extends Controller
{
  /**
   * Product backlog action
   */
  public function listStoriesAction()
  {
    $stories = $this->getDoctrine()->getRepository('NimbleBoardBundle:Story')->findAll();
    $globalComplexity = $this->getComplexitySum($stories);
    if ($this->hasPositionedStories($stories)) {
      $minheight = $this->getMaxStoryOffset($stories) + 300;
    } else {
      // Par défaut on considère qu'on peut mettre 4 stories par ligne et que chaque story n'excède pas 300px de hauteur
      // on devrait pas être trop loin de la réalité, a voir à l'usage
      $minheight = ceil(count($stories) / 4) * 300;
    }
    return $this->render('NimbleBoardBundle:Story:list.html.twig', array('stories' => $stories, 'globalComplexity' => $globalComplexity, 'minheight' => $minheight));
  }

  /**
   * Story add form
   */
  public function AddOrEditAction($id = false)
  {
    $router = $this->get('router');
    if ($id === false) {
      // Creating a new story
      $story = new Story();
      $formAction = $router->generate('_storyAdd');
    } else {
      $story = $this->loadExistingStory($id);
      $formAction = $router->generate('_storyEdit', array('id' => $id));
    }

    $request = $this->getRequest();
    $translator = $this->get('translator');
    $form = $this->createFormBuilder($story)
      ->add('textAsA', 'textarea', array('label' => $translator->trans('story.asa')))
      ->add('textIWant', 'textarea', array('label' => $translator->trans('story.iwant')))
      ->add('textFor', 'textarea', array('label' => $translator->trans('story.for')))
      ->add('acceptance', 'textarea', array('label' => $translator->trans('story.acceptance')))
      ->add('complexity', 'integer', array(
        'label' => $translator->trans('story.complexity'),
        'invalid_message' => $translator->trans('error.integerNeeded'),
        'invalid_message_parameters' => array('%fieldName%' => $translator->trans('story.complexity')),
        'required' => false,
      ))
      ->add('importance', 'integer', array(
        'label' => $translator->trans('story.importance'),
        'invalid_message' => $translator->trans('error.integerNeeded'),
        'invalid_message_parameters' => array('%fieldName%' => $translator->trans('story.importance')),
        'required' => false,
      ))
      ->getForm();

    if ($request->isMethod('POST')) {
      $form->bind($request);
      if ($form->isValid()) {
        // Form submitted and valid => Let's persist $story to database
        $now = new \DateTime();
        if ($story->getCreated() === null) {
          $story->setCreated($now);
        }
        $story->setChanged($now);

        $em = $this->getDoctrine()->getManager();
        $em->persist($story);
        $em->flush();

        $this->get('session')->setFlash('notice', $translator->trans('story.saved'));

        return new RedirectResponse($this->generateUrl('_productBacklog'));
      }
    }

    return $this->render('NimbleBoardBundle:Story:addOrEdit.html.twig', array('form' => $form->createView(), 'formAction' => $formAction));
  }

  /**
   * Story edit form
   */
  public function EditAction($id)
  {
    $story = $this->loadExistingStory($id);
  }

  /**
   * Story delete action
   */
  public function deleteAction($id, $confirm = false)
  {
    $story = $this->loadExistingStory($id);

    if ($confirm === false) {
      return $this->render('NimbleBoardBundle:Story:delete.html.twig', array('story' => $story));
    } else {
      $em = $this->getDoctrine()->getManager();
      $em->remove($story);
      $em->flush();

      $translator = $this->get('translator');
      $this->get('session')->setFlash('notice', $translator->trans('story.deleted'));

      return new RedirectResponse($this->generateUrl('_productBacklog'));
    }
  }

  public function setCoordinatesAction() {
    $request = $this->getRequest();
    $id = $request->query->get('id');
    $story = $this->loadExistingStory($id);
    $left = $request->query->get('left');
    $top = $request->query->get('top');

    $story->setPosX($left);
    $story->setPosY($top);

    $em = $this->getDoctrine()->getManager();
    $em->persist($story);
    $em->flush();

    $response = new Response(json_encode(array('success' => true, 'id' => $id, 'coordinates' => array('left' => $left, 'top' => $top))));
    $response->headers->set('Content-Type', 'application/json');
    return $response;
  }

  /**
   * internal function, loads an existing story (if exists) throws an exception otherwise
   * @param $id
   * @return \Agile\NimbleBoardBundle\Entity\Story
   * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
   */
  protected function loadExistingStory($id)
  {
    $story = $this->getDoctrine()->getRepository('NimbleBoardBundle:Story')->find($id);
    if (!$story) {
      throw $this->createNotFoundException('No story found for id '.$id);
    }
    return $story;
  }

  /**
   * calculates the sum of all complexities in product backlog
   * @param $stories
   * @return int
   */
  protected function getComplexitySum($stories)
  {
    $complexity = 0;
    foreach($stories as $story)
    {
      $complexity += $story->getComplexity();
    }
    return $complexity;
  }

  /**
   * determines wether at least 1 story has been dragged
   * @param $stories
   * @return bool
   */
  protected function hasPositionedStories($stories) {
    $return = false;
    foreach ($stories as $story) {
      if ($story->getPosX() !== null || $story->getPosY() !== null) {
        $return = true;
      }
    }
    return $return;
  }

  /**
   * determines the maximum offset of the stories
   * @param $stories
   * @return int
   */
  protected function getMaxStoryOffset($stories) {
    $max = 0;
    foreach($stories as $story) {
      if ($story->getPosY() > $max) {
        $max = $story->getPosY();
      }
    }
    return $max;
  }
}
