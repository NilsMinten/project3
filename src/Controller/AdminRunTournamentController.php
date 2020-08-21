<?php


namespace App\Controller;


use App\Entity\Tournament;
use App\Repository\TournamentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminRunTournamentController extends AbstractController
{
    private $tournamentRepository;

    public function __construct(TournamentRepository $tournamentRepository)
    {
        $this->tournamentRepository = $tournamentRepository;
    }

    /** @Route(path="/tournaments/{id}/start", name="tournament_start_confirm") */
    public function tournamentDetails(Request $request, Tournament $tournament) {
        if ($tournament->getRunningStatus() !== null)
            return $this->redirectToRoute('tournament_start_running', ['id' => $tournament->getId()]);

        return $this->render('admin/tournaments/ongoing/confirm.html.twig', [
            'tournament' => $tournament
        ]);
    }

    /** @Route(path="/tournaments/{id}/running", name="tournament_start_running") */
    public function tournamentRunning(Request $request, Tournament $tournament) {
        if ($tournament->getRunningStatus() === null) {
            $tournament->setRunningStatus([
                'status' => 'starting'
            ]);
        }

        $tournamentDetails = $tournament->getRunningStatus();

        switch ($tournamentDetails->status) {
            default:
            case 'running':
                break;
            case 'reshuffle':
            case 'starting':
                $tournament = $this->prepareRound($tournament);
                break;
            case 'finished':
                return $this->redirectToRoute('tournament_index');
                break;
        }

        $this->tournamentRepository->save($tournament);

        return $this->render('admin/tournaments/ongoing/details.html.twig', [
            'tournament' => $tournament,
            'runningStatus' => $tournament->getRunningStatus(),
            'tableSpread' => (array) $tournament->getRunningStatus()->table_spread
        ]);
    }

    /** @Route(path="admin/tournaments/{id}/pick_round_victors", name="tournament_pick_victors") */
    public function pickRoundVictors(Request $request, Tournament $tournament) {
        dd($tournament);
    }

    private function prepareRound(Tournament $tournament) {
        $tournament->setRunningStatus([
            'status' => 'running',
            'table_spread' => $this->spreadUsersOverTables($tournament)
        ]);

        return $tournament;
    }

    private function spreadUsersOverTables(Tournament $tournament) {
        $tables = $tournament->getTables();
        $visitors = $tournament->getVisitors();
        $visitorArray = $visitors->toArray();
        shuffle($visitorArray);
        $z = 0;

        $amountPerTable = floor($visitors->count() / $tables);
        $tableSpread = [];

        for ($x = 1; $x <= $tables; $x++) {
            $users = [];

            for ($y = 0; $y < $amountPerTable; $y++) {
                $users[] = [$visitorArray[$z]->getId(), $visitorArray[$z]->getUsername()];
                $z++;
            }

            $tableSpread['Table '.$x] = $users;
        }

        $left = $visitors->count() - $z;

        for ($x = 1; $x <= $left ; $x++) {
            if ($x > $tables)
                $x = 0;

            $tableSpread['Table '.$x][] = [$visitorArray[$z]->getId(), $visitorArray[$z]->getUsername()];
        }

        return $tableSpread;
    }
}