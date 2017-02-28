<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Image
 *
 * @ORM\Table(name="images")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ImageRepository")
 * @ORM\HasLifeCycleCallbacks()
 */
class Image
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="fileName", type="string", length=30, unique=true)
     */
    private $fileName;

    /**
     * @var string
     * @ORM\Column(name="legend", type="string", length=255)
     */
    private $legend;

    /**
     * @var string
     *
     * @ORM\Column(name="credit", type="string", length=50)
     */
    private $credit;

    /**
     * @var UploadedFile
     * @Assert\File(
    maxSize="5M",
     *      maxSizeMessage="La taille maxi des images est 5Mo",
     *      mimeTypes={"image/jpeg", "image/png"},
     *      mimeTypesMessage = "Seuls les formats JPEG et PNG sont acceptés"
     * )
     *
     */
    private $uploadedFile;

    /**
     * @var string
     */
    private $basePath;

    private $toBeDeleted = false;

    public function toBeDeleted(){
        return $this->toBeDeleted;
    }

    public function setToBeDeleted($toBeDeleted){
        $this->toBeDeleted = $toBeDeleted;
        return $this;
    }

    /**
     * @return UploadedFile
     */
    public function getUploadedFile()
    {
        return $this->uploadedFile;
    }

    /**
     * @param UploadedFile $uploadedFile
     * @return Image
     */
    public function setUploadedFile($uploadedFile)
    {
        $this->uploadedFile = $uploadedFile;
        return $this;
    }

    /**
     * @return string
     */
    public function getBasePath()
    {
        return $this->basePath;
    }

    /**
     * @param string $basePath
     * @return Image
     */
    public function setBasePath($basePath)
    {
        $this->basePath = $basePath;
        return $this;
    }


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set fileName
     *
     * @param string $fileName
     * @return Image
     */
    public function setFileName($fileName)
    {
        $this->fileName = $fileName;

        return $this;
    }

    /**
     * Get fileName
     *
     * @return string 
     */
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * Set legend
     *
     * @param string $legend
     * @return Image
     */
    public function setLegend($legend)
    {
        $this->legend = $legend;

        return $this;
    }

    /**
     * Get legend
     *
     * @return string 
     */
    public function getLegend()
    {
        return $this->legend;
    }

    /**
     * Set credit
     *
     * @param string $credit
     * @return Image
     */
    public function setCredit($credit)
    {
        $this->credit = $credit;

        return $this;
    }

    /**
     * Get credit
     *
     * @return string 
     */
    public function getCredit()
    {
        return $this->credit;
    }

    /**
     * Attribution d'un nom unique au fichier
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload(){
        if($this->fileName == null && $this->uploadedFile != null){
            //Génération d'un nom unique
            $uniqueName = uniqid('image_');
            //Récupération de l'extension du fichier en fonction du MimeType
            $extension = $this->uploadedFile->guessExtension();
            $this->fileName = $uniqueName. '.'. $extension;
        }
    }

    /**
     * Suppression du fichier
     * @ORM\PostRemove()
     */
    public function removeUpload(){
        $path = $this->basePath.'/'.$this->fileName;
        if(file_exists($path)){
            unlink($path);
        }
    }

    /**
     * Téléversement (upload) de l'image
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload(){
        if($this->uploadedFile != null){
            // Suppression d'une éventuelle image pré-existante
            $this->removeUpload();
            // Déplacement de l'image du dossier de téléchagement temporaire
            // vers le dossier de destination
            $this->uploadedFile->move(
                $this->basePath,
                $this->fileName
            );

            $this->uploadedFile = null;
        }
    }

    /**
     * @Assert\True(message="La légende et le crédit doivent être renseignés")
     */
    public function hasLegendAndCredit(){
        $valid = false;
        $legendAndCreditOk = !empty($this->legend) && !empty($this->credit);

        $valid =  $valid || ($this->uploadedFile != null && $legendAndCreditOk);
        $valid =  $valid || ( !empty($this->fileName) && $legendAndCreditOk);
        $valid =  $valid || ( empty($this->fileName));

        return $valid;
    }

    public function mustBeDeleted(){
        return empty($this->fileName) && empty($this->uploadedFile);
    }
}
