<?php

namespace PregunteMe\AdministracionBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use PregunteMe\AdministracionBundle\Entity\Indicador;
use PregunteMe\AdministracionBundle\Form\IndicadorType;

/**
 * Indicador controller.
 *
 */
class IndicadorController extends Controller
{

    /**
     * Lists all Indicador entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('PregunteMeAdministracionBundle:Indicador')->findAll();

        return $this->render('PregunteMeAdministracionBundle:Indicador:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Indicador entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Indicador();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_indicador_show', array('id' => $entity->getId())));
        }

        return $this->render('PregunteMeAdministracionBundle:Indicador:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Indicador entity.
     *
     * @param Indicador $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Indicador $entity)
    {
        $form = $this->createForm(new IndicadorType(), $entity, array(
            'action' => $this->generateUrl('admin_indicador_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Indicador entity.
     *
     */
    public function newAction()
    {
        $entity = new Indicador();
        $form   = $this->createCreateForm($entity);

        return $this->render('PregunteMeAdministracionBundle:Indicador:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Indicador entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PregunteMeAdministracionBundle:Indicador')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Indicador entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('PregunteMeAdministracionBundle:Indicador:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Indicador entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PregunteMeAdministracionBundle:Indicador')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Indicador entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('PregunteMeAdministracionBundle:Indicador:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Indicador entity.
    *
    * @param Indicador $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Indicador $entity)
    {
        $form = $this->createForm(new IndicadorType(), $entity, array(
            'action' => $this->generateUrl('admin_indicador_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Indicador entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PregunteMeAdministracionBundle:Indicador')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Indicador entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('admin_indicador_edit', array('id' => $id)));
        }

        return $this->render('PregunteMeAdministracionBundle:Indicador:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Indicador entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('PregunteMeAdministracionBundle:Indicador')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Indicador entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_indicador'));
    }

    /**
     * Creates a form to delete a Indicador entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_indicador_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
