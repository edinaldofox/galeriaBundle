<?php
/**
 * Created by PhpStorm.
 * User: edinaldo
 * Date: 17/04/15
 * Time: 21:58
 */

namespace GaleriaBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="galeria_imagen")
 */
class GaleriaImagens
{

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $nome;

    /*
     * @ORM\ManyToOne(targetEntity="Galeria", inversedBy="features")
     * @ORM\JoinColumn(name="galeria_id", referencedColumnName="id")
     **/
    protected $galeria;

    protected $file;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * @param mixed $nome
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    /**
     * @return mixed
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param File $file
     */
    public function setFile($file)
    {

        if (null !== $file) {
            // do whatever you want to generate a unique name
            $filename = sha1(uniqid(mt_rand(), true));
            $imagem = $filename.'.'.$file->guessExtension();
        }

        $file->move(__DIR__.'/../../../web/bundles/galeria/imagens/', $imagem);

        $this->nome = $imagem;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getGaleria()
    {
        return $this->galeria;
    }

    /**
     * @param mixed $galeria
     */
    public function setGaleria($galeria)
    {
        $this->galeria = $galeria;
    }


}