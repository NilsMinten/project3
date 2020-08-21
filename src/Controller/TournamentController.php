<?php


namespace App\Controller;


use App\Entity\Tournament;
use App\Repository\TournamentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TournamentController extends AbstractController
{
    private $tournamentRepository;

    public function __construct(TournamentRepository $tournamentRepository)
    {
        $this->tournamentRepository = $tournamentRepository;
    }

    /** @Route(path="/tournaments", name="tournament_index") */
    public function tournaments() {
        $tournaments = $this->tournamentRepository->findBy([], ['id'=> 'desc']);

        return $this->render('tournaments/index.html.twig', [
            'tournaments' => $tournaments
        ]);
    }

    /** @Route(path="/tournaments/{id}/join", name="tournament_join") */
    public function joinTournament (Request $request, Tournament $tournament) {
        if ($tournament->getMaximumMembers() <= $tournament->getVisitors()->count()){
            $this->addFlash('notice', 'This tournament is full!');
            return $this->redirectToRoute('tournament_index');
        }

        if ($tournament->getRunningStatus() !== null) {
            $this->addFlash('notice', 'This tournament has started!');
            return $this->redirectToRoute('tournament_index');
        }

        $tournament->addSingleVisitor($this->getUser());

        $this->tournamentRepository->save($tournament);

        return $this->redirectToRoute('tournament_index');
    }

    /** @Route(path="/tournaments/{id}/leave", name="tournament_leave") */
    public function leaveTournament (Request $request, Tournament $tournament) {
        if ($tournament->getRunningStatus() !== null) {
            $this->addFlash('notice', 'This tournament has started!');
            return $this->redirectToRoute('tournament_index');
        }

        $tournament->removeVisitor($this->getUser());

        $this->tournamentRepository->save($tournament);

        return $this->redirectToRoute('tournament_index');
    }

    /** @Route(path="/tournaments/{id}", name="tournament_details") */
    public function tournamentDetails(Request $request, Tournament $tournament) {
        return $this->render('tournaments/details.html.twig', [
            'tournament' => $tournament
        ]);
    }
}