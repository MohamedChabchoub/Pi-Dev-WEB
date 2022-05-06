<?php
namespace App\Controller;
use App\Entity\Article;

use App\Entity\CategorieArticle;
use App\Entity\FavorisArticle;
use App\Entity\User ;
use App\Entity\Gouvernorat;
use App\Form\CategoryType;
use App\Form\ArticleType;

use App\Form\ArticleFormType;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\String\Slugger\SluggerInterface;
use MercurySeries\FlashyBundle\FlashyNotifier;

class ArticleController extends AbstractController
{

    /**
     * @Route("/article/detail/{id}/",name="detail_article")
     */
    public function artDetail(Request $request, $id,ManagerRegistry $doctrine) {
        $article = $this->getDoctrine()->getRepository(Article::class)->find($id);


        
        return $this->render('article/Detail.html.twig', [
            'art' => $article,
        ]);
    }

    
       /* Tableau des articles
     /**
     *@Route("/admin/article/",name="Tableau_Article")
     */
    public function index(ManagerRegistry $doctrine)
    {

      $article = $doctrine->getRepository(Article::class)->findAll();



      return $this->render('article/index.html.twig', [
        'article' => $article,
    ]);
    }

    /**
    *@Route(path="/admin/article/note/", name="noter_application")
    */
    public function note(ManagerRegistry $doctrine)
    {
      $article = $doctrine->getRepository(Article::class)->findAll();

      return $this->render('article/starGrade.html.twig', [
        'article' => $article,
    ]);
    }

    /**
     * @Route("/admin/new-article/", name="new_article")
     * Method({"GET", "POST"})
     */
    public function new(Request $request, SluggerInterface $slugger, FlashyNotifier $flashy)
    {
        $article = new Article();
        $article->setDatePublication(new \DateTime('now'));
        $form = $this->createFormBuilder($article)
            ->add('titre', TextType::class)
            ->add('description', TextType::class)
            ->add('etat', TextType::class)
            ->add('image', FileType::class)
            ->add('idCategorie', EntityType::class, [
          'class' => CategorieArticle::class,
          'query_builder' => function (EntityRepository $er) {
              return $er->createQueryBuilder('u')
                  ->orderBy('u.typeCategorie', 'ASC');
          },
          'choice_label' => 'typeCategorie',
      ])

      ->add('idGouvernorat', EntityType::class, [
        'class' => Gouvernorat::class,
        'query_builder' => function (EntityRepository $er) {
            return $er->createQueryBuilder('u')
                ->orderBy('u.nom', 'ASC');
        },
        'choice_label' => 'nom',
      ])

      ->add('idProprietaire', EntityType::class, [
        'class' => User::class,
        'query_builder' => function (EntityRepository $er) {
            return $er->createQueryBuilder('u')
                ->orderBy('u.nom', 'ASC');
        },
        'choice_label' => 'nom',
      ])



        ->add('save', SubmitType::class, array(
          'label' => 'Créer')


          )->getForm();



      $form->handleRequest($request);

      if($form->isSubmitted() && $form->isValid()) {
        $imagefile = $form->get('image')->getData();
            if($imagefile){
                $originalFilename = pathinfo($imagefile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$imagefile->guessExtension();
                $imagefile->move($this->getParameter('images_directory'),$newFilename);
                $article->setImage($newFilename);

            }

        $article = $form->getData();

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($article);
        $entityManager->flush();
        $flashy->success(' Article bien ajouté ' );


        return $this->redirectToRoute('Tableau_Article');

      }
      return $this->render('article/new.html.twig',['form' => $form->createView()]);
    }




  /**
     * @Route("/article/edit/{id}/", name="modifier_article")
     * Method({"GET", "POST"})
     */
    public function edit(Request $request, $id, ManagerRegistry $doctrine, SluggerInterface $slugger,FlashyNotifier $flashy )
    {
     
        $article = $this->getDoctrine()->getRepository(Article::class)->find($id);
        if ($article) {
            $form = $this->createFormBuilder($article)
                ->add('titre', TextType::class)
                ->add('description', TextType::class)
                ->add('etat', TextType::class)
                /*->add('proprietaire', TextType::class) */
                /*->add('image', FileType::class , array('data_class' => null)) */
                ->add('etat', TextType::class)
                ->add('idCategorie', EntityType::class, [
                    'class' => CategorieArticle::class,
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('u')
                            ->orderBy('u.typeCategorie', 'ASC');
                    },
                    'choice_label' => 'typeCategorie',
                ])
                ->add('idGouvernorat', EntityType::class, [
                    'class' => Gouvernorat::class,
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('u')
                            ->orderBy('u.nom', 'ASC');
                    },
                    'choice_label' => 'nom',
                ])
                ->add('idProprietaire', EntityType::class, [
                    'class' => User::class,
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('u')
                            ->orderBy('u.nom', 'ASC');
                    },
                    'choice_label' => 'nom',
                ])
                ->add('save', SubmitType::class, array(
                    'label' => 'Modifier'
                ))->getForm();

            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
             

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->flush();
                $flashy->info(' Article bien modifié ' );

                $article = $doctrine->getRepository(Article::class)->findAll();
                return $this->render('article/index.html.twig', [
                    'article' => $article,
                ]);
            }
            return $this->render('article/edit.html.twig', ['form' => $form->createView()]);
        }
    }



       /**
     * @Route("/article/delete/{id}/",name="delete_article")
     * @Method({"DELETE"})
     */
    public function delete(Request $request, $id,ManagerRegistry $doctrine,FlashyNotifier $flashy ) {
        $article = $this->getDoctrine()->getRepository(Article::class)->find($id);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($article);
        $entityManager->flush();
        $flashy->error(' Article supprimé ' );

  
        $response = new Response();
        $response->send();
  
        $article = $doctrine->getRepository(Article::class)->findAll();
        return $this->render('article/index.html.twig', [
            'article' => $article,
        ]);
  
        //return $this->redirectToRoute('Tableau_Article:');
      }





    /**
     * @Route(path="/admin/favorite",name="favorite_article")
     */
    public function favoriteArticle(Request $request, FlashyNotifier $flashy): Response
    {
        $id_article = $request->get('id');
        $user = $request->get('current_user');
        $response = [];
        try {
            $entityManager = $this->getDoctrine()->getManager();
            /** @var Article $article */
            $article = $this->getDoctrine()->getRepository(Article::class)->find($id_article);
            $user = $this->getDoctrine()->getRepository('App\\Entity\\User')->findOneBy(['idUser' => $user]);
            if($user){
                $favorite = $this->getDoctrine()->getRepository(FavorisArticle::class)->findOneBy(['idArticle' => $id_article, 'idUtilisateur' => $user]);
                if(!$favorite){
                    $favorite = new FavorisArticle();
                    $favorite->setIdArticle($article);
                    $favorite->setIdUtilisateur($user);
                    $entityManager->persist($article);
                    $response['state'] = true;
                    $flashy->success('Article is successfully added' );
                } else {
                    $flashy->error('Error occurred while adding to favorites, please try again' );
                    $entityManager->remove($favorite);
                    $response['state'] = false;
                }
                $entityManager->flush();
            } else {
                //ToDo redirect Login
            }
        } catch (\Exception $e) {
            $flashy->error('Error occurred while adding to favorites, please try again' );
            $response['state'] = false;
            $response['message'] = $e->getMessage();
        }
        return new JsonResponse($response);
    }

    /**
     * @Route("/admin/list_favorite/",name="list_favorite")
     */
    public function list_favorite(Request $request) {
        $user = $request->get('userId');
        $favorites = $this->getDoctrine()->getRepository(FavorisArticle::class)->findBy(['userId' => $user]);
        return $this->render('article/Detail.html.twig', [
            'favorites' => $favorites,
        ]);

    }
}