<?php

namespace App\Controller\Admin;


use App\Entity\Post;
use DateTime;
use DateTimeInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField as FieldAssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\BooleanFilter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

  #[IsGranted('ROLE_EDITOR')]
class PostCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Post::class;
    }


   public function configureFields(string $pageName): iterable
    {
      return [
    
            yield TextField::new('titre'),
       yield TextField::new('description'), 
       yield TextField::new('contenu'),
       yield DateField::new('CreatedAt'),
       yield FieldAssociationField::new('category'),
            yield ImageField::new('imageFileName')->setBasePath('uploads/images')->setUploadDir('public/uploads/images'),
            
        ]; }  
   
        public function configureFilters(Filters $filters): Filters
    {

        return $filters
        ->add('id')
            ->add('Titre')
            ->add('Description')
            ->add('CreatedAt')
            ->add('Contenu')
            ->add('imageFileName');    
    }
}
