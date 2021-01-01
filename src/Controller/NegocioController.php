<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


use App\Entity\Negocio;
use App\Entity\Usuario;
use Symfony\Component\HttpFoundation\Request;
use App\Form\NegocioType;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Entity\Tiquet;

class NegocioController extends AbstractController
{
    /**
     * @Route("/negocio", name="negocio")
     */
    public function index()
    {
        return $this->render('negocio/index.html.twig', [
            'controller_name' => 'NegocioController',
        ]);
    }
    
    
    public function creation(Request $request, UserInterface $user) {
         if(!$user){
            return $this->redirectToRoute('login');
            
        }

        $negocio = new Negocio();
        $form = $this->createForm(NegocioType::class, $negocio);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $negocio->setCreateAt(new \DateTime('now'));
            $negocio->setUsuario($user);

            $em = $this->getDoctrine()->getManager();
            $em->persist($negocio);
            $em->flush();

            return $this->redirect(
                            $this->generateUrl('index', [])
            );
        }

        return $this->render('negocio/creation.html.twig', [
                    'form' => $form->createView()
        ]);
    }
    
    public function ListadoComercios() {
        $negocios_rep = $this->getDoctrine()->getRepository(Negocio::class);
        $negocios = $negocios_rep->findAll();

        return $this->render('negocio/listado_negocios.html.twig', [
                    'negocios' => $negocios
        ]);
    }
    
    public function ListadoComercios_turnos() {
        $negocios_rep = $this->getDoctrine()->getRepository(Negocio::class);
        $negocios = $negocios_rep->findAll();

        return $this->render('negocio/NegociosVendedor.html.twig', [
                    'negocios' => $negocios
        ]);
    }
    
    public function edit(Request $request,UserInterface $user, Negocio $negocio) {
       
        if(!$user){
            return $this->redirectToRoute('login');
            
        }
        
       if($user->getRole()!='ADMINISTRADOR' and $user->getId()!=$negocio->getUsuario()->getId()){
            return $this->redirectToRoute('index');
        }
        $form = $this->createForm(NegocioType::class, $negocio);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($negocio);
            $em->flush();

            return $this->redirectToRoute('index');
        }
        return $this->render('negocio/edit.html.twig', [
                    'edit' => true,
                    'form' => $form->createView()
        ]);
    }
    
    public function eliminar(UserInterface $user, Negocio $negocio){
        if(!$user){
            return $this->redirectToRoute('login');
            
        }
       if($user->getRole()!='ADMINISTRADOR' and $user->getId()!=$negocio->getUsuario()->getId()){
            return $this->redirectToRoute('index');
        }
        
        $tiquet_rep = $this->getDoctrine()->getRepository(Tiquet::class);
        $tiquets = $tiquet_rep->findAll();
        $em=$this->getDoctrine()->getManager();
        for($i=0;$i<count($tiquets);$i++ ){
          if($tiquets[$i]->getNegocio()->getId()==$negocio->getId()) {
              $em->remove($tiquets[$i]);
          } 
        }
        
        
        $em->remove($negocio);
        $em->flush();
        return $this->redirectToRoute('index');
        
     
    }
}
