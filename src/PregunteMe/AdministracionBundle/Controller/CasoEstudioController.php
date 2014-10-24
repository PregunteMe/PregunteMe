<?php

namespace PregunteMe\AdministracionBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use PregunteMe\AdministracionBundle\Entity\CasoEstudio;
use PregunteMe\AdministracionBundle\Form\CasoEstudioType;

/**
 * CasoEstudio controller.
 *
 */
class CasoEstudioController extends Controller
{

    /**
     * Lists all CasoEstudio entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('PregunteMeAdministracionBundle:CasoEstudio')->findAll();

        return $this->render('PregunteMeAdministracionBundle:CasoEstudio:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new CasoEstudio entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new CasoEstudio();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_casoEstudio_show', array('id' => $entity->getId())));
        }

        return $this->render('PregunteMeAdministracionBundle:CasoEstudio:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a CasoEstudio entity.
     *
     * @param CasoEstudio $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(CasoEstudio $entity)
    {
        $form = $this->createForm(new CasoEstudioType(), $entity, array(
            'action' => $this->generateUrl('admin_casoEstudio_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new CasoEstudio entity.
     *
     */
    public function newAction()
    {
        $entity = new CasoEstudio();
        $form   = $this->createCreateForm($entity);

        return $this->render('PregunteMeAdministracionBundle:CasoEstudio:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a CasoEstudio entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PregunteMeAdministracionBundle:CasoEstudio')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CasoEstudio entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('PregunteMeAdministracionBundle:CasoEstudio:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing CasoEstudio entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PregunteMeAdministracionBundle:CasoEstudio')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CasoEstudio entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('PregunteMeAdministracionBundle:CasoEstudio:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a CasoEstudio entity.
    *
    * @param CasoEstudio $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(CasoEstudio $entity)
    {
        $form = $this->createForm(new CasoEstudioType(), $entity, array(
            'action' => $this->generateUrl('admin_casoEstudio_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing CasoEstudio entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PregunteMeAdministracionBundle:CasoEstudio')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CasoEstudio entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('admin_casoEstudio_edit', array('id' => $id)));
        }

        return $this->render('PregunteMeAdministracionBundle:CasoEstudio:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a CasoEstudio entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('PregunteMeAdministracionBundle:CasoEstudio')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find CasoEstudio entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_casoEstudio'));
    }

    /**
     * Creates a form to delete a CasoEstudio entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_casoEstudio_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
