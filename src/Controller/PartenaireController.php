<?php

namespace App\Controller;

use App\Entity\Partenaire;
use App\Repository\PartenaireRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

/**
 * Class PartenaireController
 * @package App\Controller
 * @Route("/partenaires")
 */
class PartenaireController{

    /**
     * @Route(name="api_partenaires_get", methods={"GET"})
     * @param PartenaireRepository $partenaireRepository
     * @param SerializerInterface $serializer
     * @return JsonResponse
     */
    public function readPartenaires(PartenaireRepository $partenaireRepository, SerializerInterface $serializer) : JsonResponse{
        return new JsonResponse(
            $serializer->serialize($partenaireRepository->findAll(), "json", ['groups' => 'partenaires:read']),
            JsonResponse::HTTP_OK,
            [],
            true
        );
    }

    /**
     * @Route("/{id}", name="api_partenaire_getById", methods={"GET"})
     * @param Partenaire $partenaire
     * @param SerializerInterface $serializer
     * @return JsonResponse
     */
    public function readPartenaireById(Partenaire $partenaire, SerializerInterface $serializer) : JsonResponse{
        return new JsonResponse(
            $serializer->serialize($partenaire, "json", ['groups' => 'partenaires:read']),
            JsonResponse::HTTP_OK,
            [],
            true
        );
    }

    /**
     * @Route(name="api_partenaire_create", methods={"POST"})
     * @param Request $request
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface
     * @return JsonResponse
     */
    public function createPartenaire(Request $request, SerializerInterface $serializer, EntityManagerInterface $entityManager) : JsonResponse{
        $partenaire = $serializer->deserialize($request->getContent(), Partenaire::class, "json");

        $entityManager->persist($partenaire);
        $entityManager->flush();

        return new JsonResponse(
            $serializer->serialize($partenaire, "json", ['groups' => 'partenaires:read']),
            JsonResponse::HTTP_CREATED,
            [],
            true
        );
    }

    /**
     * @Route("/{id}", name="api_partenaire_update", methods={"PUT"})
     * @param Partenaire $partenaire
     * @param Request $request
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface
     * @return JsonResponse
     */
    public function updatePartenaire(Partenaire $partenaire, Request $request, SerializerInterface $serializer, EntityManagerInterface $entityManager) : JsonResponse{
        $partenaire = $serializer->deserialize($request->getContent(), Partenaire::class, "json", [AbstractNormalizer::OBJECT_TO_POPULATE => $partenaire]);

        $entityManager->flush();

        return new JsonResponse(
            null, JsonResponse::HTTP_NO_CONTENT,
        );
    }

    /**
     * @Route("/{id}", name="api_partenaire_delete", methods={"DELETE"})
     * @param Partenaire $partenaire
     * @param EntityManagerInterface
     * @return JsonResponse
     */
    public function deletePartenaire(Partenaire $partenaire, EntityManagerInterface $entityManager) : JsonResponse{

        $entityManager->remove($partenaire);
        $entityManager->flush();

        return new JsonResponse(
            null, JsonResponse::HTTP_NO_CONTENT,
        );
    }
    
}