<?php

namespace App\Controller;

use App\Entity\Producto;
use App\Entity\Marca;
use App\Entity\Descripcion;
use App\Form\ProductoType;
use App\Form\MarcaType;
use App\Form\DescripcionType;
use App\Repository\ProductoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/producto")
 */
class ProductoController extends AbstractController
{
    /**
     * @Route("/", name="producto_index", methods={"GET"})
     */
    public function index(ProductoRepository $productoRepository): Response
    {
        return $this->render('producto/index.html.twig', ['productos' => $productoRepository->findAll()]);
    }

    /**
     * @Route("/new", name="producto_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $producto = new Producto();
        $form = $this->createForm(ProductoType::class, $producto);
        $form->handleRequest($request);
        $marca = new Marca();
        $formMarca = $this->createForm(MarcaType::class, $marca);
        $formMarca->handleRequest($request);
        $descripcion = new Descripcion();
        $formDescripcion = $this->createForm(DescripcionType::class, $descripcion);
        $formDescripcion->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($producto);
            $entityManager->flush();
            return $this->redirectToRoute('producto_index');
        }
        if ($formMarca->isSubmitted() && $formMarca->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($marca);
            $entityManager->flush();
            return $this->redirectToRoute('producto_new');
        }
        if ($formDescripcion->isSubmitted() && $formDescripcion->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($descripcion);
            $entityManager->flush();
            return $this->redirectToRoute('producto_new');
        }
        return $this->render('producto/new.html.twig', [
            'producto' => $producto,
            'form' => $form->createView(),
            'marca' => $producto,
            'formMarca' => $formMarca->createView(),
            'descripcion' => $descripcion,
            'formDescripcion' => $formDescripcion->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="producto_show", methods={"GET"})
     */
    public function show(Producto $producto): Response
    {
        return $this->render('producto/show.html.twig', ['producto' => $producto]);
    }

    /**
     * @Route("/{id}/edit", name="producto_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Producto $producto): Response
    {
        $form = $this->createForm(ProductoType::class, $producto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('producto_index', ['id' => $producto->getId()]);
        }

        return $this->render('producto/edit.html.twig', [
            'producto' => $producto,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="producto_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Producto $producto): Response
    {
        if ($this->isCsrfTokenValid('delete'.$producto->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($producto);
            $entityManager->flush();
        }

        return $this->redirectToRoute('producto_index');
    }
}
