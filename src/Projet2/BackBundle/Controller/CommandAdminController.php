<?php

namespace Projet2\BackBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Projet2\BackBundle\Entity\Command;
use Projet2\BackBundle\Form\CommandType;

/**
 * Command controller.
 *
 * @Route("/admin/command")
 */
class CommandAdminController extends Controller
{

    /**
     * Lists all Command entities.
     *
     * @Route("/", name="command")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('BackBundle:Command')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Command entity.
     *
     * @Route("/", name="command_create")
     * @Method("POST")
     * @Template("BackBundle:Command:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Command();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('command_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a Command entity.
    *
    * @param Command $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Command $entity)
    {
        $form = $this->createForm(new CommandType(), $entity, array(
            'action' => $this->generateUrl('command_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Command entity.
     *
     * @Route("/new", name="command_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Command();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Command entity.
     *
     * @Route("/{id}", name="command_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BackBundle:Command')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Command entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Command entity.
     *
     * @Route("/{id}/edit", name="command_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BackBundle:Command')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Command entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Command entity.
    *
    * @param Command $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Command $entity)
    {
        $form = $this->createForm(new CommandType(), $entity, array(
            'action' => $this->generateUrl('command_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Command entity.
     *
     * @Route("/{id}", name="command_update")
     * @Method("PUT")
     * @Template("BackBundle:Command:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BackBundle:Command')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Command entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('command_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Command entity.
     *
     * @Route("/{id}", name="command_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('BackBundle:Command')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Command entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('command'));
    }

    /**
     * Creates a form to delete a Command entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('command_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
