<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\Lignecommande;
use App\Form\LignecommandeType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\LignecommandeRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/lignecommande')]
class LignecommandeController extends AbstractController
{
    #[Route('/', name: 'lignecommande_index', methods: ['GET'])]
    public function index(LignecommandeRepository $lignecommandeRepository): Response
    {
        return $this->render('lignecommande/index.html.twig', [
            'lignecommandes' => $lignecommandeRepository->findAll(),
        ]);
    }

    #[Route('/new/{id}', name: 'lignecommande_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, Commande $commande): Response
    {
        $lignecommande = new Lignecommande();
        $form = $this->createForm(LignecommandeType::class, $lignecommande, array(
            'id' => $commande->getRstCommande()->getId()
        ));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $lignecommande->setCommande($commande);

            $entityManager->persist($lignecommande);
            $entityManager->flush();
            

            return $this->redirectToRoute('update_prix_commande', ["id" => $commande->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('lignecommande/new.html.twig', [
            'lignecommande' => $lignecommande,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'lignecommande_show', methods: ['GET'])]
    public function show(Lignecommande $lignecommande): Response
    {
        return $this->render('lignecommande/show.html.twig', [
            'lignecommande' => $lignecommande,
        ]);
    }

    #[Route('/{id}/edit', name: 'lignecommande_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Lignecommande $lignecommande, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(LignecommandeType::class, $lignecommande, array(
            'id' => $lignecommande->getCommande()->getRstCommande()->getId()
        ));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('update_prix_commande', ["id" => $lignecommande->getCommande()->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('lignecommande/edit.html.twig', [
            'lignecommande' => $lignecommande,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'lignecommande_delete', methods: ['POST'])]
    public function delete(Request $request, Lignecommande $lignecommande, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$lignecommande->getId(), $request->request->get('_token'))) {
            $entityManager->remove($lignecommande);
            $entityManager->flush();
        }

        return $this->redirectToRoute('update_prix_commande', ["id" => $lignecommande->getCommande()->getId()], Response::HTTP_SEE_OTHER);
    }

    #[Route('/updatePrix/{id}', name: 'update_prix_commande', methods: ['GET', 'POST'])]
    public function updatePrix(EntityManagerInterface $entityManager, Commande $commande): Response
    {
        $prixTotal = 0;
        foreach($commande->getLgnCommande() as $ligne) {
            $quantite = $ligne->getQuantite();
            $prixProduit = $ligne->getProduit()->getPrix();
            $prixLigne = $quantite * $prixProduit;
            $prixTotal = $prixTotal + $prixLigne;
        }

        $commande->setPrixTT($prixTotal);
        $entityManager->flush();

        return $this->redirectToRoute('commande_show', ["id" => $commande->getId()], Response::HTTP_SEE_OTHER);
    }
}
