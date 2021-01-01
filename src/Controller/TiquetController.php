<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Entity\Tiquet;
use App\Entity\Negocio;
use App\Form\TiqueType;
use App\Entity\Usuario;
use Symfony\Component\HttpFoundation\Request;

//require dirname(__DIR__).'/vendor/autoload.php';

use Spipu\Html2Pdf\Html2Pdf;
class TiquetController extends AbstractController
{
    /**
     * @Route("/tiquet", name="tiquet")
     */
    public function index()
    {
        return $this->render('tiquet/index.html.twig', [
            'controller_name' => 'TiquetController',
        ]);
    }
    private function generaCodigo($length){
        $clave=substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
        
        $repetido=true;
        $tiquet_rep = $this->getDoctrine()->getRepository(Tiquet::class);
        $tiquets = $tiquet_rep->findAll();
        while($repetido){
            $repetido=false;
            foreach ($tiquets as $tiquet) {
                $cod=$tiquet->getCodigo();
                if ($cod==$clave){
                    $repetido=true;
                    $clave=substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
                    break;
                }
            }
        }
        return $clave;
    }

    public function sacarTiquet(Negocio $negocio,UserInterface $user) {
        
        
        if(!$user){
            return redirectToRoute('login');
        }
        $tiquet=new Tiquet();
        
        
        //$tiquet->setCodigo(random_bytes(6));
        
        $tiquet->setCodigo($this->generaCodigo(5));
        $tiquet->setEstado("EN ESPERA");
        $tiquet->setCreateAt(new \DateTime());
        
        $tiquet->setNegocio($negocio);
        $tiquet->setUsuario($user);
        
        
        $em=$this->getDoctrine()->getManager();
        $em->persist($tiquet);
       
        
        $em->flush();
        
        
        return $this->redirectToRoute('index');
        
        
    }
    
    public function misTiquets(UserInterface $user) {
        
         if(!$user){
            return $this->redirectToRoute('login');
            
        }
        $tiquets = $user->getTiquet();

        return $this->render('tiquet/listadotiquets.html.twig', [
                    'tiquets' => $tiquets,
                    'user'=>$user
        ]);
    }
    
    public function listadotiquets(){
        $tiquet_rep = $this->getDoctrine()->getRepository(Tiquet::class);
        $tiquets = $tiquet_rep->findAll();

        return $this->render('tiquet/listadotiquets.html.twig', [
                    'tiquets' => $tiquets
                    
        ]);
    }
    
    public function TiquetsCliente(){
        $tiquet_rep = $this->getDoctrine()->getRepository(Tiquet::class);
        $tiquets = $tiquet_rep->findAll();

        return $this->render('tiquet/susTiquets.html.twig', [
                    'tiquets' => $tiquets
                    
        ]);
    }
    
   


    public function VerTurnos(Negocio $negocio){
        
        $tiquets = $negocio->getTiquet();

        return $this->render('tiquet/vistaTurnos.html.twig', [
                    'tiquets' => $tiquets
                    
        ]);
    }
    
    public function eliminar(UserInterface $user,Tiquet $tiquet){
        if(!$user){
            return $this->redirectToRoute('login');
            
        }
       if($user->getRole()!='ADMINISTRADOR' and $user->getId()!=$tiquet->getUsuario()->getId() and $user->getId()!=$tiquet->getNegocio()->getUsuario()->getId()){
            return $this->redirectToRoute('index');
        }
        $em=$this->getDoctrine()->getManager();
        $em->remove($tiquet);
        $em->flush();
        return $this->redirectToRoute('index');
        
     
    }
    public function edit(Request $request,UserInterface $user, Tiquet $tiquet) {
       
        if(!$user){
            return $this->redirectToRoute('login');
            
        }
        
       if($user->getRole()!='ADMINISTRADOR' and $user->getId()!=$tiquet->getUsuario()->getId() and $user->getId()!=$tiquet->getNegocio()->getUsuario()->getId()){
            return $this->redirectToRoute('index');
        }
        $form = $this->createForm(TiqueType::class, $tiquet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            

            $em = $this->getDoctrine()->getManager();
            $em->persist($tiquet);
            $em->flush();

            return $this->redirectToRoute('index');
        }
        return $this->render('tiquet/creation.html.twig', [
                    'edit' => true,
                    'form' => $form->createView()
        ]);
    }
    
    
    function  imprimir(Tiquet $tiquet){
        
        
        $vistaTiquet=$this->render('tiquet/impresion.html.twig',[
                'tiquet' =>$tiquet
                
                ]);
        
        $html2pdf = new Html2Pdf('P', array(50,100), 'en', true, 'UTF-8', array(0, 0, 0, 0));
        $html2pdf->writeHTML($vistaTiquet);
        $html2pdf->output();
        return $this->redirectToRoute('index');
    }
    /*
    function  imprimir(UserInterface $user,Tiquet $tiquet){
        
        
        if(!$user){
            return $this->redirectToRoute('login');
            
        }
       if($user->getRole()!='ADMINISTRADOR' and $user->getId()!=$tiquet->getUsuario()->getId() and $user->getId()!=$tiquet->getNegocio()->getUsuario()->getId()){
            return $this->redirectToRoute('index');
        }
        
        
        
        $vistaTiquet=$this->render('tiquet/impresion.html.twig',[
                'tiquet' =>$tiquet
                
                ]);
        
        $html2pdf = new Html2Pdf('P', array(50,100), 'en', true, 'UTF-8', array(0, 0, 0, 0));
        $html2pdf->writeHTML($vistaTiquet);
        $html2pdf->output();
        return $this->redirectToRoute('index');
    }*/
}
