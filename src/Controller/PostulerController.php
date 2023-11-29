<?php

namespace App\Controller;

use App\Repository\JobsRepository;
use App\Entity\Postuler;
use App\Form\PostulerType;
use App\Repository\PostulerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/postuler')]
class PostulerController extends AbstractController
{
    #[Route('/', name: 'postulerIndex', methods: ['GET'])]
    public function index(PostulerRepository $postulerRepository): Response
    {
        return $this->render('postuler/index.html.twig', [
            'postulers' => $postulerRepository->findAll(),
        ]);
    }

    #[Route('/notif', name: 'postulerNotif', methods: ['GET'])]
    public function notifs(PostulerRepository $postulerRepository): Response
    {
        return $this->render('postuler/notifications.html.twig', [
            'postulers' => $postulerRepository->findAll(),
        ]);
    }

    #[Route('/{id}/postuler a une offre', name: 'createPostuler', methods: ['GET', 'POST'])]
    public function new(JobsRepository $jobsRepository, $id, Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {

        $postuler = new Postuler();
        $form = $this->createForm(PostulerType::class, $postuler);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $job = $jobsRepository->findOneById($id);

            $user = $this->getUser();
            $postuler->setAuteur($user);
            $postuler->setOffres($job);

            $PDF = $form->get('fichierPDF')->getData();

            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($PDF) {
                $originalFilename = pathinfo($PDF->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$PDF->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $PDF->move(
                        $this->getParameter('PDF_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $postuler->setUploaderCV($newFilename);
            }

            $entityManager->persist($postuler);
            $entityManager->flush();

            return $this->redirectToRoute('homePage', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('postuler/new.html.twig', [
            'postuler' => $postuler,
            'form' => $form,
        ]);
    }


    #[Route('/notification', name: 'postulerShow', methods: ['GET'])]
    public function show(PostulerRepository $postulerRepository): Response
    {
        return $this->render('postuler/show.html.twig', [
            'postulers' => $postulerRepository->findAll(),
        ]);
    }


    #[Route('/notification/{uploaderCV}', name: 'afficherCV', methods: ['GET'])]
    public function AfficherPDF($uploaderCV): Response
    {
        $nomFichier = $uploaderCV;
        return $this->file($this->getParameter('PDF_directory').'/'.$nomFichier);
    }


    #[Route('/notification/{id}/activer', name: 'accept', methods: ['GET'])]
    public function accept(PostulerRepository $postulerRepository, $id, EntityManagerInterface $entityManager): Response
    {

        $postuler = $postulerRepository->findAll();
        
        for($i=0; $i<sizeof($postuler); $i++)
        {
            if($postuler[$i]->getId() == $id)
            {
                $postuler[$i]->setAccept(($postuler[$i]->isAccept() ? false : true));
                $entityManager->persist($postuler[$i]);
                $entityManager->flush();
            }
        }

        return $this->redirectToRoute('postulerShow', [
            'id' => $id
        ]);
        
    }

    #[Route('/notification/{id}/refuser', name: 'refuser', methods: ['GET'])]
    public function refuser(PostulerRepository $postulerRepository,$id, EntityManagerInterface $entityManager): Response
    {

        $postuler = $postulerRepository->findAll();
        
        for($i=0; $i<sizeof($postuler); $i++)
        {
            if($postuler[$i]->getId() == $id)
            {
                $postuler[$i]->setRefuse(($postuler[$i]->isRefuse() ? false : true));
                $entityManager->persist($postuler[$i]);
                $entityManager->flush();
            }
        }

        return $this->redirectToRoute('postulerShow', [
            'id' => $id
        ]);

    }



    #[Route('/{id}/edit', name: 'postulerEdit', methods: ['GET', 'POST'])]
    public function edit(JobsRepository $jobsRepository, $id, Request $request, Postuler $postuler, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(PostulerType::class, $postuler);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
    
                $PDF = $form->get('fichierPDF')->getData();
    
                // this condition is needed because the 'brochure' field is not required
                // so the PDF file must be processed only when a file is uploaded
                if ($PDF) {
                    $originalFilename = pathinfo($PDF->getClientOriginalName(), PATHINFO_FILENAME);
                    // this is needed to safely include the file name as part of the URL
                    $safeFilename = $slugger->slug($originalFilename);
                    $newFilename = $safeFilename.'-'.uniqid().'.'.$PDF->guessExtension();
    
                    // Move the file to the directory where brochures are stored
                    try {
                        $PDF->move(
                            $this->getParameter('PDF_directory'),
                            $newFilename
                        );
                    } catch (FileException $e) {
                        // ... handle exception if something happens during file upload
                    }
    
                    // updates the 'brochureFilename' property to store the PDF file name
                    // instead of its contents
                    $postuler->setUploaderCV($newFilename);
                }

            $entityManager->flush();

            return $this->redirectToRoute('postulerIndex', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('postuler/edit.html.twig', [
            'postuler' => $postuler,
            'form' => $form,
        ]);
    }


    #[Route('/{id}', name: 'postulerDelete', methods: ['POST'])]
    public function delete(Request $request, Postuler $postuler, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$postuler->getId(), $request->request->get('_token'))) {
            $entityManager->remove($postuler);
            $entityManager->flush();
        }

        return $this->redirectToRoute('postulerIndex', [], Response::HTTP_SEE_OTHER);
    }
}
