<?php

namespace Agile\NimbleBoardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Agile\NimbleBoardBundle\Entity\Sprint;
use Agile\NimbleBoardBundle\Entity\Project;

class SprintController extends Controller
{

  /**
   * Sprint add/edit form
   */
  public function addOrEditAction($id = false, $projectId = false)
  {
    $router = $this->get('router');
    if ($id === false) {
      // Creating a new story
      $sprint = new Sprint();
      $project = $this->getDoctrine()->getRepository('NimbleBoardBundle:Project')->find($projectId);
      $sprint->setProject($project);
      $formAction = $router->generate('_sprintAdd', array('projectId' => $project->getId()));
    } else {
      $sprint = $this->loadExistingSprint($id);
      $project = $sprint->getProject();
      $formAction = $router->generate('_sprintEdit', array('id' => $id));
    }

    $request = $this->getRequest();
    $translator = $this->get('translator');
    $form = $this->createFormBuilder($sprint)
      ->add('number', 'integer', array(
        'label' => $translator->trans('sprint.number'),
        'invalid_message' => $translator->trans('error.integerNeeded'),
        'invalid_message_parameters' => array('%fieldName%' => $translator->trans('sprint.number')),
      ))
      ->add('week', 'integer', array(
        'label' => $translator->trans('sprint.week'),
        'invalid_message' => $translator->trans('error.integerNeeded'),
        'invalid_message_parameters' => array('%fieldName%' => $translator->trans('sprint.week')),
      ))
      ->getForm();

    if ($request->isMethod('POST')) {
      $form->bind($request);
      if ($form->isValid()) {
        // Form submitted and valid => Let's persist $story to database
        $now = new \DateTime();
        if ($sprint->getCreated() === null) {
          $sprint->setCreated($now);
        }
        $sprint->setChanged($now);

        $em = $this->getDoctrine()->getManager();
        $em->persist($sprint);
        $em->flush();

        $this->get('session')->setFlash('notice', $translator->trans('sprint.saved'));

        return new RedirectResponse($this->generateUrl('_sprintList', array('projectId' => $project->getId())));
      }
    }

    return $this->render('NimbleBoardBundle:Sprint:addOrEdit.html.twig', array('form' => $form->createView(), 'formAction' => $formAction, 'project' => $project));
  }

  /**
   * List sprints for a given project
   */
  public function listAction($projectId)
  {
    $project = $this->getDoctrine()->getRepository('NimbleBoardBundle:Project')->findOneByIdJoinedToSprints($projectId);
    return $this->render('NimbleBoardBundle:Sprint:list.html.twig', array('project' => $project));
  }

  /**
   * Sprint delete action
   */
  public function deleteAction($id, $confirm = false)
  {
    $sprint = $this->loadExistingSprint($id, true);

    if ($confirm === false) {
      return $this->render('NimbleBoardBundle:Sprint:delete.html.twig', array('sprint' => $sprint));
    } else {
      $em = $this->getDoctrine()->getManager();
      $em->remove($sprint);
      $em->flush();

      $translator = $this->get('translator');
      $this->get('session')->setFlash('notice', $translator->trans('sprint.deleted'));

      return new RedirectResponse($this->generateUrl('_sprintList', array('projectId' => $sprint->getProject()->getId())));
    }
  }

  /**
   * Sprint Backlog action
   */
  public function backlogAction($id)
  {
    $sprint = $this->getDoctrine()->getRepository('NimbleBoardBundle:Sprint')->findOneByIdJoinedToStoriesAndProject($id);
    return $this->render('NimbleBoardBundle:Sprint:backlog.html.twig', array('sprint' => $sprint));
  }

  /**
   * add stories screen to sprint action
   */
  public function addStoriesAction($id)
  {
    $sprint = $this->getDoctrine()->getRepository('NimbleBoardBundle:Sprint')->findOneByIdJoinedToStoriesAndProject($id);
    $stories = $this->getDoctrine()->getRepository('NimbleBoardBundle:Story')->findBySprint(null);
    return $this->render('NimbleBoardBundle:Sprint:addStories.html.twig', array('sprint' => $sprint, 'stories' => $stories));
  }

  /**
   * add story action (called by an ajax request)
   */
  public function addStoryAction()
  {
    $request = $this->getRequest();
    $storyId = $request->query->get('storyId');
    $sprintId = $request->query->get('sprintId');

    $story = $this->getDoctrine()->getRepository('NimbleBoardBundle:Story')->find($storyId);
    if ($sprintId == "null") {
      $sprint = null;
    } else {
      $sprint = $this->loadExistingSprint($sprintId);
    }
    $story->setSprint($sprint);

    $em = $this->getDoctrine()->getManager();
    $em->persist($story);
    $em->flush();

    $response = new Response(json_encode(array('success' => true)));
    $response->headers->set('Content-Type', 'application/json');
    return $response;
  }

  protected function loadExistingSprint($id)
  {
    $sprint = $this->getDoctrine()->getRepository('NimbleBoardBundle:Sprint')->find($id);
    if (!$sprint) {
      throw $this->createNotFoundException('No sprint found for id '.$id);
    }
    return $sprint;
  }
}
