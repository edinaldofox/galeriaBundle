<?php

namespace GaleriaBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use GaleriaBundle\Entity\Galeria;
use GaleriaBundle\Entity\GaleriaImagens;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class DefaultController extends Controller
{

    public function cadastroAction()
    {

        $galeria = new Galeria();
        $galeria->addImagens(new GaleriaImagens());

        $form = $this->createForm('galeria', $galeria, [
            'action' => $this->generateUrl('galeria_create')
        ]);

        return $this->render('GaleriaBundle:Default:cadastro.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function createAction(Request $request)
    {
        $galeria = new Galeria();

        $form = $this->createForm('galeria', $galeria);
        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();

            $em->persist($form->getData());
            $em->flush();
            $this->addFlash('notice',$this->formSucesso());
        } else {
            $this->addFlash('notice', $this->formErro());
        }

        return $this->redirectToRoute('galeria_cadastro');
    }

    /**
     * @ParamConverter("galeria", class="GaleriaBundle:Galeria", options={"id" = "galeria"})
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editarAction(Request $request, Galeria $galeria)
    {

        $form = $this->createForm('galeria', $galeria, [
            'action' => $this->generateUrl('galeria_edit')
        ]);

        return $this->render('GaleriaBundle:Default:editar.html.twig', [
            'galeria' => $galeria,
            'form' => $form->createView()
        ]);
    }

    public function editAction(Request $request)
    {
        $galeriaRequest = $request->request->get('galeria');

        $em = $this->getDoctrine()->getManager();
        $galeria = $em->getRepository('GaleriaBundle:Galeria')->findOneById($galeriaRequest['id']);

        $form = $this->createForm('galeria', $galeria);
        $form->handleRequest($request);

        if ($form->isValid()) {

            $form->getData()->validaImagens();

            $em->flush();

            $this->addFlash('notice', $this->formSucesso());
        } else {
            $this->addFlash('notice', $this->formErro());
        }

        return $this->redirectToRoute('galeria_editar', ['galeria' => $galeria->getId()]);
    }

    public function deleteImagemAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $galeria = $em->getRepository('GaleriaBundle:Galeria')->findOneById($request->request->get('galeria'));

        $novaListaDeImagens = new ArrayCollection();
        foreach ($galeria->getImagens() as $imagen) {

            if ($imagen->getId() != $request->request->get('imagem')) {
                $novaListaDeImagens->add($imagen);
            } else {
                try {
                    $fs = new Filesystem();
                    $fs->remove(array('symlink', __DIR__ . '/../../../web/bundles/galeria/imagens/' . $imagen->getNome()));
                } catch (IOExceptionInterface $e) {
                    echo "An error occurred while creating your directory at " . $e->getPath();
                    exit;
                }
            }

        }

        $galeria->setImagens($novaListaDeImagens);

        $em->persist($galeria);
        $em->flush();

        return new JsonResponse($this->formSucesso());
    }

    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();

        $galerias = $em->getRepository('GaleriaBundle:Galeria')->findAll();

        return $this->render('GaleriaBundle:Default:lista.html.twig', [
            'galerias' => $galerias
        ]);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $galeria = $em->getRepository('GaleriaBundle:Galeria')->findOneById($request->attributes->get('galeria'));

        $galeria->setIsAtivo(false);
        $em->flush();

        return $this->redirectToRoute('galeria_listagem');
    }

    protected function formSucesso()
    {
        return [
            'messagem' => 'Dados salvo com sucesso!',
            'alert' => 'success'
        ];
    }

    protected function formErro()
    {
        return [
            'messagem' => 'Formulario incorreto!',
            'alert' => 'danger'
        ];
    }
}
