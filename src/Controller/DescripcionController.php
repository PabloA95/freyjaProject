<?php

namespace App\Controller;

use App\Entity\Descripcion;
use App\Entity\Producto;
use App\Form\DescripcionType;
use App\Repository\DescripcionRepository;
use App\Repository\ProductoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/descripcion")
 */
class DescripcionController extends AbstractController
{
    /**
     * @Route("/", name="descripcion_index", methods={"GET"})
     */
    public function index(DescripcionRepository $descripcionRepository): Response
    {
        return $this->render('descripcion/index.html.twig', ['descripcions' => $descripcionRepository->findAll()]);
    }

    /**
     * @Route("/new", name="descripcion_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $descripcion = new Descripcion();
        $form = $this->createForm(DescripcionType::class, $descripcion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($descripcion);
            $entityManager->flush();

            return $this->redirectToRoute('descripcion_index');
        }

        return $this->render('descripcion/new.html.twig', [
            'descripcion' => $descripcion,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="descripcion_show", methods={"GET"})
     */
    public function show(Descripcion $descripcion): Response
    {
        return $this->render('descripcion/show.html.twig', ['descripcion' => $descripcion]);
    }

    /**
     * @Route("/{id}/edit", name="descripcion_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Descripcion $descripcion): Response
    {
        $form = $this->createForm(DescripcionType::class, $descripcion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('descripcion_index', ['id' => $descripcion->getId()]);
        }

        return $this->render('descripcion/edit.html.twig', [
            'descripcion' => $descripcion,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="descripcion_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Descripcion $descripcion): Response
    {
        $errno=array();
        if ($this->isCsrfTokenValid('delete'.$descripcion->getId(), $request->request->get('_token'))) {
          $repository = $this->getDoctrine()->getRepository(Producto::class);
          $result=$productos = $repository->findBy(array('descripcion'=>$descripcion->getId()));
          if(count($result)==0){
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($descripcion);
            $entityManager->flush();
            return $this->redirectToRoute('descripcion_index');
          } else {
            $errno[0]='No se puede eleminar esta descripcion porque tiene productos asociados';
            return $this->render('descripcion/show.html.twig', ['descripcion' => $descripcion, 'errno'=>$errno]);
          }
        } else {
          return $this->redirectToRoute('descripcion_index');
        }

    }
}
