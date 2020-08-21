<?php


namespace App\Controller;


use App\Entity\RatingPoints;
use App\Entity\Tournament;
use App\Entity\User;
use App\Repository\TournamentRepository;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminRunTournamentController extends AbstractController
{
    private $tournamentRepository;
    private $userRepository;

    public function __construct(TournamentRepository $tournamentRepository, UserRepository $userRepository)
    {
        $this->tournamentRepository = $tournamentRepository;
        $this->userRepository = $userRepository;
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
                return $this->redirectToRoute('tournament_details', [ 'id' => $tournament->getId() ]);
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
        $table_spread = $tournament->getRunningStatus()->table_spread;
        $users = new ArrayCollection();
        $tables = [];

        foreach ($table_spread as $key => $table) {
            $tables[$key] = new ArrayCollection();

            foreach ($table as $user) {
                $tables[$key]->add($this->userRepository->find($user[0]));
                $users->add($this->userRepository->find($user[0]));
            }
        }

        if ($request->get('submitted') === "yes")  {
            $winningUsers = new ArrayCollection();

            foreach ($tables as $key => $value) {
                $totalScore = 0;

                /** @var User $user */
                foreach ($value as $user) {
                    $rating = $user->getSingleRating($tournament->getGameType());

                    $totalScore += $rating !== null ? $rating->getRating() : 0;
                }

                $victor = $request->get($key);

                $victorUser = array_values(array_filter($value->toArray(), function ($value) use ($victor) {
                    return (int) $victor === $value->getId();
                }));

                if (count($victorUser) > 0) {
                    $winningUsers->add($victorUser[0]);

                    $rating = $victorUser[0]->getSingleRating($tournament->getGameType());
                    if ($rating === null) {
                        $victorUser[0]->addRating(new RatingPoints($victorUser[0], $tournament->getGameType(), $totalScore /2));
                    } else {
                        $currentRating = $rating->getRating();
                        $rating->setRating($currentRating + ($totalScore / ($currentRating > 0 ? $currentRating : 1)));
                    }

                    $this->userRepository->save($victorUser[0]);
                }
            }

            $tournament->setVisitors($winningUsers);
            $tournament->setRunningStatus([
                'status' => $tournament->getVisitors()->count() === 1 ? 'finished' : 'reshuffle'
            ]);

            $this->tournamentRepository->save($tournament);
            return $this->redirectToRoute('tournament_start_running', [ 'id' => $tournament->getId() ]);
        }

        return $this->render('admin/tournaments/ongoing/pick_victors.html.twig', [
            'tables' => $tables,
            'tournament' => $tournament
        ]);
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

        if ($tables === $visitors->count())
            $tables = 1;

        $amountPerTable = floor($visitors->count() / $tables);
        $tableSpread = [];

        for ($x = 1; $x <= $tables; $x++) {
            $users = [];

            for ($y = 0; $y < $amountPerTable; $y++) {
                $users[] = [$visitorArray[$z]->getId(), $visitorArray[$z]->getUsername()];
                $z++;
            }

            $tableSpread['Table'.$x] = $users;
        }

        $left = $visitors->count() - $z;

        for ($x = 1; $x <= $left ; $x++) {
            if ($x > $tables)
                $x = 0;

            $tableSpread['Table'.$x][] = [$visitorArray[$z]->getId(), $visitorArray[$z]->getUsername()];
        }

        return $tableSpread;
    }
}