<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;

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

        $coverForIndex = Field::new('coverUrl', 'Cover')
            ->onlyOnIndex()
            ->setTemplatePath('admin/fields/cover_liip.html.twig');

        $coverForDetail = Field::new('coverUrl', 'Cover')
            ->onlyOnDetail()
            ->setTemplatePath('admin/fields/cover_liip.html.twig');

        $coverForForm = ImageField::new('coverUrl', 'Image de couverture (upload)')
            ->onlyOnForms()
            ->setBasePath('uploads/covers/')
            ->setUploadDir('public/uploads/covers/')
            ->setUploadedFileNamePattern('[slug]-[timestamp].[extension]')
            ->setRequired(false);

        yield IdField::new('id')->onlyOnIndex();
        yield TextField::new('title', 'Titre');

        yield $coverForForm;
        yield $coverForIndex;
        yield $coverForDetail;

        yield TextEditorField::new('content', 'Contenu')->onlyOnForms();
        yield TextField::new('content', 'Contenu')
            ->onlyOnIndex()
            ->formatValue(fn($v) => mb_strimwidth(strip_tags($v ?? ''), 0, 80, '…'));
        yield TextEditorField::new('content', 'Contenu')->onlyOnDetail();

        yield DateTimeField::new('createdAt', 'Created At')->onlyOnIndex();
        yield DateTimeField::new('updatedAt', 'Updated At')->onlyOnDetail();
    }
}
