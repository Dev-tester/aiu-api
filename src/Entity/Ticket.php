<?php

namespace App\Entity;

use App\Repository\TicketRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TicketRepository::class)
 */
class Ticket
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=32)
     */
    private $serial;

	/**
	 * @var Seat/null
	 * @ORM\OneToOne(targetEntity="Seat")
	 */
	private $seat;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $placeFrom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $placeTo;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $surname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $company;

    /**
     * @ORM\Column(type="string", length=32)
     */
    private $passport_serial;

    /**
     * @ORM\Column(type="string", length=32)
     */
    private $passport_number;

    /**
     * @ORM\Column(type="string", length=32)
     */
    private $flight_number;

    /**
     * @ORM\Column(type="datetime")
     */
    private $flight_date;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="integer")
     */
    private $price;

	/**
	 * @ORM\Column(type="boolean", nullable=true)
	 */
	private $completed;

	public function getId(): ?int
    {
        return $this->id;
    }

    public function getSerial(): ?string
    {
        return $this->serial;
    }

    public function setSerial(string $serial): self
    {
        $this->serial = $serial;

        return $this;
    }

	/**
	 * @return Seat|null
	 */
	public function getSeat(): ?Seat
	{
		return $this->seat;
	}

	/**
	 * @param Seat|null $seat
	 */
	public function setSeat(?Seat $seat): self
	{
		$this->seat = $seat;

		return $this;
	}

	public function getPlaceFrom(): ?string
    {
        return $this->placeFrom;
    }

    public function setPlaceFrom(string $placeFrom): self
    {
        $this->placeFrom = $placeFrom;

        return $this;
    }

    public function getPlaceTo(): ?string
    {
        return $this->placeTo;
    }

    public function setPlaceTo(string $placeTo): self
    {
        $this->placeTo = $placeTo;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(string $surname): self
    {
        $this->surname = $surname;

        return $this;
    }

    public function getCompany(): ?string
    {
        return $this->company;
    }

    public function setCompany(string $company): self
    {
        $this->company = $company;

        return $this;
    }

    public function getPassportSerial(): ?string
    {
        return $this->passport_serial;
    }

    public function setPassportSerial(string $passport_serial): self
    {
        $this->passport_serial = $passport_serial;

        return $this;
    }

    public function getPassportNumber(): ?string
    {
        return $this->passport_number;
    }

    public function setPassportNumber(string $passport_number): self
    {
        $this->passport_number = $passport_number;

        return $this;
    }

    public function getFlightNumber(): ?string
    {
        return $this->flight_number;
    }

    public function setFlightNumber(string $flight_number): self
    {
        $this->flight_number = $flight_number;

        return $this;
    }

    public function getFlightDate(): ?\DateTimeInterface
    {
        return $this->flight_date;
    }

    public function setFlightDate(\DateTimeInterface $flight_date): self
    {
        $this->flight_date = $flight_date;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt($created_at): self
    {
        $this->created_at = new \DateTime();

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

	/**
	 * @return bool|null
	 */
	public function getCompleted()
	{
		return $this->completed;
	}

	/**
	 * @param bool|null $completed
	 */
	public function setCompleted(?bool $completed): self
	{
		$this->completed = $completed;

		return $this;
	}
}
