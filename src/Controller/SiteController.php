<?php


namespace App\Controller;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;
use App\Entity\User;
use App\Form\RegistrationType;
use Doctrine\Common\Persistence\ObjectManager;
use MongoDB\Driver\Manager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\UserBundle\Doctrine\UserManager;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Request;

class SiteController extends AbstractController
{
    /**
     * @Route("/site", name="site")
     */
    public function index()
    {
        return $this->render('site/index.html.twig', [
            'controller_name' => 'SiteController',
        ]);
    }



    /**
     * @Route("/users", name="users")
     */
    public function getAllUser(Security $security, EntityManagerInterface $em) : Response
    {
        $repo = $this->getDoctrine()->getRepository(User::class);
        $users = $repo->findAll();
        $user = $this->getUser();
        $amis = $user->getMyFriends();

        if(!empty($_POST) )
        {
            if(isset($_POST['submit'])) {

                $ida = $_POST['ida'];
                $idu = $_POST['idu'];
                $repo = $this->getDoctrine()->getRepository(User::class);
                $ami = $repo->find($ida);
                $user = $repo->find($idu);

                $user->addMyFriend($ami);
                $user->addFriendsWithMe($ami);


                $send = $this->getDoctrine()->getManager();
                $send->persist($user);
                $send->flush();

            }
            elseif (isset($_POST['search']))
            {
                $username = $_POST['username'];
                $queryBuilder = $em->getRepository(User::class)->createQueryBuilder('us')
                    ->andWhere('us.username LIKE :searchTerm')
                    ->setParameter('searchTerm', '%'.$username.'%');
                $resultats = $queryBuilder->getQuery()->getResult();


                return $this->render('site/users.html.twig', [
                    'users' => $resultats,
                    'amis' => $amis

                ]);



            }
        }
        return $this->render('site/users.html.twig', [
            'users' => $users,
            'amis' => $amis

        ]);
    }

    /**
     * @Route("/friends", name="friends")
     */

    public function friends(EntityManagerInterface $em) : Response{

        $user = $this->getUser();
        $amis = $user->getMyFriends();


        if(!empty($_POST) ) {


                $ida = $_POST['ida'];
                $idu = $_POST['idu'];
                $repo = $this->getDoctrine()->getRepository(User::class);
                $ami = $repo->find($ida);
                $user = $repo->find($idu);

                $user->removeFriendsWithMe($ami);
                $user->removeMyFriend($ami);


                $send = $this->getDoctrine()->getManager();
                $send->persist($user);
                $send->flush();


        }
        return $this->render('site/friend_list.html.twig', [
            'amis' => $amis,
            'user' => $user

        ]);
    }

}