<?php declare(strict_types = 1);

namespace PeckaDesk\Model\Files;

interface FileStorageInterface
{

	public function save(File $file, \Nette\Http\FileUpload $fileUpload): void;


	public function get(File $file): ?string;

}
