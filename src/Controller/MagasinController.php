<?php

namespace App\Controller;

use App\Repository\MagasinRepository;
use App\Entity\Offre;
use App\Entity\Magasin;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

/**
 * Class MagasinController
 * @package App\Controller
 * @Route("/magasins")
 */
class MagasinController
{

    /**
     * @Route(name="api_magasins_get", methods={"GET"})
     * @param MagasinRepository $magasinRepository
     * @param SerializerInterface $serializer
     * @return JsonResponse
     */
    public function readMagasins(MagasinRepository $magasinRepository, SerializerInterface $serializer): JsonResponse
    {
        return new JsonResponse(
            $serializer->serialize($magasinRepository->findAll(), "json", ['groups' => 'magasins:read']),
            JsonResponse::HTTP_OK,
            [],
            true
        );
    }

    /**
     * @Route("/{id}", name="api_magasins_getById", methods={"GET"})
     * @param Magasin $magasin
     * @param SerializerInterface $serializer
     * @return JsonResponse
     */
    public function readMagasinById(Magasin $magasin, SerializerInterface $serializer): JsonResponse
    {

        return new JsonResponse(
            $serializer->serialize($magasin, "json", ['groups' => 'magasins:read']),
            JsonResponse::HTTP_OK,
            [],
            true
        );
    }

    /**
     * @Route("/getOffresByMagasin/{id}", name="api_magasins_getById", methods={"GET"})
     * @param Magasin $magasin
     * @param SerializerInterface $serializer
     * @return JsonResponse
     */
    public function readOffreByMagasin(Magasin $magasin, SerializerInterface $serializer): JsonResponse
    {

        return new JsonResponse(
            $serializer->serialize($magasin, "json", ['groups' => 'magasinsOffres:read']),
            JsonResponse::HTTP_OK,
            [],
            true
        );
    }

    /**
     * @Route("/{id}", name="api_magasin_create", methods={"POST"})
     * @param Offre $offre
     * @param Request $request
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface
     * @return JsonResponse
     */
    public function createMagasin(Offre $offre, Request $request, SerializerInterface $serializer, EntityManagerInterface $entityManager): JsonResponse
    {
        $magasin = $serializer->deserialize($request->getContent(), Magasin::class, "json");
        $magasin->addOffre($offre);

        $entityManager->persist($magasin);
        $entityManager->flush();

        return new JsonResponse(
            $serializer->serialize($magasin, "json", ['groups' => 'magasins:read']),
            JsonResponse::HTTP_CREATED,
            [],
            true
        );
    }

    /**
     * @Route("/{id}", name="api_magasin_update", methods={"PUT"})
     * @param Magasin $magasin
     * @param Request $request
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface
     * @return JsonResponse
     */
    public function updateMagasin(Magasin $magasin, Request $request, SerializerInterface $serializer, EntityManagerInterface $entityManager): JsonResponse
    {
        $magasin = $serializer->deserialize($request->getContent(), Magasin::class, "json", [AbstractNormalizer::OBJECT_TO_POPULATE => $magasin]);

        $entityManager->flush();

        return new JsonResponse(
            null,
            JsonResponse::HTTP_NO_CONTENT,
        );
    }

    /**
     * @Route("/{id}", name="api_magasin_delete", methods={"DELETE"})
     * @param Magasin $magasin
     * @param EntityManagerInterface
     * @return JsonResponse
     */
    public function deleteMagasin(Magasin $magasin, EntityManagerInterface $entityManager): JsonResponse
    {

        $entityManager->remove($magasin);
        $entityManager->flush();

        return new JsonResponse(
            null,
            JsonResponse::HTTP_NO_CONTENT,
        );
    }
}
