<?php
// src/Controller/ProgramController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use App\Repository\ProgramRepository;
use App\Form\ProgramType;
use App\Entity\Program;
use App\Entity\Season;
use App\Entity\Episode;



#[Route('/program', name: 'program_')]
class ProgramController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(ProgramRepository $programRepository): Response
    {
        $programs = $programRepository->findAll();
        return $this->render(
            'program/index.html.twig',
            ['programs' => $programs]
        );
    }

    #[Route('/show/{id<^[0-9]+$>}', name: 'show')]
    public function show(Program $program): Response
    {
        $seasons = $program->getSeasons();
        if (!$seasons) {
            throw $this->createNotFoundException(
                'No program with found in program\'s table.'
            );
        }

        return $this->render('program/show.html.twig', [
            'program' => $program,
            'seasons' => $seasons
        ]);
    }

    #[Route('/{programId<^[0-9]+$>}/seasons/{seasonId<^[0-9]+$>}', name: 'season_show')]
    #[Entity('program', options: ['id' => 'programId'])]
    #[Entity('season', options: ['id' => 'seasonId'])]
    public function showSeason(Program $program, Season $season): Response
    {
        $episodes = $season->getEpisodes();
        if (!$episodes) {
            throw $this->createNotFoundException(
                'No episodes with : ' . $season->getNumber() . ' found in episode\'s table.'
            );
        }

        return $this->render('program/season_show.html.twig', [
            'program' => $program,
            'season' => $season,
            'episodes' => $episodes
        ]);
    }

    #[Route('/{programId<^[0-9]+$>}/{seasonId<^[0-9]+$>}/episodes/{episodeId<^[0-9]+$>}', name: 'episode_show')]
    #[Entity('program', options: ['id' => 'programId'])]
    #[Entity('season', options: ['id' => 'seasonId'])]
    #[Entity('episode', options: ['id' => 'episodeId'])]
    public function showEpisode(Program $program, Season $season, Episode $episode): Response
    {
        if (!$episode) {
            throw $this->createNotFoundException(
                'No episode found in episode\'s table.'
            );
        }

        return $this->render('program/program_episode_show.html.twig', [
            'program' => $program,
            'season' => $season,
            'episode' => $episode
        ]);
    }

    #[Route('/new', name: 'new')]
    public function new(Request $request, ProgramRepository $programRepository): Response
    {
        $program = new Program();
        $form = $this->createForm(ProgramType::class, $program);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $programRepository->save($program, true);
            return $this->redirectToRoute('program_index');
        }
        return $this->renderForm('program/new.html.twig', ['form' => $form]);
    }
}
