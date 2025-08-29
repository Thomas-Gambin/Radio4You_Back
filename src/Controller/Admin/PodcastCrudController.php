<?php
// src/Controller/Admin/PodcastCrudController.php

namespace App\Controller\Admin;

use App\Entity\Podcast;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;

class PodcastCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Podcast::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Podcast')
            ->setEntityLabelInPlural('Podcasts')
            ->setDefaultSort(['createdAt' => 'DESC'])
            ->showEntityActionsInlined();
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->onlyOnIndex();
        yield TextField::new('title', 'Titre');
        yield UrlField::new('coverUrl', 'Image (URL)')->onlyOnForms();
        yield ImageField::new('coverUrl', 'Cover')
            ->onlyOnIndex()
            ->setBasePath('');
        yield ImageField::new('coverUrl', 'Cover')
            ->onlyOnDetail()
            ->setBasePath('');
        yield UrlField::new('audioUrl', 'Audio (URL)')->onlyOnForms();
        yield TextEditorField::new('description', 'Description')->onlyOnForms();
        yield TextField::new('description', 'Description')
            ->onlyOnIndex()
            ->formatValue(fn($v) => mb_strimwidth(strip_tags($v ?? ''), 0, 80, '…'));
        yield TextEditorField::new('description', 'Description')->onlyOnDetail();
        yield DateTimeField::new('createdAt', 'Created At')->onlyOnIndex();
        yield DateTimeField::new('updatedAt', 'Updated At')->onlyOnDetail();
    }
}
