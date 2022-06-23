<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;


class ArticleFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre de l\'annonce',
                'required' => False
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'required' => False,
                'attr' => ['rows' => 5]
            ])
            
            ->add('created_at', DateType::class, [
                'label' => 'Date de l\'annonce',
                'widget' => 'single_text',
                'input'  => 'datetime_immutable',
                'required' => False
            ])
            ->add('prix', IntegerType::class, [
                'label' => 'Prix en €',
                'required' => False
            ])
            ->add('coverFile', VichImageType::class ,
            [
                'label' => 'Image',
                'imagine_pattern' => 'details', // Applique une configuration LiipImagine sur l'image
                'download_label' => false, // Enleve le lien de telechargement
                'delete_label' => 'Cocher pour supprimer l\'image',
                'required'=> false
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
                'label' => 'Nom de la category',
                'required' => False
            ])
            
            
            ->add('save', SubmitType::class, [
                'label' => 'Enregistrer ',
                'attr' => ['class' => 'editButton']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
