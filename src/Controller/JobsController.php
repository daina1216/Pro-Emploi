<?php

namespace App\Controller;

use App\Entity\Jobs;
use App\Entity\User;
use App\Form\JobsType;
use App\Repository\JobsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/jobs')]
class JobsController extends AbstractController
{
    #[Route('/', name: 'jobsIndex', methods: ['GET'])]
    public function index(JobsRepository $jobsRepository): Response
    {
        $user = $this->getUser();
        return $this->render('home/accueil.html.twig', [
            'jobs' => $jobsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'createJob', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $job = new Jobs();
        $user = $this->getUser();
        $form = $this->createForm(JobsType::class, $job);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $job->setAuteur($user);
            $entityManager->persist($job);
            $entityManager->flush();

            return $this->redirectToRoute('jobsIndex', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('jobs/new.html.twig', [
            'job' => $job,
            'form' => $form,
        ]);
    }
    

    #[Route('/{id}', name: 'app_jobs_show', methods: ['GET'])]
    public function show(Jobs $job): Response
    {
        return $this->render('jobs/show.html.twig', [
            'job' => $job,
        ]);
    }

    #[Route('/{id}/edit', name: 'jobsEdit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Jobs $job, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(JobsType::class, $job);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('jobsIndex', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('jobs/edit.html.twig', [
            'job' => $job,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'jobsDelete')]
    public function delete(Request $request, Jobs $job, EntityManagerInterface $entityManager): Response
    {

        dd("bonjour");

        if ($this->isCsrfTokenValid('delete'.$job->getId(), $request->request->get('_token'))) {
            $entityManager->remove($job);
            $entityManager->flush();
        }

        return $this->redirectToRoute('jobsIndex');
    }
}
