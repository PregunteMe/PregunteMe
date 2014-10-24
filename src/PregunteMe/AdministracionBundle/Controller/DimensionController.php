<?php

namespace PregunteMe\AdministracionBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use PregunteMe\AdministracionBundle\Entity\Dimension;
use PregunteMe\AdministracionBundle\Form\DimensionType;

/**
 * Dimension controller.
 *
 */
class DimensionController extends Controller
{

    /**
     * Lists all Dimension entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('PregunteMeAdministracionBundle:Dimension')->findAll();

        return $this->render('PregunteMeAdministracionBundle:Dimension:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Dimension entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Dimension();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_dimension_show', array('id' => $entity->getId())));
        }

        return $this->render('PregunteMeAdministracionBundle:Dimension:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Dimension entity.
     *
     * @param Dimension $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Dimension $entity)
    {
        $form = $this->createForm(new DimensionType(), $entity, array(
            'action' => $this->generateUrl('admin_dimension_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Dimension entity.
     *
     */
    public function newAction()
    {
        $entity = new Dimension();
        $form   = $this->createCreateForm($entity);

        return $this->render('PregunteMeAdministracionBundle:Dimension:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Dimension entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PregunteMeAdministracionBundle:Dimension')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Dimension entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('PregunteMeAdministracionBundle:Dimension:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Dimension entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PregunteMeAdministracionBundle:Dimension')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Dimension entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('PregunteMeAdministracionBundle:Dimension:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Dimension entity.
    *
    * @param Dimension $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Dimension $entity)
    {
        $form = $this->createForm(new DimensionType(), $entity, array(
            'action' => $this->generateUrl('admin_dimension_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Dimension entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PregunteMeAdministracionBundle:Dimension')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Dimension entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('admin_dimension_edit', array('id' => $id)));
        }

        return $this->render('PregunteMeAdministracionBundle:Dimension:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Dimension entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('PregunteMeAdministracionBundle:Dimension')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Dimension entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_dimension'));
    }

    /**
     * Creates a form to delete a Dimension entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_dimension_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
