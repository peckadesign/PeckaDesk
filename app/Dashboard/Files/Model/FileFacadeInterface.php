<?php declare(strict_types = 1);

namespace PeckaDesk\Dashboard\Files\Model;

interface FileFacadeInterface
{

	/**
	 * @throws \PeckaDesk\Dashboard\Model\EntityNotFoundException
	 */
	public function getById(int $id): \PeckaDesk\Model\Files\File;

}
