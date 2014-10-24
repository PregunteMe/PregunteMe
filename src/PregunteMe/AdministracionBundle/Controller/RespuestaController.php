<?php

namespace PregunteMe\AdministracionBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use PregunteMe\AdministracionBundle\Entity\Respuesta;
use PregunteMe\AdministracionBundle\Form\RespuestaType;

/**
 * Respuesta controller.
 *
 */
class RespuestaController extends Controller
{

    /**
     * Lists all Respuesta entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('PregunteMeAdministracionBundle:Respuesta')->findAll();

        return $this->render('PregunteMeAdministracionBundle:Respuesta:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Respuesta entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Respuesta();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_respuesta_show', array('id' => $entity->getId())));
        }

        return $this->render('PregunteMeAdministracionBundle:Respuesta:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Respuesta entity.
     *
     * @param Respuesta $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Respuesta $entity)
    {
        $form = $this->createForm(new RespuestaType(), $entity, array(
            'action' => $this->generateUrl('admin_respuesta_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Respuesta entity.
     *
     */
    public function newAction()
    {
        $entity = new Respuesta();
        $form   = $this->createCreateForm($entity);

        return $this->render('PregunteMeAdministracionBundle:Respuesta:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Respuesta entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PregunteMeAdministracionBundle:Respuesta')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Respuesta entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('PregunteMeAdministracionBundle:Respuesta:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Respuesta entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PregunteMeAdministracionBundle:Respuesta')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Respuesta entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('PregunteMeAdministracionBundle:Respuesta:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Respuesta entity.
    *
    * @param Respuesta $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Respuesta $entity)
    {
        $form = $this->createForm(new RespuestaType(), $entity, array(
            'action' => $this->generateUrl('admin_respuesta_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Respuesta entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PregunteMeAdministracionBundle:Respuesta')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Respuesta entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('admin_respuesta_edit', array('id' => $id)));
        }

        return $this->render('PregunteMeAdministracionBundle:Respuesta:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Respuesta entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('PregunteMeAdministracionBundle:Respuesta')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Respuesta entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_respuesta'));
    }

    /**
     * Creates a form to delete a Respuesta entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_respuesta_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
