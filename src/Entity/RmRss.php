<?php

namespace App\Entity;

use App\Repository\RmRssRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use function Symfony\Component\DependencyInjection\Loader\Configurator\ref;

/**
 * @ORM\Entity(repositoryClass=RmRssRepository::class)
 */
class RmRss
{
    
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $rmRssId;

    
    /**
     * @ORM\Column(type="string", length=1000, nullable=true)
     */
    private $title;


    /**
     * @ORM\Column(type="string", length=1000, nullable=true)
     */
    private $description;


     /**
     * @ORM\Column(type="text", length=20000, nullable=true)
     */
    private $content;


    /**
     * @ORM\Column(type="string", length=1000, nullable=true)
     */
    private $contentLink;


    //would have as date but due to time constraints easier to leave as string
     /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $pubDate;



    public function getRmRssId(): ?int
    {
        return $this->rmRssId;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }


    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;

        return $this;
    }


    public function getContentLink(): ?string
    {
        return $this->contentLink;
    }

    public function setContentLink(?string $contentLink): self
    {
        $this->contentLink = $contentLink;

        return $this;
    }


    public function getPubDate(): ?string
    {
        return $this->pubDate;
    }

    public function setPubDate(?string $pubDate): self
    {
        $this->pubDate = $pubDate;

        return $this;
    }

  
}
