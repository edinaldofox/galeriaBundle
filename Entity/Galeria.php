<?php
/**
 * Created by PhpStorm.
 * User: edinaldo
 * Date: 17/04/15
 * Time: 21:58
 */

namespace GaleriaBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="galerias")
 * @ORM\Entity(repositoryClass="GaleriaBundle\Entity\Repository\GaleriaRepository")
 */
class Galeria 
{

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=455)
     */
    protected $nome;

    /**
     * @ORM\Column(type="string", length=1048, nullable=true)
     */
    protected $descricao;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $isAtivo;

    /**
     * @ORM\ManyToMany(targetEntity="GaleriaImagens", cascade={"persist", "remove"})
     * @ORM\JoinTable(name="galeria_imagens",
     *      joinColumns={@ORM\JoinColumn(name="id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="imagens", referencedColumnName="id", unique=true)}
     *      )
     **/
    /*
     * @ORM\OneToMany(targetEntity="GaleriaImagens", mappedBy="galeria", cascade={"ALL"})
     **/
    protected $imagens;

    public function __construct() {
        $this->imagens = new ArrayCollection();
    }

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
        return $this;
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
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * @param mixed $descricao
     */
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getIsAtivo()
    {
        return $this->isAtivo;
    }

    /**
     * @param mixed $isAtivo
     */
    public function setIsAtivo($isAtivo)
    {
        $this->isAtivo = $isAtivo;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getImagens()
    {
        return $this->imagens;
    }

    /**
     * @param mixed $imagens
     */
    public function setImagens($imagens)
    {
        $this->imagens = $imagens;
        return $this;
    }

    public function addImagens(GaleriaImagens $imagens)
    {
        $this->imagens->add($imagens);
        return $this;
    }

    public function validaImagens()
    {
        $listaDeImagem = new ArrayCollection();
        foreach($this->imagens as $imagem) {
            if($imagem) {
                $listaDeImagem->add($imagem);
            }
        }
        $this->imagens = $listaDeImagem;
        return $this;
    }

}