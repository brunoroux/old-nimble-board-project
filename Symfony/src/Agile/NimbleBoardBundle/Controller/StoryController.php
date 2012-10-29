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
    $stories = $projects = $this->getDoctrine()->getRepository('NimbleBoardBundle:Story')->findAll();
    return $this->render('NimbleBoardBundle:Story:list.html.twig', array('stories' => $stories));
  }

  /**
   * Story add form
   */
  public function AddAction()
  {
    $request = $this->getRequest();
    $translator = $this->get('translator');
    $story = new Story();
    $form = $this->createFormBuilder($story)
      ->add('textAsA', 'text', array('label' => $translator->trans('story.asa')))
      ->add('textIWant', 'text', array('label' => $translator->trans('story.iwant')))
      ->add('textFor', 'text', array('label' => $translator->trans('story.for')))
      ->add('acceptance', 'text', array('label' => $translator->trans('story.acceptance')))
      ->add('complexity', 'integer', array('label' => $translator->trans('story.complexity')))
      ->add('importance', 'integer', array('label' => $translator->trans('story.importance')))
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
        var_dump($story);die;
      }
    }

    return $this->render('NimbleBoardBundle:Story:add.html.twig', array('form' => $form->createView()));
  }
}
