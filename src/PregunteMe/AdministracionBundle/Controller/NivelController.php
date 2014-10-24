<?php

namespace PregunteMe\AdministracionBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use PregunteMe\AdministracionBundle\Entity\Nivel;
use PregunteMe\AdministracionBundle\Form\NivelType;

/**
 * Nivel controller.
 *
 */
class NivelController extends Controller
{

    /**
     * Lists all Nivel entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('PregunteMeAdministracionBundle:Nivel')->findAll();

        return $this->render('PregunteMeAdministracionBundle:Nivel:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Nivel entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Nivel();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_nivel_show', array('id' => $entity->getId())));
        }

        return $this->render('PregunteMeAdministracionBundle:Nivel:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Nivel entity.
     *
     * @param Nivel $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Nivel $entity)
    {
        $form = $this->createForm(new NivelType(), $entity, array(
            'action' => $this->generateUrl('admin_nivel_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Nivel entity.
     *
     */
    public function newAction()
    {
        $entity = new Nivel();
        $form   = $this->createCreateForm($entity);

        return $this->render('PregunteMeAdministracionBundle:Nivel:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Nivel entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PregunteMeAdministracionBundle:Nivel')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Nivel entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('PregunteMeAdministracionBundle:Nivel:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Nivel entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PregunteMeAdministracionBundle:Nivel')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Nivel entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('PregunteMeAdministracionBundle:Nivel:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Nivel entity.
    *
    * @param Nivel $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Nivel $entity)
    {
        $form = $this->createForm(new NivelType(), $entity, array(
            'action' => $this->generateUrl('admin_nivel_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Nivel entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PregunteMeAdministracionBundle:Nivel')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Nivel entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('admin_nivel_edit', array('id' => $id)));
        }

        return $this->render('PregunteMeAdministracionBundle:Nivel:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Nivel entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('PregunteMeAdministracionBundle:Nivel')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Nivel entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_nivel'));
    }

    /**
     * Creates a form to delete a Nivel entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_nivel_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
