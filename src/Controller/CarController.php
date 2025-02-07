<?php

namespace App\Controller;

use App\Entity\Car;
use App\Form\CarType;
use App\Repository\CarRepository;
use Doctrine\ORM\EntityManagerInterface;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


class CarController extends AbstractController
{

    public function __construct(

        private EntityManagerInterface $entityManager,
    ) {}

    #[Route('/', name: 'app_car_index', methods: ['GET'])]
    public function index(Request $request, CarRepository $repository): Response
    {
        $cars = Pagerfanta::createForCurrentPageWithMaxPerPage(
            new QueryAdapter($repository->createQueryBuilder('b')),
            $request->query->get('page', 1),
            10
        );

        return $this->render('car/index.html.twig', [
            'cars' => $cars,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_car_show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function show(?Car $car): Response
    {
        return $this->render('car/show.html.twig', [
            'car' => $car,
        ]);
    }

    #[Route('/{id}/supprimer', name: 'app_car_remove', requirements: ['id' => '\d+'],  methods: ['GET', 'POST'])]
    public function remove(?Car $car): Response
    {
        $this->entityManager->remove($car);
        $this->entityManager->flush();

        return $this->redirectToRoute('app_car_index');
    }


    #[Route('/new', name: 'app_admin_car_new', methods: ['GET', 'POST'])]
    #[Route('/{id}/edit', name: 'app_admin_car_edit', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    public function new(?Car $car, Request $request, EntityManagerInterface $manager): Response
    {
        $car ??= new Car();
        $form = $this->createForm(CarType::class, $car);

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($car);
            $manager->flush();

            return $this->redirectToRoute('app_admin_car_show', ['id' => $car->getId()]);
        }
        return $this->render('car/new.html.twig', [
            'form' => $form,
        ]);
    }
}
