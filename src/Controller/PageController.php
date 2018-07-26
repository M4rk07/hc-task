<?php
/**
 * Created by PhpStorm.
 * User: M4rk0
 * Date: 7/25/2018
 * Time: 6:09 PM
 */

namespace App\Controller;


use App\Entity\Trip;
use App\Exception\AccountBlockedException;
use App\Exception\ApiException;
use App\Worker\GpxFile;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class PageController extends Controller
{
    /**
     * @Route("/", name="page_index")
     */
    public function index(Request $request, AuthenticationUtils $authenticationUtils)
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();



        if(!empty($error) && !empty($lastUsername)) {
            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository('App\Entity\User')->findOneBy(array('username' => $lastUsername));
            if(!empty($user)) {
                $user->setAttempts(intval($user->getAttempts()) + 1);
                $em->merge($user);
                $em->flush();
            }
        }

        $error_message = null;

        if(empty($error_message)) {
            if ($error != null) {
                if($error instanceof AccountBlockedException)
                    $error_message = $error->getMessage();
                else
                    $error_message = $error->getMessageKey();
            }
            else
                $error_message = null;
        }

        return $this->render('pages/index.html.twig', array(
            'last_username' => $lastUsername,
            'error_message' => $error_message,
            'error'         => $error,
        ));
    }

    /**
     * @Route("/logout", name="page_logout")
     */
    public function logout(Request $request)
    {
    }

    /**
     * @Route("/list", name="page_list")
     */
    public function list(Request $request = null)
    {
        $user = $this->getUser();

        $em = $this->getDoctrine()->getManager();
        $trips = $em->getRepository('App\Entity\Trip')->findBy(array('user' => $user));

        return $this->render('pages/list.html.twig', array(
            "trips" => $trips
        ));

    }

    /**
     * @Route("/gpx/file", name="gpx_file")
     */
    public function gpxGet(Request $request)
    {
        $idTrip = $request->query->get("id_trip");
        $user = $this->getUser();
        $file = new File(__DIR__."/../gpx/".$user->getIdUser()."-".$idTrip.".gpx");
        return $this->file($file);

    }

    /**
     * @Route("/gpx", name="page_gpx")
     */
    public function gpxPost(Request $request)
    {
        return ( !empty($request->files->get("gpx_file")) ) ?
            $this->createTrip($request) :
            $this->render('pages/gpx.html.twig', array());

    }

    public function createTrip(Request $request) {
        $tripName = trim($request->request->get("trip_name"));
        $gpxFile = $request->files->get("gpx_file");

        $user = $this->getUser();

        // CREATING TRIP
        $trip = new Trip();
        $trip->setUser($user);
        $trip->setName($tripName);

        $validator = $this->get('validator');
        // Validate properties
        $errors = $validator->validate($trip);
        if(count($errors) > 0) {
            return $this->render('pages/gpx.html.twig', array(
                "error_message" => "Trip name must contain atleast 3 letters."
            ));
        }

        $gpx = new GpxFile($gpxFile);
        try {
            $gpx->checkFile();
        } catch (\Exception $e) {
            return $this->render('pages/gpx.html.twig', array(
                "error_message" => "Please upload valid GPX file."
            ));
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($trip);
        $em->flush();

        try {
            $filename = $user->getIdUser() . "-" . $trip->getIdTrip() . ".gpx";
            $gpxFile->move(
                __DIR__ . "/../gpx",
                $filename
            );
        } catch (\Exception $e) {
            $em->remove($trip);
            $em->flush();
            return $this->render('pages/gpx.html.twig', array(
                "error_message" => "Can't save the data."
            ));
        }

        return $this->redirectToRoute('page_list');
    }

}