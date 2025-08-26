<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Article;
use App\Entity\LiveStream;
use App\Entity\Podcast;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $passwordHasher) {}

    public function load(ObjectManager $manager): void
    {
        // Creation user pour backoffice
        $user = new User();
        $user->setUsername('Admin');
        $user->setPassword($this->passwordHasher->hashPassword($user, 'password'));
        $manager->flush();

        //Creation Article
        $data = [
            [
                'title' => 'Radio4You : lancement officiel de la station',
                'content' => "Radio4You débarque avec une promesse simple : des hits non-stop, des émissions proches des auditeurs et des rendez-vous locaux.\n\nAu programme : matinale énergique, sélections thématiques l’après-midi et sessions live le week-end. Dites-nous ce que vous voulez entendre, on s’occupe du reste !",
            ],
            [
                'title' => 'La matinale « Réveil en douceur »',
                'content' => "Du lundi au vendredi, 6h–9h, on vous accompagne avec des nouveautés, la météo des régions et les infos pratiques.\n\nPartagez vos messages vocaux : les meilleurs passent à l’antenne chaque matin.",
            ],
            [
                'title' => 'Top 20 : la playlist de la semaine',
                'content' => "Chaque dimanche, notre équipe publie le classement des 20 titres les plus diffusés sur Radio4You.\n\nVotez sur les réseaux : vos coups de cœur peuvent faire bouger le podium dès la semaine suivante.",
            ],
            [
                'title' => 'Sessions live : artistes en studio',
                'content' => "Nous ouvrons nos portes aux artistes émergents pour des sessions acoustiques exclusives, captées en audio et en vidéo.\n\nAbonnez-vous à nos podcasts pour ne rater aucune performance.",
            ],
            [
                'title' => 'Votre ville à l’antenne',
                'content' => "Agenda concerts, événements sportifs, vie associative : envoyez-nous vos infos, on relaie à l’antenne et sur le site.\n\nRadio4You, la radio qui parle de vous, près de chez vous.",
            ],
            [
                'title' => 'Technologie : un player radio tout neuf',
                'content' => "Notre nouveau player s’adapte à toutes les connexions et affiche le titre en cours en temps réel.\n\nCompatible mobile, CarPlay et Android Auto pour vous suivre partout.",
            ],
            [
                'title' => 'Coulisses : comment on choisit les titres',
                'content' => "Entre pépites découvertes et hits confirmés, la ligne musicale est construite chaque semaine par notre équipe de programmation.\n\nVos suggestions comptent : proposez vos titres via le formulaire dédié.",
            ],
            [
                'title' => 'Concours auditeurs : places de concert',
                'content' => "Inscrivez-vous au tirage hebdomadaire et tentez de gagner des places pour les concerts de la saison.\n\nRèglement, dates et résultats seront publiés sur la page concours.",
            ],
            [
                'title' => 'Newsletter Radio4You',
                'content' => "Recevez chaque vendredi l’actualité de la station : nouveaux podcasts, invités, événements et bons plans.\n\nInscription gratuite, désinscription en un clic.",
            ],
        ];
        foreach ($data as $a) {
            $article = new Article();
            $article->setTitle($a['title']);
            $article->setContent($a['content']);
            $article->setCoverUrl('https://picsum.photos/200');
            $manager->persist($article);
        }
        $manager->flush();

        //Creation Podcast
        $data = [
            [
                'title' => 'Radio4You - Présentation de la saison',
                'description' => "Tour d’horizon des nouvelles émissions, des invités à venir et des formats vidéo.",
                'videoUrl' => 'https://www.youtube.com/watch?v=-DfHaOYeaqk&list=RD-DfHaOYeaqk&start_radio=1',
                'coverUrl' => 'https://picsum.photos/201'
            ],
            [
                'title' => 'La playlist de la semaine',
                'description' => "Comment on construit notre grille : tendances, coups de coeur, nouvelle sortie...",
                'videoUrl' => 'https://www.youtube.com/watch?v=pLcw3dK1yU0&list=RDpLcw3dK1yU0&start_radio=1',
                'coverUrl' => 'https://picsum.photos/202'
            ],
        ];
        foreach ($data as $p) {
            $podcast = new Podcast();
            $podcast->setTitle($p['title']);
            $podcast->setDescription($p['description']);
            $podcast->setVideoUrl($p['videoUrl']);
            $podcast->setCoverUrl($p['coverUrl']);
            $manager->persist($podcast);
        }
        $manager->flush();
    }
}
