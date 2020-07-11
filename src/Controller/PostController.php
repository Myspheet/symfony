<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostFormType;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("dashboard", name="dashboard.")
 */
class PostController extends AbstractController
{
    /**
     * @Route("/", name="posts")
     */
    public function index()
    {
        $posts = $this->getUser()->getPosts();
        return $this->render('post/index.html.twig', [
            'controller_name' => 'PostController',
            'posts' => $posts
        ]);
    }

    /**
     * @Route("/post/create", name="create")
     */
    public function create(Request $request)
    {
        $post = new Post();
        $form = $this->createForm(PostFormType::class, $post);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();
            $file = $form->get('image')->getData();
            if ($file) {
                $filename = md5(uniqid()) . "." . $file->guessClientExtension();

                $file->move(
                    $this->getParameter('upload_dirs'),
                    $filename
                );
                $post->setImage($filename);
            }
            $post->setTags(explode(" ", $form->get('tags')->getData()));
            $post->setUser($user);
            $post->setPublished(true);
            $post->setCreatedAt(new \DateTime());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($post);
            $entityManager->flush();

            return $this->redirect($this->generateUrl('dashboard.posts'));
        }

        return $this->render('post/create.html.twig', ['postForm' => $form->createView()]);
    }

    /**
     * @Route("/post/edit/{id}", name="edit")
     */
    public function edit($id, PostRepository $postRepository, Request $request)
    {

        $post = $postRepository->find($id);
        $form = $this->createForm(PostFormType::class, $post);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form->get('image')->getData();
            if ($file) {
                $filename = md5(uniqid()) . "." . $file->guessClientExtension();

                $file->move(
                    $this->getParameter('upload_dirs'),
                    $filename
                );
                $post->setImage($filename);
            }
            $post->setTags(explode(" ", $form->get('tags')->getData()));
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($post);
            $entityManager->flush();

            return $this->redirect($this->generateUrl('dashboard.posts'));
        }

        return $this->render('post/edit.html.twig', ['editForm' => $form->createView()]);
    }

    /**
     * @Route("/post/delete/{id}", name="delete")
     */
    public function delete(Post $post)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($post);
        $em->flush();
        return $this->redirect($this->generateUrl('dashboard.posts'));
    }
}
