<?php declare(strict_types = 1);

namespace PeckaDesk\Dashboard\Files\Model;

final class FileFacade implements FileFacadeInterface
{

	private \Doctrine\ORM\EntityManagerInterface $entityManager;


	public function __construct(
		\Doctrine\ORM\EntityManagerInterface $entityManager
	)
	{
		$this->entityManager = $entityManager;
	}


	public function getById(int $id): \PeckaDesk\Model\Files\File
	{
		/** @var \PeckaDesk\Model\Files\File|null $file */
		$file = $this->entityManager->getRepository(\PeckaDesk\Model\Files\File::class)->find($id);

		if ($file === NULL) {
			throw new \PeckaDesk\Dashboard\Model\EntityNotFoundException();
		}

		return $file;
	}

}
