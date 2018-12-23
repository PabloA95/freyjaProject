<?php

namespace App\Form;

use App\Entity\Producto;
use App\Entity\Marca;
use App\Entity\Descripcion;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ProductoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('codigo')
            ->add('precioEfectivo')
            ->add('precioTarjeta')
            ->add('precioCompra')
            ->add('estado')
            ->add('stock')
            ->add('codigoBarra')
            ->add('marca', EntityType::class, array(
              'class' => Marca::class,
              'label'    => 'Marca',
              'attr' => array('class' => 'form-control'),
              'placeholder' => 'Elija una opción',
              'choice_label' => function ($tipoDocumento){
                  return $tipoDocumento->getDescripcion();
                },
            ))
            ->add('descripcion', EntityType::class, array(
              'class' => Descripcion::class,
              'label'    => 'Descripcion',
              'attr' => array('class' => 'form-control'),
              'placeholder' => 'Elija una opción',
              'choice_label' => function ($tipoDocumento){
                  return $tipoDocumento->getDescripcion();
                },
              // 'query_builder' => function ($tipoDocumento) {
              //   return $tipoDocumento->createQueryBuilder('t')
              //     ->where('t.activo = 1');
              // },
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Producto::class,
        ]);
    }
}
