<?php declare(strict_types = 1);

namespace PeckaDesk\Dashboard\Presenters;

final class FilePresenter extends \Nette\Application\UI\Presenter
{

	private \PeckaDesk\Model\Files\FileStorageInterface $fileStorage;


	public function __construct(
		\PeckaDesk\Model\Files\FileStorageInterface $fileStorage
	)
	{
		parent::__construct();
		$this->fileStorage = $fileStorage;
	}


	public function renderDefault(\PeckaDesk\Model\Files\File $file): void
	{
		$format = NULL;
		$image = \Nette\Utils\Image::fromString($this->fileStorage->get($file), $format);
		$image->send($format ?? \Nette\Utils\Image::JPEG);
	}

}
