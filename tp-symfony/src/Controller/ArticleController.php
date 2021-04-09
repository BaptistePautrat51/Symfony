<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\CommentType;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class ArticleController extends AbstractController
{

    private $articleRepository;

    public function __construct(ArticleRepository $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    /**
     * @Route("/article/{id}", name="show")
     * @param Article $article
     * @param $request

     */
    public function show(Article $article,Request $request): Response
    {
        $article = $this->articleRepository->find($article->getId());
        $commentForm = $this->createForm(CommentType::class);
         $commentForm->handleRequest($request);
         if ($commentForm->isSubmitted() && $commentForm->isValid()) {
            $comment = $commentForm->getData();
            $comment
                ->setArticle($article)
                ->setCreatedAt(new \DateTime())
            ;
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($comment);
            $manager->flush();
            return $this->redirectToRoute('show', ['id' => $article->getId()]);
        }
        return $this->render('article/show.html.twig', [
            'article' => $article,
            'commentForm' => $commentForm->createView()
        ]);
    }
}



/**
 * @Route("/hello/{name}", name="hello_name")
 */
//public function helloName($name)
//{
  //  return new Response('Hello ' . $name);
//}
