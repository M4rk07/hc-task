<?php
/**
 * Created by PhpStorm.
 * User: M4rk0
 * Date: 7/25/2018
 * Time: 7:10 PM
 */

namespace App\Controller\API;


use App\Entity\User;
use App\Exception\ApiException;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class UserController extends Controller
{
    /**
     * @Route("/api/users", name="create_user")
     * @Method({"POST"})
     */
    public function createAction(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $username = trim($request->request->get("username"));
        $plainPassword = $request->request->get("password");

        $user = new User();
        $user->setUsername($username);
        $user->setPlainPassword($plainPassword);

        $validator = $this->get('validator');
        // Validate properties
        $errors = $validator->validate($user);
        if(count($errors) > 0) {
            throw new ApiException(400, "Invalid values.");
        }

        $password = $passwordEncoder->encodePassword($user, $plainPassword);
        $user->setPassword($password);

        $em = $this->getDoctrine()->getManager();
        $em->persist($user);

        try {
            $em->flush();
        }catch(UniqueConstraintViolationException $e) {
            throw new ApiException(400, "Duplicate user.");
        }

        return new JsonResponse(array("success" => true, "message" => "Registration successful. You can login now!"), 200);

    }
}