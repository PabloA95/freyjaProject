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
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

/**
 * @Route("/producto")
 */
class ProductoController extends Controller
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
        $marca = new Marca();
        $formMarca = $this->createForm(MarcaType::class, $marca);
        $formMarca->handleRequest($request);
        $descripcion = new Descripcion();
        $formDescripcion = $this->createForm(DescripcionType::class, $descripcion);
        $formDescripcion->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('producto_index', ['id' => $producto->getId()]);
        }
        if ($formMarca->isSubmitted() && $formMarca->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($marca);
            $entityManager->flush();
        }
        if ($formDescripcion->isSubmitted() && $formDescripcion->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($descripcion);
            $entityManager->flush();
        }
        return $this->render('producto/edit.html.twig', [
            'producto' => $producto,
            'form' => $form->createView(),
            'marca' => $producto,
            'formMarca' => $formMarca->createView(),
            'descripcion' => $descripcion,
            'formDescripcion' => $formDescripcion->createView(),
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

    /**
     * @Route("/exportar/pdf", name="exportar_pdf")
     */
    public function exportar_pdf()
    {
      $repository = $this->getDoctrine()->getRepository(Producto::class);
      $productos = $repository->findAllOrder();
      $html=$this->renderView('producto/pdf.html.twig', array(
          'productos' => $productos,));
      $pdf=$this->get('knp_snappy.pdf');
      $pdf->setOption('encoding', 'UTF-8');
      $pdfContents=$pdf->getOutputFromHtml($html);
      $response=new Response($pdfContents);
      $response->headers->set('Content-type', 'application/octect-stream');
      $response->headers->set('Content-Disposition', sprintf('attachment; filename="%s"', "Productos-".date('d-m-Y').".pdf"));
      $response->headers->set('Content-Transfer-Encoding', 'binary');
      return $response;
    }

    /**
     * @Route("/exportar/json", name="exportar_json")
     */
    public function exportar_json()
    {
      $encoders = array(new XmlEncoder(), new JsonEncoder());
$normalizers = array(new ObjectNormalizer());

$serializer = new Serializer($normalizers, $encoders);
      $repository = $this->getDoctrine()->getRepository(Producto::class);
      $productos = $repository->findAllOrder();
      // $html=$this->renderView('producto/pdf.html.twig', array(
      //     'productos' => $productos,));
      $jsonContent = $serializer->serialize($productos, 'json');
      //echo $jsonContent;
      $response=new Response($jsonContent);
      $response->headers->set('Content-type', 'application/octect-stream');
      $response->headers->set('Content-Disposition', sprintf('attachment; filename="%s"', "Productos-".date('d-m-Y').".json"));
      $response->headers->set('Content-Transfer-Encoding', 'binary');
      return $response;
    //   // $pdf=$this->get('knp_snappy.pdf');
    //   // $pdf->setOption('encoding', 'UTF-8');
    //   // $pdfContents=$pdf->getOutputFromHtml($html);
    //   // $response=new Response($pdfContents);
    //   // $response->headers->set('Content-type', 'application/octect-stream');
    //   // $response->headers->set('Content-Disposition', sprintf('attachment; filename="%s"', "Productos-".date('d-m-Y').".pdf"));
    //   // $response->headers->set('Content-Transfer-Encoding', 'binary');
    //   // return $response;
    }

}
