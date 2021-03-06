<?php

namespace App\Form;

use App\Entity\Produit;
use App\Entity\Commande;
use App\Entity\Lignecommande;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LignecommandeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('quantite')
            ->add('produit', EntityType::class, [
                'class' => Produit::class,
                'choice_label' => 'nom',
                'query_builder' => function(EntityRepository $entityRepository) use ($options){
                    $qb = $entityRepository->createQueryBuilder('u');

                    return $qb
                        ->where("u.pointVente ="  .$options['id'])
                        ->orderBy('u.nom', 'ASC');
                },
                
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Lignecommande::class,
            'id' =>0,
        ]);
    }
}
