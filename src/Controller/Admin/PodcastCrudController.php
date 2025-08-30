<?php

namespace App\Controller\Admin;

use App\Entity\Podcast;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;
use EasyCorp\Bundle\EasyAdminBundle\Form\Type\FileUploadType;
use Symfony\Component\Validator\Constraints\File as FileConstraint;

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

        // cover_liip
        yield ImageField::new('coverUrl', 'Image de couverture (upload)')
            ->onlyOnForms()
            ->setBasePath('uploads/covers/')
            ->setUploadDir('public/uploads/covers/')
            ->setUploadedFileNamePattern('[slug]-[timestamp].[extension]')
            ->setRequired(false);

        yield Field::new('coverUrl', 'Cover')
            ->onlyOnIndex()
            ->setTemplatePath('admin/fields/cover_liip.html.twig');

        yield Field::new('coverUrl', 'Cover')
            ->onlyOnDetail()
            ->setTemplatePath('admin/fields/cover_liip.html.twig');

        // Vidéo via URL (YouTube)
        yield UrlField::new('videoUrl', 'Vidéo YouTube (URL)')
            ->onlyOnForms()
            ->setHelp('Accepte : https://youtu.be/ID, https://www.youtube.com/watch?v=ID, /shorts/ID, /embed/ID');

        yield UrlField::new('videoUrl', 'Vidéo YouTube')->onlyOnDetail();

        //Vidéo via upload
        yield Field::new('videoPath', 'Vidéo (upload)')
            ->onlyOnForms()
            ->setFormType(FileUploadType::class)
            ->setFormTypeOptions([
                'upload_dir' => 'public/uploads/videos/',
                'upload_filename' => '[slug]-[timestamp].[extension]',
                'file_constraints' => [
                    new FileConstraint([
                        'maxSize' => '500M',
                        'mimeTypes' => ['video/mp4', 'video/webm'],
                        'mimeTypesMessage' => 'Formats acceptés : MP4 ou WebM.',
                    ]),
                ],
            ])
            ->setHelp('Formats acceptés : MP4, WebM. Taille max 500 Mo.');

        //Aperçu vidéo inline
        $renderVideo = static function ($v) {
            if (!$v) {
                return '—';
            }
            $src = str_starts_with($v, '/') || str_starts_with($v, 'http')
                ? $v
                : '/uploads/videos/' . ltrim($v, '/');

            $esc = htmlspecialchars($src, ENT_QUOTES);
            return sprintf(
                '<video controls preload="metadata" style="max-width:320px;max-height:180px;width:100%%;border-radius:.5rem;">
                    <source src="%1$s" type="video/mp4">
                    <source src="%1$s" type="video/webm">
                    Votre navigateur ne supporte pas la balise vidéo.
                 </video>',
                $esc
            );
        };

        yield Field::new('videoPath', 'Vidéo')
            ->onlyOnIndex()
            ->formatValue($renderVideo);

        yield Field::new('videoPath', 'Vidéo')
            ->onlyOnDetail()
            ->formatValue($renderVideo);

        // ---- Description
        yield TextEditorField::new('description', 'Description')->onlyOnForms();

        yield TextField::new('description', 'Description')
            ->onlyOnIndex()
            ->formatValue(fn($v) => mb_strimwidth(strip_tags($v ?? ''), 0, 80, '…'));

        yield TextEditorField::new('description', 'Description')->onlyOnDetail();

        // ---- Dates
        yield DateTimeField::new('createdAt', 'Created At')->onlyOnIndex();
        yield DateTimeField::new('updatedAt', 'Updated At')->onlyOnDetail();
    }
}
