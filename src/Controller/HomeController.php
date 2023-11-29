<?php

namespace App\Controller;

use App\Entity\Postuler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\JobsRepository;
use App\Repository\PostulerRepository;
use Doctrine\ORM\EntityManagerInterface;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(JobsRepository $jobsRepo): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'jobs' => $jobsRepo->findAll(),
        ]);
    }

    #[Route('/accueil', name: 'homePage')]
    public function accueil(JobsRepository $jobsRepository, PostulerRepository $postulerRepo): Response
    {


        return $this->render('home/accueil.html.twig', [
            'jobs'=> $jobsRepository->findAll(),
            
        ]);
    }

  

    #[Route('/accueil/{id}/postuler', name: 'postuler')]
    public function postuler(JobsRepository $jobsRepository, $id, EntityManagerInterface $entityManager): Response
    {

        $job = $jobsRepository->findOneById($id);

        $user = $this->getUser();

        $poste = new Postuler();
        $poste->setAuteur($user);
        $poste->setOffres($job);

        $entityManager->persist($poste);
        $entityManager->flush();

        return $this->redirectToRoute('homePage', [], Response::HTTP_SEE_OTHER);
    }



}
