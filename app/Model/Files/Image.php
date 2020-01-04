<?php declare(strict_types = 1);

namespace PeckaDesk\Model\Files;

/**
 * @\Doctrine\ORM\Mapping\Entity
 */
class Image extends File
{

	/**
	 * @\Doctrine\ORM\Mapping\Column(type="integer")
	 */
	private int $width;

	/**
	 * @\Doctrine\ORM\Mapping\Column(type="integer")
	 */
	private int $height;


	public function __construct(
		string $name,
		int $width,
		int $height
	)
	{
		parent::__construct($name);
		$this->width = $width;
		$this->height = $height;
	}


	public function getWidth(): int
	{
		return $this->width;
	}


	public function getHeight(): int
	{
		return $this->height;
	}

}
