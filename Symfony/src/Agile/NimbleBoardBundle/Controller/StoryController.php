<?php

namespace Agile\NimbleBoardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Agile\NimbleBoardBundle\Entity\Story;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

class StoryController extends Controller
{
  /**
   * Product backlog action
   */
  public function listStoriesAction()
  {
    $stories = $this->getDoctrine()->getRepository('NimbleBoardBundle:Story')->findAll();
    return $this->render('NimbleBoardBundle:Story:list.html.twig', array('stories' => $stories));
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
}
