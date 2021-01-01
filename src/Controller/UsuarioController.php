<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Entity\Usuario;
use App\Form\RegisterType;
use App\Form\RegisterType_1;
use App\Form\changePassWD;
use App\Entity\Negocio;
use App\Entity\Tiquet;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Controller\NegocioController;
use App\Form\giveEmail;



class UsuarioController extends AbstractController {

    /**
     * @Route("/usuario", name="usuario")
     */
    public function index() {
        return $this->render('usuario/index.html.twig', [
                    'controller_name' => 'UsuarioController',
        ]);
    }

    public function register(Request $request, UserPasswordEncoderInterface $encoder) {
        //crear el formulario
        $user = new Usuario();
        $form = $this->createForm(RegisterType::class, $user);

        //Rellenar el objeto con los datos del formulario
        $form->handleRequest($request);

        //comprueba si se envia el formulario
        if ($form->isSubmitted() && $form->isValid()) {
            //modificando el objeto antes de guardarlo
            $user->setRole('CLIENTE');

            $now = new \DateTime();


            $user->setCreateAt($now);

            //cifrando la contraseña
            $encoded = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($encoded);

            //guardar usuario

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('index');
        }
        return $this->render('usuario/register.html.twig', [
                    'controller_name' => 'UserController',
                    'form' => $form->createView()
        ]);
    }

    public function login(AuthenticationUtils $authenticationUtils) {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('usuario/login.html.twig', array(
                    'error' => $error,
                    'last_username' => $lastUsername
        ));
    }
    
  

  
    public function listado() {
        $usuario_rep = $this->getDoctrine()->getRepository(Usuario::class);
        $usuarios = $usuario_rep ->findBy( array(), array('surname' => 'ASC') );
       
        return $this->render('usuario/listadousuarios.html.twig', [
                    'usuarios' => $usuarios
        ]);
    }

    public function eliminar(Usuario $usuario, UserInterface $user) {
        if (!$user) {
            return $this->redirectToRoute('index');
        }
        if ($user->getRole() != 'ADMINISTRADOR' and $user->getId() != $usuario->getId()) {
            return $this->redirectToRoute('index');
        }



        //em
        $em = $this->getDoctrine()->getManager();
        //eliminamos los tiques del usuario
        $tiquet_rep = $this->getDoctrine()->getRepository(Tiquet::class);
        $tiquets = $tiquet_rep->findAll();

        for ($i = 0; $i < count($tiquets); $i++) {
            if ($tiquets[$i]->getUsuario()->getId() == $usuario->getId()) {
                $em->remove($tiquets[$i]);
            }
        }

        ///

        if ($usuario->getRole() != 'CLIENTE') {
            $negocio_rep = $this->getDoctrine()->getRepository(Negocio::class);
            $negocios = $negocio_rep->findAll();

            for ($i = 0; $i < count($negocios); $i++) {
                if ($negocios[$i]->getUsuario()->getId() == $usuario->getId()) {
                    $tikr = $this->getDoctrine()->getRepository(Tiquet::class);
                    $tik = $tikr->findAll();
                    for ($j = 0; $j < count($tik); $j++) {
                        if ($tik[$j]->getNegocio()->getId() == $negocios[$i]->getId()) {
                            $em->remove($tik[$j]);
                        }
                    }
                    $em->remove($negocios[$i]);
                }
            }


            /*
              if(count($negocios)>0){

              return $this->redirectToRoute('listar_negocios');
              }

             */
        }

        //
        //
        //
        //
        
        //se elimina usuario

        $em->remove($usuario);
        $em->flush();
        

        return $this->redirectToRoute('index');
    }

    public function edit(Request $request, UserInterface $user, Usuario $usuario) {

        if (!$user) {
            return $this->redirectToRoute('login');
        }

        if ($user->getRole() != 'ADMINISTRADOR' and $user->getId() != $usuario->getId()) {
            return $this->redirectToRoute('index');
        }

        if ($user->getRole() == 'ADMINISTRADOR') {

            $form = $this->createForm(RegisterType_1::class, $usuario);
        } else {
            $form = $this->createForm(RegisterType::class, $usuario);
        }
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $em = $this->getDoctrine()->getManager();
            $em->persist($usuario);
            $em->flush();

            return $this->redirectToRoute('index');
        }


        return $this->render('usuario/creation.html.twig', [
                    'edit' => true,
                    'form' => $form->createView()
        ]);
    }

    public function editPasswd(Request $request, UserInterface $user, Usuario $usuario, UserPasswordEncoderInterface $encoder) {

        if (!$user) {
            return $this->redirectToRoute('login');
        }

        if ($user->getRole() != 'ADMINISTRADOR' and $user->getId() != $usuario->getId()) {
            return $this->redirectToRoute('index');
        }

        if ($user->getRole() == 'ADMINISTRADOR' || $user->getId() == $usuario->getId()) {

            $form = $this->createForm(changePassWD::class, $usuario);
        } else {
            $form = $this->createForm(RegisterType::class, $usuario);
        }
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //cifrando la contraseña
            $encoded = $encoder->encodePassword($usuario, $usuario->getPassword());
            $usuario->setPassword($encoded);

            $em = $this->getDoctrine()->getManager();
            $em->persist($usuario);
            $em->flush();

            return $this->redirectToRoute('index');
        }


        return $this->render('usuario/changepass.html.twig', [
                    'edit' => true,
                    'form' => $form->createView()
        ]);
    }

    public function resetPass(Request $request, UserPasswordEncoderInterface $encoder, \Swift_Mailer $mailer) {


        $form = $this->createForm(giveEmail::class);
        $form->handleRequest($request);
        $email = "";
        $pass = "";

        $mailAdmin = 'colasdeusuario@gmail.com';
        $mailval = false;

        $usuario_rep = $this->getDoctrine()->getRepository(Usuario::class);
        $usuarios = $usuario_rep->findAll();

        $usuario = $usuarios[0];
        if ($form->isSubmitted() && $form->isValid()) {

            $email = $form->get("email")->getData();

            for ($i = 0; $i < count($usuarios); $i++) {
                $mail = $usuarios[$i]->getEmail();
                if ($mail == $email) {
                    $mailval = true;
                    $usuario = $usuarios[$i];
                    $pass = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 5);

                    break;
                }
            }

            if ($mailval) {

                //cifrando la contraseña
                $encoded = $encoder->encodePassword($usuario, $pass);
                $usuario->setPassword($encoded);

                $em = $this->getDoctrine()->getManager();
                $em->persist($usuario);
                $em->flush();
////


                /*
                 * Envio del correo
                 */

              
               
                  $message = (new \Swift_Message('Nueva Clave'))
                        ->setFrom($mailAdmin)
                        ->setTo($email)
                        ->setBody(
                          
                            $this->renderView(
                                'usuario/nuevapass.html.twig',

                                ['pass' => $pass]
                            ),
                            'text/plain'

                  );
               
                $mailer->send($message);
                
                return $this->redirectToRoute('login');
            }
        }


        return $this->render('usuario/giveMeEmail.html.twig', [
                    'edit' => true,
                    'form' => $form->createView()]);
    }

}
