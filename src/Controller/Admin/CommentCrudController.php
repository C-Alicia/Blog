<?php

namespace App\Controller\Admin;

use App\Entity\Comment;
use DateTime;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[IsGranted('ROLE_MODERATEUR')] 

class CommentCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Comment::class;
    }

   
    public function configureFields(string $pageName): iterable
    {
      /*   return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ]; */
    
        return [
            IdField::new('id'),
            TextField::new('autorname'),
            TextField::new('content'),
            DateTimeField::new('createdAt'),
            AssociationField::new('user')
         ];
        
    }
 
    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('id')
            ->add('autorname')
            ->add('content')
            ->add('createdAt');
    }
}
