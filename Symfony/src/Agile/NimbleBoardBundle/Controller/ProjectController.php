<?php

namespace Agile\NimbleBoardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Agile\NimbleBoardBundle\Entity\Project;
use Symfony\Component\HttpFoundation\RedirectResponse;

class ProjectController extends Controller
{
  public function listAction()
  {
    $projects = $this->getDoctrine()->getRepository('NimbleBoardBundle:Project')->findAll();
    return $this->render('NimbleBoardBundle:Project:list.html.twig', array('projects' => $projects));
  }

  public function addOrEditAction($id = false)
  {
    $router = $this->get('router');
    if ($id === false) {
      // Creating a new story
      $project = new Project();
      $formAction = $router->generate('_projectAdd');
    } else {
      $project = $this->loadExistingProject($id);
      $formAction = $router->generate('_projectEdit', array('id' => $id));
    }

    $request = $this->getRequest();
    $translator = $this->get('translator');
    $form = $this->createFormBuilder($project)
      ->add('name', 'text', array('label' => $translator->trans('project.name')))
      ->add('description', 'textarea', array('label' => $translator->trans('project.description')))
      ->add('start', 'date', array('label' => $translator->trans('project.start'), 'data' => new \DateTime()))
      ->add('end', 'date', array('label' => $translator->trans('project.end'), 'data' => new \DateTime()))
      ->getForm();

    if ($request->isMethod('POST')) {
      $form->bind($request);
      if ($form->isValid()) {
        // Form submitted and valid => Let's persist $story to database
        $now = new \DateTime();
        if ($project->getCreated() === null) {
          $project->setCreated($now);
        }
        $project->setChanged($now);

        $em = $this->getDoctrine()->getManager();
        $em->persist($project);
        $em->flush();

        $this->get('session')->setFlash('notice', $translator->trans('project.saved'));

        return new RedirectResponse($this->generateUrl('_projectList'));
      }
    }

    return $this->render('NimbleBoardBundle:Project:addOrEdit.html.twig', array('form' => $form->createView(), 'formAction' => $formAction));
  }

  protected function loadExistingProject($id)
  {
    $project = $this->getDoctrine()->getRepository('NimbleBoardBundle:Project')->find($id);
    if (!$project) {
      throw $this->createNotFoundException('No project found for id '.$id);
    }
    return $project;
  }
}
