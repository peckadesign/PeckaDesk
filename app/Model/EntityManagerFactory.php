<?php declare(strict_types = 1);

namespace PeckaDesk\Model;

final class EntityManagerFactory
{

	/**
	 * @var array<string>
	 */
	private array $paths;

	private bool $debugMode;

	private string $proxyDir;

	private \Doctrine\DBAL\Connection $connection;


	/**
	 * @param array<string> $paths
	 */
	public function __construct(
		array $paths,
		bool $debugMode,
		string $proxyDir,
		\Doctrine\DBAL\Connection $connection
	)
	{
		$this->paths = $paths;
		$this->debugMode = $debugMode;
		$this->proxyDir = $proxyDir;
		$this->connection = $connection;
	}


	public function create(): \Doctrine\ORM\EntityManager
	{
		$config = \Doctrine\ORM\Tools\Setup::createAnnotationMetadataConfiguration($this->paths, $this->debugMode, $this->proxyDir, NULL, FALSE);

		return \Doctrine\ORM\EntityManager::create($this->connection, $config);
	}

}
