<?php

namespace Projet2\BackBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Projet2\BackBundle\Entity\Type;
use Projet2\BackBundle\Form\TypeType;

/**
 * Type controller.
 *
 * @Route("/admin/type")
 */
class TypeAdminController extends Controller
{

    /**
     * Lists all Type entities.
     *
     * @Route("/", name="type")
     * @Method("GET")
     * @Template("BackBundle:TypeAdmin:index.html.twig")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('BackBundle:Type')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Type entity.
     *
     * @Route("/", name="type_create")
     * @Method("POST")
     * @Template("BackBundle:TypeAdmin:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Type();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('type_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a Type entity.
    *
    * @param Type $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Type $entity)
    {
        $form = $this->createForm(new TypeType(), $entity, array(
            'action' => $this->generateUrl('type_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Type entity.
     *
     * @Route("/new", name="type_new")
     * @Method("GET")
     * @Template("BackBundle:TypeAdmin:new.html.twig")
     */
    public function newAction()
    {
        $entity = new Type();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Type entity.
     *
     * @Route("/{id}", name="type_show")
     * @Method("GET")
     * @Template("BackBundle:TypeAdmin:show.html.twig")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BackBundle:Type')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Type entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Type entity.
     *
     * @Route("/{id}/edit", name="type_edit")
     * @Method("GET")
     * @Template("BackBundle:TypeAdmin:edit.html.twig")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BackBundle:Type')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Type entity.');
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
    * Creates a form to edit a Type entity.
    *
    * @param Type $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Type $entity)
    {
        $form = $this->createForm(new TypeType(), $entity, array(
            'action' => $this->generateUrl('type_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Type entity.
     *
     * @Route("/{id}", name="type_update")
     * @Method("PUT")
     * @Template("BackBundle:TypeAdmin:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BackBundle:Type')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Type entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('type_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Type entity.
     *
     * @Route("/{id}", name="type_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('BackBundle:Type')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Type entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('type'));
    }

    /**
     * Creates a form to delete a Type entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('type_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
