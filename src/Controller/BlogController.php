<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use App\Entity\Article;
use App\Entity\Category;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    private $repoArticle;
    private $repoCategory;
    public function __construct(ArticleRepository $repoArticle, CategoryRepository $repoCategory)
    {
        $this->repoArticle = $repoArticle;
        $this->repoCategory = $repoCategory;
    }

    /**
     * @Route("blog", name="blog")
     */
    public function index(): Response
    {

        // $repo = $this->getDoctrine()->getRepository(Article::class);
        $articles = $this->repoArticle->findAll();
        $categories = $this->repoCategory->findAll();
        return $this->render('blog/index.html.twig', [
            'articles' => $articles,
            'categories' => $categories,
        ]);
    }

    /**
     * @Route("blog/show/{id}", name="show")
     */
    public function show(Article $article): Response
    {

        // $repo = $this->getDoctrine()->getRepository(Article::class);
        // $article = $this->repoArticle->find($id);

        if (!$article) {
            return $this->redirectToRoute('home');
        }

        return $this->render('show/index.html.twig', [
            'article' => $article,
        ]);
    }

    /**
     * @Route("showArticles/{id}", name="show_article")
     */
    public function showArticle(?Category $category): Response
    {

        if ($category) {
            $articles = $category->getArticles()->getValues();
        } else {
            return $this->redirectToRoute('home');
        }
        $categories = $this->repoCategory->findAll();

        // $articles = $category->getArticles()->getValues();
        // dd($articles);

        return $this->render('show/showArticle.html.twig', [
            'articles' => $articles,
            'categories' => $categories,
        ]);
    }
}
