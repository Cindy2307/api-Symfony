<?php

namespace App\Controller;

use App\Repository\OffreRepository;
use App\Entity\Offre;
use App\Entity\Partenaire;
use App\Repository\PartenaireRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

/**
 * Class PartenaireController
 * @package App\Controller
 * @Route("/offres")
 */
class OffreController
{

    /**
     * @Route(name="api_offres_get", methods={"GET"})
     * @param OffreRepository $offreRepository
     * @param SerializerInterface $serializer
     * @return JsonResponse
     */
    public function readOffres(OffreRepository $offreRepository, SerializerInterface $serializer): JsonResponse
    {
        return new JsonResponse(
            $serializer->serialize($offreRepository->findAll(), "json", ['groups' => 'offres:read']),
            JsonResponse::HTTP_OK,
            [],
            true
        );
    }

    /**
     * @Route("/{id}", name="api_offres_getById", methods={"GET"})
     * @param Offre $offre
     * @param SerializerInterface $serializer
     * @return JsonResponse
     */
    public function readOffreById(Offre $offre, SerializerInterface $serializer): JsonResponse
    {
        return new JsonResponse(
            $serializer->serialize($offre, "json", ['groups' => 'offres:read']),
            JsonResponse::HTTP_OK,
            [],
            true
        );
    }

    /**
     * @Route("/getByPartenaire/{name}", name="api_offres_getByPartenaire", methods={"GET"})
     * @param OffreRepository $offreRepository
     * @param SerializerInterface $serializer
     * @return JsonResponse
     */
    public function readOffresByPartenaire(string $name, OffreRepository $offreRepository, SerializerInterface $serializer, EntityManagerInterface $entityManager): JsonResponse
    {
        $partenaire = $entityManager->getRepository(Partenaire::class)->findBy([
            "name" => $name,
        ]);

        return new JsonResponse(
            $serializer->serialize($offreRepository->findBy(["partenaire" => $partenaire[0]]), "json", ['groups' => 'offres:read']),
            JsonResponse::HTTP_OK,
            [],
            true
        );
    }

    /**
     * @Route("/{id}", name="api_offre_create", methods={"POST"})
     * @param Partenaire $partenaire
     * @param Request $request
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface
     * @return JsonResponse
     */
    public function createOffre(Partenaire $partenaire, Request $request, SerializerInterface $serializer, EntityManagerInterface $entityManager): JsonResponse
    {
        $offre = $serializer->deserialize($request->getContent(), Offre::class, "json");
        $offre->setPartenaire($partenaire);
        $offre->setCreatedAt(new \DateTime());

        $entityManager->persist($offre);
        $entityManager->flush();

        return new JsonResponse(
            $serializer->serialize($offre, "json", ['groups' => 'offres:read']),
            JsonResponse::HTTP_CREATED,
            [],
            true
        );
    }

    /**
     * @Route("/{id}", name="api_offre_update", methods={"PUT"})
     * @param Offre $offre
     * @param Request $request
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface
     * @return JsonResponse
     */
    public function updateOffre(Offre $offre, Request $request, SerializerInterface $serializer, EntityManagerInterface $entityManager): JsonResponse
    {
        $offre = $serializer->deserialize($request->getContent(), Offre::class, "json", [AbstractNormalizer::OBJECT_TO_POPULATE => $offre]);

        $entityManager->flush();

        return new JsonResponse(
            null,
            JsonResponse::HTTP_NO_CONTENT,
        );
    }

    /**
     * @Route("/{id}", name="api_offre_delete", methods={"DELETE"})
     * @param Offre $offre
     * @param EntityManagerInterface
     * @return JsonResponse
     */
    public function deleteOffre(Offre $offre, EntityManagerInterface $entityManager): JsonResponse
    {

        $entityManager->remove($offre);
        $entityManager->flush();

        return new JsonResponse(
            null,
            JsonResponse::HTTP_NO_CONTENT,
        );
    }
}
