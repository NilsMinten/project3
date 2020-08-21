<?php


namespace App\Controller;


use App\Entity\Masterclass;
use App\Entity\RatingPoints;
use App\Entity\User;
use App\Repository\MasterClassRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MasterclassController extends AbstractController
{
    private $masterClassRepository;

    public function __construct(MasterClassRepository $masterClassRepository)
    {
        $this->masterClassRepository = $masterClassRepository;
    }

    /** @Route(path="/masterclass", name="masterclass_index") */
    public function masterclass() {
        $masterclasses = $this->masterClassRepository->findBy([], ['id'=> 'desc']);

        return $this->render('masterclass/index.html.twig', [
            'masterclasses' => $masterclasses
        ]);
    }

    /** @Route(path="/masterclass/{id}/join", name="masterclass_join") */
    public function joinMasterclass (Request $request, Masterclass $masterclass) {
        if ($masterclass->getMaximumMembers() <= $masterclass->getVisitors()->count()){
            $this->addFlash('notice', 'This class is full!');
            return $this->redirectToRoute('masterclass_index');
        }

        /** @var User $user */
        $user = $this->getUser();
        $gametype = $masterclass->getGameType();

        $rating = array_values(array_filter($user->getRating()->toArray(), function (RatingPoints $rating) use ($gametype) {
            return $rating->getGameType() === $gametype;
        }));

        if (count($rating) > 1) {
            $this->addFlash('error', 'Something is wrong  with your game points contact an admin');
            return $this->redirectToRoute('masterclass_index');
        }

        if (count($rating) === 0 || $rating[0]->getRating() < $masterclass->getMinimumRating()) {
                $this->addFlash('notice', 'You don\'t have enough points for this masterclass');
            return $this->redirectToRoute('masterclass_index');
        }

        $masterclass->addSingleVisitor($user);

        $this->masterClassRepository->save($masterclass);

        return $this->redirectToRoute('masterclass_index');
    }

    /** @Route(path="/masterclass/{id}/leave", name="masterclass_leave") */
    public function leaveMasterclass (Request $request, Masterclass $masterclass) {

        $masterclass->removeVisitor($this->getUser());

        $this->masterClassRepository->save($masterclass);

        return $this->redirectToRoute('masterclass_index');
    }

    /** @Route(path="/masterclass/{id}", name="masterclass_details") */
    public function masterclassDetails(Request $request, Masterclass $masterclass) {
        return $this->render('masterclass/details.html.twig', [
            'masterclass' => $masterclass
        ]);
    }
}