<?php
// src/Controller/Admin/ArticleCrudController.php

namespace App\Controller\Admin;

use App\Entity\Article;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;

class ArticleCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Article::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Article')
            ->setEntityLabelInPlural('Articles')
            ->setDefaultSort(['createdAt' => 'DESC'])
            ->showEntityActionsInlined();
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->onlyOnIndex();
        yield TextField::new('title', 'Titre');
        yield UrlField::new('coverUrl', 'Image (URL)')
            ->onlyOnForms();

        yield ImageField::new('coverUrl', 'Cover')
            ->onlyOnIndex()
            ->setBasePath('');
        yield ImageField::new('coverUrl', 'Cover')
            ->onlyOnDetail()
            ->setBasePath('');
        yield TextEditorField::new('content', 'Contenu')->onlyOnForms();
        yield TextField::new('content', 'Contenu')
            ->onlyOnIndex()
            ->formatValue(fn($v) => mb_strimwidth(strip_tags($v ?? ''), 0, 80, '…'));
        yield TextEditorField::new('content', 'Contenu')->onlyOnDetail();
        yield DateTimeField::new('createdAt', 'Created At')->onlyOnIndex();
        yield DateTimeField::new('updatedAt', 'Updated At')->onlyOnDetail();
    }
}
