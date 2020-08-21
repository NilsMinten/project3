<?php


namespace App\Controller;


use App\Entity\GameType;
use App\Entity\Masterclass;
use App\Entity\Tournament;
use App\Form\GameTypeFormType;
use App\Form\MasterclassFormType;
use App\Form\TournamentFormType;
use App\Repository\GameTypeRepository;
use App\Repository\MasterClassRepository;
use App\Repository\TournamentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    private $tournamentRepository;
    private $gameTypeRepository;
    private $masterClassRepository;

    public function __construct(TournamentRepository $tournamentRepository, GameTypeRepository $gameTypeRepository, MasterClassRepository $masterClassRepository)
    {
        $this->tournamentRepository = $tournamentRepository;
        $this->gameTypeRepository = $gameTypeRepository;
        $this->masterClassRepository = $masterClassRepository;
    }

    /** @Route(path="/admin", name="admin_index") */
    public function index() {
        $upcomingTournaments = $this->tournamentRepository->findUpcomming();
        $upcomingMasterclasses = $this->masterClassRepository->findUpcomming();

        return $this->render('admin/index.html.twig', [
            'upcomingTournaments' => $upcomingTournaments,
            'upcomingMasterclasses' => $upcomingMasterclasses
        ]);
    }

    /** @Route(path="/admin/tournaments", name="admin_tournament_index") */
    public function tournaments() {
        $tournaments = $this->tournamentRepository->findBy([], ['id'=> 'desc']);

        return $this->render('admin/tournaments/index.html.twig', [
            'tournaments' => $tournaments
        ]);
    }

    /** @Route(path="/admin/tournaments/new", name="admin_tournament_new");
     * @Route(path="/admin/tournaments/{id}/edit", name="admin_tournament_edit");
     */
    public function createTournament(Request $request, Tournament $tournament = null) {
        $tournament = $tournament ?? new Tournament();
        $form = $this->createForm(TournamentFormType::class, $tournament);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->tournamentRepository->save($tournament);

            return $this->redirectToRoute('admin_tournament_index');
        }

        return $this->render('admin/tournaments/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /** @Route(path="/admin/tournaments/{id}", name="admin_tournament_details") */
    public function tournamentDetails(Request $request, Tournament $tournament) {
        return $this->render('admin/tournaments/details.html.twig', [
            'tournament' => $tournament
        ]);
    }

    /** @Route(path="/admin/tournaments/{id}/delete", name="admin_tournament_delete_confirm") */
    public function confirmTournamentDelete(Request $request, Tournament $tournament) {
        return $this->render('admin/tournaments/delete_confirm.html.twig', [
            'tournament' => $tournament,
        ]);
    }

    /** @Route(path="/admin/tournaments/{id}/delete/confirm", name="admin_tournament_delete") */
    public function tournamentDelete(Request $request, Tournament $tournament) {
        $this->tournamentRepository->delete($tournament);

        return $this->redirectToRoute('admin_tournament_index');
    }

    /** @Route(path="/admin/game_types", name="admin_game_type_index") */
    public function gameTypes() {
        $gametypes = $this->gameTypeRepository->findAll();

        return $this->render('admin/game_types/index.html.twig', [
            'gametypes' => $gametypes
        ]);
    }

    /** @Route(path="/admin/game_types/new", name="admin_game_type_new");
     * @Route(path="/admin/game_types/{id}/edit", name="admin_game_type_edit");
     */
    public function createGameType(Request $request, GameType $gameType = null) {
        $gameType = $gameType ?? new GameType();
        $form = $this->createForm(GameTypeFormType::class, $gameType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->gameTypeRepository->save($gameType);

            return $this->redirectToRoute('admin_game_type_index');
        }

        return $this->render('admin/game_types/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /** @Route(path="/admin/game_types/{id}", name="admin_game_type_details") */
    public function gameTypeDetails(Request $request, GameType $gameType) {
        return $this->render('admin/game_types/details.html.twig', [
            'gametype' => $gameType
        ]);
    }

    /** @Route(path="/admin/game_types/{id}/delete", name="admin_game_type_delete_confirm") */
    public function confirmGametypeDelete(Request $request, GameType $gameType) {
        return $this->render('admin/game_types/delete_confirm.html.twig', [
            'gametype' => $gameType,
        ]);
    }

    /** @Route(path="/admin/game_types/{id}/delete/confirm", name="admin_game_type_delete") */
    public function gametypeDelete(Request $request, GameType $gameType) {
        $this->gameTypeRepository->delete($gameType);

        return $this->redirectToRoute('admin_game_type_index');
    }

    /** @Route(path="/admin/masterclass", name="admin_masterclass_index") */
    public function masterclasses() {
        $masterclasses = $this->masterClassRepository->findBy([], ['id'=> 'desc']);

        return $this->render('admin/masterclass/index.html.twig', [
            'masterclasses' => $masterclasses
        ]);
    }

    /** @Route(path="/admin/masterclass/new", name="admin_masterclass_new");
     * @Route(path="/admin/masterclass/{id}/edit", name="admin_masterclass_edit");
     */
    public function createMasterclass(Request $request, Masterclass $masterclasses = null) {
        $masterclasses = $masterclasses ?? new Masterclass();
        $form = $this->createForm(MasterclassFormType::class, $masterclasses);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->masterClassRepository->save($masterclasses);

            return $this->redirectToRoute('admin_masterclass_index');
        }

        return $this->render('admin/masterclass/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /** @Route(path="/admin/masterclass/{id}", name="admin_masterclass_details") */
    public function masterclassDetails(Request $request, Masterclass $masterclasses) {
        return $this->render('admin/masterclass/details.html.twig', [
            'masterclass' => $masterclasses
        ]);
    }

    /** @Route(path="/admin/masterclass/{id}/delete", name="admin_masterclass_delete_confirm") */
    public function confirmMasterclassdDelete(Request $request, Masterclass $masterclasses) {
        return $this->render('admin/masterclass/delete_confirm.html.twig', [
            'masterclass' => $masterclasses,
        ]);
    }

    /** @Route(path="/admin/masterclass/{id}/delete/confirm", name="admin_masterclass_delete") */
    public function masterclassDelete(Request $request, Masterclass $masterclasses) {
        $this->masterClassRepository->delete($masterclasses);

        return $this->redirectToRoute('admin_tournament_index');
    }
}