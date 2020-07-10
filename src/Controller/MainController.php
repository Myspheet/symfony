<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index()
    {
        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

    /**
     * @Route("/about", name="about")
     */
    public function about()
    {
        return $this->render('main/about.html.twig');
    }

    /**
     * @Route("/blog", name="blog")
     */
    public function blog()
    {
        $blog_post = [
            'category' => 'LIFESTYLE',
            'title' => 'Donec Tincidunt Leo',
            'user' => 'Admin',
            'image' => 'blog-thumb-01.jpg',
            'createdAt' => 'May 31, 2020',
            'body' => 'Nullam nibh mi, tincidunt sed sapien ut, rutrum hendrerit velit. Integer auctor a mauris sit amet eleifend.',
            'tags' => array('best', 'post'),
        ];
        $blog_post2 = [
            'category' => 'Freedom',
            'title' => 'Donec Tincidunt Leo',
            'user' => 'Admin',
            'image' => 'blog-thumb-01.jpg',
            'createdAt' => 'May 31, 2020',
            'body' => 'Nullam nibh mi, tincidunt sed sapien ut, rutrum hendrerit velit. Integer auctor a mauris sit amet eleifend.',
            'tags' => array('best', 'post'),
        ];
        $posts = array($blog_post, $blog_post2);
        return $this->render('main/blog.html.twig', ['posts' => $posts]);
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function contact()
    {
        return $this->render('main/contact.html.twig');
    }
}
