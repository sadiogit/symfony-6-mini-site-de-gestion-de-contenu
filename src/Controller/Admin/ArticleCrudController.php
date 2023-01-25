<?php

namespace App\Controller\Admin;

use DateTime;
use App\Entity\Article;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ArticleCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Article::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud->setDefaultSort(['id' => 'DESC']);
    }
    public function configureFields(string $pageName): iterable
    {
    
        
        yield TextField::new('title');

        yield SlugField::new('slug')
            ->setTargetFieldName('title');

        yield TextEditorField::new('content');
        
        yield TextField::new('featuredText');

        yield AssociationField::new('categories');

        //yield DateTimeField::new('createdAt')->hideOnForm();
        yield DateTimeField::new('createdAt', 'dta crea')->renderAsNativeWidget(false);
        //yield TimeField::new('createdAt')->setFormat(DateTimeField::FORMAT_LONG);
        //yield DateTimeField::new('createdAt', 'dta crea');
        
        yield DateTimeField::new('updatedAt')->hideOnForm();    

/*
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('title', 'titre'),
            SlugField::new('slug')->setTargetFieldName('title'),
            TextField::new('featuredText', 'Feture'),
            TextEditorField::new('content', 'description'),
            DateTimeField::new('createdAt', 'créer le'),
            DateTimeField::new('updatedAt', 'Modifier le')->hideOnForm(),

        ];
*/
    }
    
}
